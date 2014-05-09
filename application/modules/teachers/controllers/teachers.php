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
		$data['teachers'] = $user->where('user_type_id = 10 and nursery_id = '.user_login()->nursery_id)->order_by('id','desc')->get_page();
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
		$data['teacher'] = new User($id);
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
		redirect('teachers');
	}
	
	function delete($id=false){
		if($id){
			$teacher = new User($id);
			$teacher->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>