<?php
class Classrooms extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$classroom = new Classroom();
		if(user_login()->user_type_id == 9 or user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7){ //เจ้าหน้าที่ศูนย์ & สาธารณะสุข
			$classroom->where('nursery_id = '.$_GET['nursery_id']);
		}elseif(user_login()->user_type_id == 10){ //เจ้าหน้าที่ครู ผู้ดูแลเด็ก
			$classroom->where('user_id = '.user_login()->id);
		}
		$data['classes'] = $classroom->order_by('id','desc')->get_page();
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
		$data['classroom'] = new Classroom($id);
		if($id != ""){
			$child = new Classroom_detail();
			$data['childs'] = $child->where("classroom_id = ".$id)->order_by('id','desc')->get();
		}
		$this->template->build('form',$data);
	}
	
	function save($id=false){
		if($_POST){
			$classroom = new Classroom($id);
            $classroom->from_array($_POST);
            $classroom->save();
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('classrooms?nursery_id='.$_POST['nursery_id']);
	}
	
	function delete($id=false){
		if($id){
			$classroom = new Classroom($id);
			$classroom->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function childform($room_id,$id=false){
		$data['classroom'] = new Classroom($room_id);
		$data['child'] = new Classroom_detail($id);
		
		$this->template->build('childform',$data);
	}
	
	function childsave(){
		if($_POST){
			$child = new Classroom_detail($id);
            $child->from_array($_POST);
            $child->save();
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('classrooms/form/'.$_POST['classroom_id']);
	}
	
	function list_guest($nursery_id){
		$data['nursery_id'] = $nursery_id;
		$classroom = new Classroom();
		$classroom->where('nursery_id = '.$nursery_id);
		$data['classes'] = $classroom->order_by('id','desc')->get_page();
    	$this->template->build('list_guest',$data);
	}
	
	function view($id){
		$data['rs'] = new Classroom($id);
		$this->template->build('view',$data);
	}
	
	function form_detail($classroom_id=false,$id=false){
		$data['classroom'] = new Classroom($classroom_id);
		$this->template->build('form_detail',$data);
	}
}
?>