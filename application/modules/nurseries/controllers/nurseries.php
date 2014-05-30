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
        
		if(@$_GET['nursery_category_id'])$data['nurseries']->where("nursery_category_id = ".$_GET['nursery_category_id']);
		if(@$_GET['name'])$data['nurseries']->where("name like '%".$_GET['name']."%'");
		if(@$_GET['province_id'])$data['nurseries']->where('province_id',$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['nurseries']->where("district_id = ".$_GET['district_id']);
		if(@$_GET['year'])$data['nurseries']->where("year = ".$_GET['year']);
		// if(@$_GET['status'])$data['nurseries']->where("status = ".$_GET['status']);
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
		}
		
		if(user_login()->user_type_id==1 ){ // เป็น admin
			$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1")->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2")->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries")->result();
			$data['regis_count'] = $data['regis_count'][0]->total;
			
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==6){ // เจ้าหน้าที่สคร
			$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and area_id = ".user_login()->area_id)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2 and area_id = ".user_login()->area_id)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where area_id = ".user_login()->area_id)->result();
			$data['regis_count'] = $data['regis_count'][0]->total;
			
			$data['nurseries']->where_related_province('area_id = '.user_login()->area_id);
            $data['nurseries']->order_by('id','desc')->get_page();
        }elseif(user_login()->user_type_id==7){ // เจ้าหน้าที่จังหวัด
        	$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and province_id = ".user_login()->province_id)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and approve_type = 2 and province_id = ".user_login()->province_id)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where province_id = ".user_login()->province_id)->result();
			
            $data['nurseries']->where('province_id = '.user_login()->province_id);
            $data['nurseries']->order_by('id','desc')->get_page();
        }elseif(user_login()->user_type_id==8){ // เจ้าหน้าที่อำเภอ
        	$data['pass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 1 and amphur_id = ".user_login()->amphur_id)->result();
			$data['pass_count'] = $data['pass_count'][0]->total;
			$data['nopass_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where status = 0 and amphur_id = 2 and province_id = ".user_login()->amphur_id)->result();
			$data['nopass_count'] = $data['nopass_count'][0]->total;
            $data['regis_count'] = $this->db->query("SELECT COUNT(id) total FROM nurseries where amphur_id = ".user_login()->amphur_id)->result();
        	
            $data['nurseries']->where('amphur_id = '.user_login()->amphur_id);
            $data['nurseries']->order_by('id','desc')->get_page();
			// $data['regis_count'] = $data['nurseries']->paged->total_rows; //นับจำนวนทั้งหมดในทุกหน้า
        }
		$this->template->build('child_register',$data);
	}
	
	function register_form($id=false){
		$this->template->set_layout('blank');
		$data['nursery'] = new Nursery($id);
		$this->template->build('child_register_form',$data);
	}
	
	function register_save($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				if($id == ""){
					$nuchk = new Nursery();
					$nuchk = $nuchk->where('year = '.$_POST['year'].' and name = "'.$_POST['name'].'" and district_id = '.$_POST['district_id'])->get()->result_count();
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
	
	function estimate($status=false){
		$this->template->set_layout('blank');
		
		$data['nurseries'] = new Nursery();
		
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
			
			(@$status == 1)?$data['nurseries']->where("status = 1"):$data['nurseries']->where("status = 0");
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==6){ // เจ้าหน้าที่สคร
			$data['nurseries']->where_related_province('area_id = '.user_login()->area_id);
			
			$data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
		
			(@$status == 1)?$data['nurseries']->where("status = 1"):$data['nurseries']->where("status = 0");
			$data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==7){ // เจ้าหน้าที่จังหวัด
		
		    $data['nurseries']->where('province_id = '.user_login()->province_id);
			
			$data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
		    
		    $data['nurseries']->order_by('id','desc')->get_page();
		}elseif(user_login()->user_type_id==8){ // เจ้าหน้าที่อำเภอ
            $data['nurseries']->where('amphur_id = '.user_login()->amphur_id);
            
            $data['pass_count']  = $data['nurseries']->get_clone();
	        $data['pass_count']  = $data['pass_count']->where('status = 1')->get()->result_count();
			
			$data['regis_count'] = $data['nurseries']->get_clone();
			$data['regis_count']  = $data['regis_count']->where('status = 0')->get()->result_count();
			
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
		$nursery = new Nursery();
		$nursery->get_by_name($_GET['name']);
		echo ($nursery->name)?"false":"true";
	}
	
	function get_nursery_data(){
		if($_GET){
			$data['nursery'] = new Nursery($_GET['id']);
			$this->load->view('child_estimate_form',$data);
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