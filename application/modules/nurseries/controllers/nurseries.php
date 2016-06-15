<?php
class Nurseries extends Public_Controller
{
	function __construct()
	{
		if(user_login()->user_type_id!=1 and user_login()->user_type_id!=6 and user_login()->user_type_id!=7 and user_login()->user_type_id!=8 or user_login()->m_status != "active"){
			set_notify('error', 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ค่ะ');
			redirect('home');
		}
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index()
	{
		$this->template->set_layout('blank');
		$this->template->build('child');
	}

	function register(){
		$this->template->set_layout('blank');

		if(@$_GET['search']==1){ //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล

	        $condition = " 1=1 ";
			if(@$_GET['nursery_category_id']){
				$condition .= " and v_nurseries.nursery_category_id = ".$_GET['nursery_category_id'];
			}
			if(@$_GET['nursery_type']){
				$condition .= " and v_nurseries.nursery_type = ".$_GET['nursery_type'];
			}
			if(@$_GET['id']){
				$condition .= " and v_nurseries.id = ".$_GET['id'];
			}
			if(@$_GET['name']){
				$condition .= " and v_nurseries.name like '%".$_GET['name']."%'";
			}
			if(@$_GET['area_id']){
				$condition .= " and area_provinces_detail.area_id = ".$_GET['area_id'];
			}
			if(@$_GET['province_id']){
				$condition .= " and area_provinces_detail.province_id = ".$_GET['province_id'];
			}
			if(@$_GET['amphur_id']){
				$condition .= " and v_nurseries.amphur_id = ".$_GET['amphur_id'];
			}
			if(@$_GET['district_id']){
				$condition .= " and v_nurseries.district_id = ".$_GET['district_id'];
			}
			if(@$_GET['year']){
				$condition .= " and v_nurseries.created LIKE '".($_GET['year']-543)."%'";
			}
			if(@$_GET['start_date'] and @$_GET['end_date']){
				$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
				$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	
				$condition .= " and v_nurseries.created between ".$start_date." and ".$end_date;
			}
			if(@$_GET['start_date'] and @empty($_GET['end_date'])){
				$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
	
				$condition .= " and v_nurseries.created >= ".$start_date;
			}
			if(@$_GET['end_date'] and @empty($_GET['start_date'])){
				$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	
				$condition .= " and v_nurseries.created >= ".$end_date;
			}
			
			$condition2 = $condition;
	
			switch (@$_GET['status']) {
			    case 1: // ผ่านเกณฑ์
					$condition .= " and v_nurseries.assessment_status = 1 ";
			        break;
			    case 2: // ไม่ผ่านเกณฑ์ (ประเมินแล้วแต่ไม่ผ่าน)
					$condition .= " and v_nurseries.assessment_status = 2 ";
			        break;
				case 3: // รอการประเมิน
			        $condition .= " and v_nurseries.assessment_status = 0";
			        break;
				case 4: // เข้าร่วมโครงการ
					$condition .= "";
			        break;
				case 5: // หมดอายุแล้ว
					$condition .= " and v_nurseries.assessment_status = 1 and v_nurseries.assessment_approve_type < ".(date("Y")+545);
			        break;
			}
	
			// ข้อมูลศูนย์เด็กเล็ก
			$sql = "	SELECT
							v_nurseries.id,
							v_nurseries.name,
							v_nurseries.p_title,
							v_nurseries.p_name,
							v_nurseries.p_surname,
							v_nurseries.created,
							v_nurseries.user_id,
							v_nurseries.assessment_status,
							v_nurseries.assessment_approve_type,
							v_nurseries.assessment_approve_year,
							v_nurseries.assessment_approve_date,
							v_nurseries.assessment_approve_user_id,
							v_nurseries.assessment_total,
							area_provinces_detail.name province_name,
							amphures.amphur_name,
							districts.district_name
						FROM
							v_nurseries
						LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
						LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
						LEFT JOIN districts ON v_nurseries.district_id = districts.id
						WHERE ".$condition." order by v_nurseries.id desc";
			
			// echo $sql;
			$nursery = new Nursery();
	        $data['nurseries'] = $nursery->sql_page($sql, 20);
			$data['pagination'] = $nursery->sql_pagination;
	
			// นับจำนวนศูนย์เด็กเล็ก
			$sql = "	SELECT
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2." and v_nurseries.assessment_status = 1
						) pass,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2." and v_nurseries.assessment_status = 2
						) not_pass,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2." and v_nurseries.assessment_status = 0
						) wait,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2."
						) total
						";
	
