<?php
class Teachers extends Public_Controller{
    
    function __construct(){
    	if(user_login()->m_status != "active"){
			set_notify('error', 'สถานะของผู้ใช้งานไม่ได้รับอนุญาติ');
			redirect('home');
		}
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$user = new User();
		if(@$_GET['name'])$user->where("name like '%".$_GET['name']."%'");
		if(@$_GET['email'])$user->where("email like '%".$_GET['email']."%'");
		if(@$_GET['m_status'])$user->where("m_status = '".$_GET['m_status']."'");
		$data['teachers'] = $user->where('user_type_id = 10 and nursery_id = '.$_GET['nursery_id'])->order_by('id','desc')->get_page();
		// $data['teachers']->check_last_query();
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
		$data['teacher'] = new User($id);
		$data['nursery'] = new Nursery($_GET['nursery_id']);
		$this->template->build('form',$data);
	}
	
	function save($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				$teacher = new User($id);
	            $teacher->from_array($_POST);
	            $teacher->save();
	            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
			}
		}
		redirect($_POST['referer']);
	}
	
	function delete($id=false){
		if($id){
			$teacher = new User($id);
			$teacher->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function list_guest(){
		$data['nursery_id'] = $_GET['nursery_id'];
		$user = new User();
		$data['teachers'] = $user->where('user_type_id = 10 and nursery_id = '.$data['nursery_id'])->order_by('id','desc')->get_page();
		$this->template->build('list_guest',$data);
	}
}
?>