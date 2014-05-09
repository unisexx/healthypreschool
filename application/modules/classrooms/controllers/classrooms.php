<?php
class Classrooms extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$classroom = new Classroom();
		$data['classes'] = $classroom->where('user_id = '.user_login()->id)->order_by('id','desc')->get_page();
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
			
			$classroom = new Classroom();
			$classroom->order_by('id','desc')->get(1);
			
			$id = $id != '' ? $id : $classroom->id ; // ถ้า ไม่ใช่ฟอร์มแก้ไข เวลาเซฟให้ดึงไอดีล่าสุดมาใช้
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER'].'/'.$id);
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
}
?>