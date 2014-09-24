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
		if(@$_GET['sex']){ $child->where("title = '".$_GET['sex']."'"); }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ $child->where("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) between ".$_GET['lowage']." and ".$_GET['hiage']); }
		
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
			$_POST['birth_date'] = Date2DB($_POST['birth_date']);
            $classroom->from_array($_POST);
            $classroom->save();
			
			// $classroom_detail = new Classroom_detail();
			// $classroom_detail->order_by('id','desc')->get(1);
			// $classroom_detail_id = $classroom->id != '' ? $classroom->id : $classroom_detail->id ; // ถ้า ไม่ใช่ฟอร์มแก้ไข เวลาเซฟให้ดึงไอดีล่าสุดมาใช้
// 			
			// $data['age'] = $_POST['age'];
			// $data['height'] = $_POST['height'];
			// $data['weight'] = $_POST['weight'];
			// $data['classroom_detail_id'] = $classroom_detail_id;
// 
			// $bmi = new Bmi();
            // $bmi->from_array($data);
            // $bmi->save();
            
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
		
		$data['bmi'] = new Bmi(@$_GET['id']);
		
		$bmi = new Bmi();
		$data['bmis'] = $bmi->where('classroom_detail_id = '.$id)->order_by('child_age_year','ace')->get();
		
		// $this->template->append_metadata(js_datepicker());
		$this->template->build('profile',$data);
	}
	
	function save_profile(){
		if($_POST){
			
			$bmi = new Bmi(@$_GET['id']);
			$_POST['input_date'] = Date2DB($_POST['input_date']);
			
			// คำนวนหาอายุในวันที่บันทึกข้อมูล
			$fullage = newDatediff($_POST['input_date'],$_POST['birth_date']);
			$explode_age = explode(' ', $fullage);
			$_POST['child_age_year'] = $explode_age[0];
			$_POST['child_age_month'] = $explode_age[2];
			
            $bmi->from_array($_POST);
            $bmi->save();
            
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('childrens/profile/'.$_POST['classroom_detail_id']);
	}
	
	function delete_profile($id=false){
		if($id){
			$bmi = new Bmi($id);
			$bmi->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function list_guest($nursery_id){
		$data['nursery_id'] = $nursery_id;
		$child = new Classroom_detail();
		$child->select("*,TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) AS age");
		if(@$_GET['child_name']){ $child->where("child_name LIKE '%".$_GET['child_name']."%'"); }
		if(@$_GET['classroom_id']){ $child->where("classroom_id = ".$_GET['classroom_id']); }
		if(@$_GET['sex']){ $child->where("title = '".$_GET['sex']."'"); }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ $child->where("TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) between ".$_GET['lowage']." and ".$_GET['hiage']); }
		
		$child->where('nursery_id = '.$nursery_id);
		$data['childs'] = $child->order_by('id','desc')->get();
		// $data['childs']->check_last_query();
    	$this->template->build('list_guest',$data);
	}

	function growth($id=false){
		$data['classroom_detail'] = new Classroom_detail($id);
		
		$data['bmis'] = new Bmi();
		$data['bmis']->where('classroom_detail_id = '.$id)->order_by('child_age_year','asc')->get();
		$this->template->build('growth',$data);
	}
	
	function report_diseases($id){
		$data['classroom_detail'] = new Classroom_detail($id);
		
		$data['diseases'] = new Disease();
		$data['diseases']->where('classroom_detail_id = '.$id)->get();
		$this->template->build('report_diseases',$data);
	}
}
?>