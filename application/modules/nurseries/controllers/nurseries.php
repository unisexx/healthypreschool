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
		$data['nurseries'] = new Nursery();
        $condition = "";
		if(@$_GET['nursery_category_id']){
			$data['nurseries']->where("nursery_category_id = ".$_GET['nursery_category_id']);
			$condition .= " and nursery_category_id = ".$_GET['nursery_category_id'];
		}
		if(@$_GET['id']){
			$data['nurseries']->where('id',$_GET['id']);
			$condition .= " and id = ".$_GET['id'];
		}
		if(@$_GET['name']){
			$data['nurseries']->where("name like '%".$_GET['name']."%'");
			$condition .= " and name like '%".$_GET['name']."%'";
		}
		if(@$_GET['province_id']){
			$data['nurseries']->where('province_id',$_GET['province_id']);
			$condition .= " and province_id = ".$_GET['province_id'];
		}
		if(@$_GET['amphur_id']){
			$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
			$condition .= " and amphur_id = ".$_GET['amphur_id'];
		}
		if(@$_GET['district_id']){
			$data['nurseries']->where("district_id = ".$_GET['district_id']);
			$condition .= " and district_id = ".$_GET['district_id'];
		}
		if(@$_GET['year']){
			$data['nurseries']->where("nurseries.created LIKE '".($_GET['year']-543)."%'");
			$condition .= " and nurseries.created LIKE '".($_GET['year']-543)."%'";
		}
		if(@$_GET['start_date'] and @$_GET['end_date']){
			$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
			$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
			
			$data['nurseries']->where("created between ".$start_date." and ".$end_date);
			$condition .= " and created between ".$start_date." and ".$end_date;
		}
		if(@$_GET['start_date'] and @empty($_GET['end_date'])){
			$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
			
			$data['nurseries']->where("created >= ".$start_date);
			$condition .= " and created >= ".$start_date;
		}
		if(@$_GET['end_date'] and @empty($_GET['start_date'])){
			$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
			
			$data['nurseries']->where("created <= ".$end_date);
			$condition .= " and created >= ".$end_date;
		}
		
		switch (@$_GET['status']) {
		    case 1: // ผ่านเกณฑ์
		        $data['nurseries']->where("status = 1");
		        break;
		    case 2: // ไม่ผ่านเกณฑ์ (ประเมินแล้วแต่ไม่ผ่าน)
		        $data['nurseries']->where("status = 0")->where_related_assessment('total < 28');
		        break;
			case 3: // รอการประเมิน
		        $data['nurseries']->where("status = 0")->where_related_assessment('total IS NULL');
		        break;
			case 4: // หมดอายุ ระบบเก่า
		        $data['nurseries']->where("status = 1 and approve_type = 1 and approve_year < ".(date("Y")+540));
		        break;
			case 5: // หมดอายุ ระบบใหม่ ฟอร์ม 35 ข้อ
		        $data['nurseries']->where("status = 1 and approve_type = 2 and year(approve_date) < ".(date("Y")-3));
		        break;
		}
		
		if(user_login()->user_type_id==1 ){ // เป็น admin
			$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1".$condition)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2".$condition)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where 1=1 ".$condition)->result();
			$data['regis_count'] = $data['regis_count'][0]->total;
			
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==6){ // เจ้าหน้าที่สคร
			$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and area_id = ".user_login()->area_id.$condition)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2 and area_id = ".user_login()->area_id.$condition)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where area_id = ".user_login()->area_id.$condition)->result();
			$data['regis_count'] = $data['regis_count'][0]->total;
			
			$data['nurseries']->where_related_province('area_id = '.user_login()->area_id);
            $data['nurseries']->order_by('id','desc')->get_page();
        }elseif(user_login()->user_type_id==7){ // เจ้าหน้าที่จังหวัด
        
        	$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and province_id = ".user_login()->province_id.$condition)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2 and province_id = ".user_login()->province_id.$condition)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where province_id = ".user_login()->province_id.$condition)->result();
            $data['regis_count'] = $data['regis_count'][0]->total;
			
            $data['nurseries']->where('province_id = '.user_login()->province_id);
            $data['nurseries']->order_by('id','desc')->get_page();
			
        }elseif(user_login()->user_type_id==8){ // เจ้าหน้าที่อำเภอ
        	$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and amphur_id = ".user_login()->amphur_id.$condition)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and amphur_id = 2 and province_id = ".user_login()->amphur_id.$condition)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where amphur_id = ".user_login()->amphur_id.$condition)->result();
            $data['regis_count'] = $data['regis_count'][0]->total;
        	
            $data['nurseries']->where('amphur_id = '.user_login()->amphur_id);
            $data['nurseries']->order_by('id','desc')->get_page();
			// $data['regis_count'] = $data['nurseries']->paged->total_rows; //นับจำนวนทั้งหมดในทุกหน้า
        }
		
		// $data['nurseries']->check_last_query();
		$this->template->build('child_register',$data);
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
		
		$data['nurseries'] = new V_Nursery();
		
		if(@$_GET['nursery_category_id'])$data['nurseries']->where("nursery_category_id = ".$_GET['nursery_category_id']);
		if(@$_GET['name'])$data['nurseries']->where("name like '%".$_GET['name']."%'");
		if(@$_GET['province_id'])$data['nurseries']->where('province_id',$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['nurseries']->where("district_id = ".$_GET['district_id']);
		if(@$_GET['year'])$data['nurseries']->where("year = ".$_GET['year']);


		if(user_login()->user_type_id==1){ // แอดมินเห็นทั้งหมด
			$data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
			
			$data['nopass_count'] = $data['nurseries']->get_clone();
			$data['nopass_count'] = $data['nopass_count']->where_related_assessment('total < 28')->get()->result_count();
			
			if(@$_GET['status'] == 2){
				$data['nurseries']->where("status = 0")->where_related_assessment('total < 28');
			}elseif(@$_GET['status'] == 1){
				$data['nurseries']->where("status = 1");
			}else{
				$data['nurseries']->where("status = 0");
			}
			
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==6){ // เจ้าหน้าที่สคร
			$data['nurseries']->where_related_province('area_id = '.user_login()->area_id);
			
			$data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
			
			$data['nopass_count'] = $data['nurseries']->get_clone();
			$data['nopass_count'] = $data['nopass_count']->where_related_assessment('total < 28')->get()->result_count();
		
			if(@$_GET['status'] == 2){
				$data['nurseries']->where("status = 0")->where_related_assessment('total < 28');
			}elseif(@$_GET['status'] == 1){
				$data['nurseries']->where("status = 1");
			}else{
				$data['nurseries']->where("status = 0");
			}
			
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==7){ // เจ้าหน้าที่จังหวัด
		
		    $data['nurseries']->where('province_id = '.user_login()->province_id);
			
			$data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
			
			$data['nopass_count'] = $data['nurseries']->get_clone();
			$data['nopass_count'] = $data['nopass_count']->where_related_assessment('total < 28')->get()->result_count();
			
			if(@$_GET['status'] == 2){
				$data['nurseries']->where("status = 0")->where_related_assessment('total < 28');
			}elseif(@$_GET['status'] == 1){
				$data['nurseries']->where("status = 1");
			}else{
				$data['nurseries']->where("status = 0");
			}
		    
		    $data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==8){ // เจ้าหน้าที่อำเภอ
            $data['nurseries']->where('amphur_id = '.user_login()->amphur_id);
            
            $data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
			
			$data['nopass_count'] = $data['nurseries']->get_clone();
			$data['nopass_count'] = $data['nopass_count']->where_related_assessment('total < 28')->get()->result_count();
			
			if(@$_GET['status'] == 2){
				$data['nurseries']->where("status = 0")->where_related_assessment('total < 28');
			}elseif(@$_GET['status'] == 1){
				$data['nurseries']->where("status = 1");
			}else{
				$data['nurseries']->where("status = 0");
			}
			
            $data['nurseries']->order_by('id','desc')->get_page();
        }
		
		$this->template->build('child_estimate',$data);
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
			$data['nursery'] = new Nursery($_GET['id']);
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
			if($_POST['approve_year'] == ""){
				$_POST['status'] = 0;
			}else{
				$_POST['status'] = 1;
			}
			$_POST['approve_date'] = date("Y-m-d H:i:s");
			$_POST['approve_user_id'] = user_login()->id;
			$_POST['approve_type'] = 1; // 1 = แบบประเมินแบบเก่า, 2 = แบบประเมิน 35 ข้อ
			
			$nursery = new Nursery($id);
			$nursery->from_array($_POST);
			$nursery->save();
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>