			$data['count'] = $this->db->query($sql)->row_array();
			// var_dump($data['count']);
	
			// echo $sql;

		} //endif search=1

		$this->template->build('child_register',@$data);
	}

	function register_form($id=false){
		$this->template->set_layout('blank');
		$data['nursery'] = new V_Nursery($id);
		$this->template->build('child_register_form',$data);
	}

	function register_save($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){

				if($id == ""){
					$nuchk = new Nursery();
					$nuchk = $nuchk->where('name like "%'.$_POST['name'].'%" and district_id = '.$_POST['district_id'])->get()->result_count();
					if($nuchk > 0){
						set_notify('error', 'ชื่อศูนย์เด็กเล็กนี้มีแล้วค่ะ');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				
				$_POST['area_province_id'] = get_area_province_id(9,$_POST['province_id']);
				
				$_POST['user_id'] = $this->session->userdata('id'); // ไอดีเจ้าหน้าที่ที่แอด nursery
				//$_POST['area_id'] = login_data('nursery');
				$nursery = new Nursery($id);
				$nursery->from_array($_POST);
				$nursery->save();
				set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect('nurseries/register');
		}
	}

	function delete($id=false){
		if($id){
			$nursery = new Nursery($id);
			$nursery->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect('nurseries/register');
	}

	function estimate(){
		$this->template->set_layout('blank');


		if(@$_GET['search']==1){ //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล

			$condition = " 1=1 ";
			if(@$_GET['nursery_category_id']){
				$condition .= " and v_nurseries.nursery_category_id = ".$_GET['nursery_category_id'];
			}
			if(@$_GET['nursery_type']){
				$condition .= " and v_nurseries.nursery_type = ".$_GET['nursery_type'];
			}
			if(@$_GET['id']){
				$condition .= " and v_nurseries.id = ".$_GET['id'];
			}
			if(@$_GET['name']){
				$condition .= " and v_nurseries.name like '%".$_GET['name']."%'";
			}
			if(@$_GET['area_id']){
				$condition .= " and area_provinces_detail.area_id = ".$_GET['area_id'];
			}
			if(@$_GET['province_id']){
				$condition .= " and area_provinces_detail.province_id = ".$_GET['province_id'];
			}
			if(@$_GET['amphur_id']){
				$condition .= " and v_nurseries.amphur_id = ".$_GET['amphur_id'];
			}
			if(@$_GET['district_id']){
				$condition .= " and v_nurseries.district_id = ".$_GET['district_id'];
			}
			if(@$_GET['year']){
				// $condition .= " and v_nurseries.created LIKE '".($_GET['year']-543)."%'";
				$condition .= " and v_nurseries.year = ".$_GET['year'];
			}
	
			$condition2 = $condition;
	
			if(@$_GET['status'] != ""){
				$condition .= " and v_nurseries.assessment_status = ".$_GET['status'];
			}

	
			// ข้อมูลศูนย์เด็กเล็ก
			$sql = "	SELECT
							v_nurseries.id,
							v_nurseries.name,
							v_nurseries.p_title,
							v_nurseries.p_name,
							v_nurseries.p_surname,
							v_nurseries.created,
							v_nurseries.user_id,
							v_nurseries.year,
							v_nurseries.p_other,
							v_nurseries.assessment_status,
							v_nurseries.assessment_approve_type,
							v_nurseries.assessment_approve_year,
							v_nurseries.assessment_approve_date,
							v_nurseries.assessment_approve_user_id,
							v_nurseries.assessment_total,
							area_provinces_detail.name province_name,
							amphures.amphur_name,
							districts.district_name
						FROM
							v_nurseries
						LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
						LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
						LEFT JOIN districts ON v_nurseries.district_id = districts.id
						WHERE ".$condition." 
						ORDER BY v_nurseries.id desc";
	
			$nursery = new Nursery();
			$data['nurseries'] = $nursery->sql_page($sql, 20);
			$data['pagination'] = $nursery->sql_pagination;
			
			// echo $sql;
	
			// นับจำนวนศูนย์เด็กเล็ก
			$sql = "	SELECT
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2." and v_nurseries.assessment_status = 1
						) pass,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2." and v_nurseries.assessment_status = 2
						) not_pass,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
							LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
							LEFT JOIN districts ON v_nurseries.district_id = districts.id
							WHERE ".$condition2."  and v_nurseries.assessment_status = 0
						) wait
						";
	
			$data['count'] = $this->db->query($sql)->row_array();
			
			// echo "<br><br><br>".$sql;	
			
		}//endif search=1

		$this->template->build('child_estimate',@$data);
	}

	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),'','','--- เลือกอำเภอ ---');
		}
	}

	function get_district(){
		if($_POST){
			echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_POST['amphur_id'].' order by district_name asc'),'','','--- เลือกตำบล ---');
		}
	}

	function report(){ // เข้าร่วมโครงการ - ผ่านเกณ
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new Province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year']." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year']." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year']." (อำเภอ".$data['amphur']->amphur_name.")";
			$this->template->build('amphur_report',$data);
		}elseif(@$_GET['type'] == 4 ){ // ตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year']." (ตำบล".$data['district']->district_name.")";
			$this->template->build('amphur_report',$data);
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ";
		}
		$this->template->build('report',$data);
	}

	function report2(){ // จำนวนในพื้นที่ - เข้าร่วมโครงการ
		$this->template->build('report2');
	}

	function area_report($id=false){
		$data['provinces'] = new Province();
		$data['provinces']->where('area_id = '.$id)->get();
		$data['province_count'] = $data['provinces']->where('area_id = '.$id)->get()->result_count();
		$data['area_id'] = $id;
		$this->template->build('area_report',$data);
	}

	function province_report($id=false){
		$data['province'] = new Province($id);
		$data['amphurs'] = new Amphur();
		$data['amphurs']->where('province_id = '.$id)->get();
		$this->template->build('province_report',$data);
	}

	function amphur_report($id=false){
		$data['amphur'] = new Amphur($id);
		$data['districts'] = new District();
		$data['districts']->where('amphur_id = ',$id)->get();
		$this->template->build('amphur_report',$data);
	}

	function category_form($id=false){
		$data['category'] = new Nursery_category($id);

		$data['categories'] = new Nursery_category();
		$data['categories']->order_by('id','desc')->get();
		$this->template->build('category_form',$data);
	}

	function category_save($id=false){
		if($_POST){
			$category = new Nursery_category($id);
			$_POST['user_id'] = $this->session->userdata('id');
			$category->from_array($_POST);
			$category->save();
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('nurseries/category_form');
	}

	function category_delete($id=false){
		if($id){
			$nursery = new Nursery_category($id);
			$nursery->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect('nurseries/category_form');
	}


	function check_name()
	{
		$nuchk = new Nursery();
		if(@$_GET['district_id']){ $nuchk->where("district_id = ".$_GET['district_id']); }
		$nuchk = $nuchk->where('name like "%'.$_GET['name'].'"')->get()->result_count();
		echo ($nuchk > 0)?"false":"true";
	}

	function get_nursery_data(){
		if($_GET){
			$data['nursery'] = new V_nursery($_GET['id']);
			
			$data['assessments'] = new Assessment();
			$data['assessments']->where('nursery_id = '.$data['nursery']->id)->get();
			$this->load->view('child_estimate_form',$data);
		}
	}

	function get_nursery_data2(){
		if($_GET){
			$data['nursery'] = new Nursery($_GET['id']);
			$this->load->view('get_nursery_data',$data);
		}
	}

	function save_status($id=false){
		if($_POST){
			if($_POST['assessment_approve_year'] == ""){ // ปรับสถานะเป็นรอการประเมิน
				$_POST['status'] = 0;
				$this->db->query("DELETE FROM assessments WHERE nursery_id = ".$id);
			}else{
				$_POST['status'] = 1;
			}
			$_POST['assessment_approve_date'] = date("Y-m-d H:i:s");
			$_POST['assessment_approve_user_id'] = user_login()->id;
			$_POST['assessment_approve_type'] = 1; // 1 = แบบประเมินแบบเก่า, 2 = แบบประเมิน 35 ข้อ

			$nursery = new Nursery($id);
			$nursery->from_array($_POST);
			$nursery->save();
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
}
?>
