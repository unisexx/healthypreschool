<?php
class Childrens extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$child = new Classroom_detail();
		if(@$_GET['child_name']){ $child->where("child_name LIKE '%".$_GET['child_name']."%'"); }
		if(@$_GET['classroom_id']){ $child->where("classroom_id = ".$_GET['classroom_id']); }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ $child->where("age between ".$_GET['lowage']." and ".$_GET['hiage']); }
		if(@$_GET['bmi']){
			if($_GET['bmi'] == 1){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 20 and 24.9"); }
			if($_GET['bmi'] == 2){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 25 and 29.9"); }
			if($_GET['bmi'] == 3){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 30 and 34.9"); }
			if($_GET['bmi'] == 4){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 35 and 44.9"); }
			if($_GET['bmi'] == 5){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 45 and 49.9"); }
			if($_GET['bmi'] == 6){ $child->where("ROUND(weight / ((height/100) * (height/100)),2) between 50 and 9999"); }
		}
		$child->where('nursery_id = '.user_login()->nursery_id);
		if(user_login()->user_type_id == 10){ $child->where('classroom_id in (select id from classrooms where user_id = '.user_login()->id.')'); }
		$data['childs'] = $child->order_by('id','desc')->get();
    	$this->template->build('list',$data);
    }
	
	function form($id=false){
		$data['child'] = new Classroom_detail($id);
		$this->template->build('form',$data);
	}
	
	function save($id=false){
		if($_POST){
			$classroom = new Classroom_detail($id);
            $classroom->from_array($_POST);
            $classroom->save();
			
			$classroom_detail = new Classroom_detail();
			$classroom_detail->order_by('id','desc')->get(1);
			$classroom_detail_id = $classroom->id != '' ? $classroom->id : $classroom_detail->id ; // ถ้า ไม่ใช่ฟอร์มแก้ไข เวลาเซฟให้ดึงไอดีล่าสุดมาใช้
			
			$data['age'] = $_POST['age'];
			$data['height'] = $_POST['height'];
			$data['weight'] = $_POST['weight'];
			$data['classroom_detail_id'] = $classroom_detail_id;

			$bmi = new Bmi();
            $bmi->from_array($data);
            $bmi->save();
            
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('childrens');
	}
	
	function delete($id=false){
		if($id){
			$classroom = new Classroom_detail($id);
			$classroom->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function profile($id){
		$data['child'] = new Classroom_detail($id);
		
		$bmi = new Bmi();
		$data['bmis'] = $bmi->where('classroom_detail_id = '.$id)->order_by('id','desc')->get();
		
		$this->template->build('profile',$data);
	}
}
?>