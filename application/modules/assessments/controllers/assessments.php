<?php
class Assessments extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
	
	function index(){
		$this->template->set_layout('blank');
		$data['nursery_id'] = user_login()->nursery_id;
		$data['assessments'] = new Assessment();
		$data['assessments']->where('nursery_id = '.$data['nursery_id'])->get();
		$this->template->build('index',$data);
	}
	
	function form($id=false){
		$this->template->set_layout('blank');
		$data['nursery_id'] = user_login()->nursery_id;
		
		$data['nursery'] = new Nursery($data['nursery_id']);
		$data['assessment'] = new Assessment($id);
		$this->template->build('form',$data);
	}
	
	function save($id=false){
		if($_POST){
			$assessment = new Assessment($id);
			
			if($id){
				$_POST['updated_by'] = user_login()->id;
			}else{
				$_POST['created_by'] = user_login()->id;
			}
			
			if($_POST['total'] >= 28){ 
				$_POST['status'] = 1; //ผ่านเกณฑ์
			}else{
				$_POST['status'] = 2; //ไม่ผ่านเกณฑ์
			}
			
			if($_FILES['files']['name'])
			{
				if($assessment->id){
					$assessment->delete_file($assessment->id,'uploads/assessment','files');
				}
				$_POST['files'] = $assessment->upload($_FILES['files'],'uploads/assessment/');
			}
			
	        $assessment->from_array($_POST);
	        $assessment->save();	
			
			/*** อัพเดท status ล่าสุด ที่ table nursery ***/
			// ทำการเช็กก่อนว่า ปีที่ทำการประเมินเป้นปีล่าสุดหรือยัง ถ้าไม่ล่าสุด ไม่ต้องอัพเดท
			// $sql = "SELECT approve_year from nurseries where nursery_id = ".$_POST['nursery_id'];
			// $approve_year = $this->db->query($sql)->row_array();
			// if($_POST['approve_year'] > $approve_year['approve_year']){ // ถ้าเป็นปีล่าสุด ให้ทำการอัพเดท table nursery
// 				
				// $nursery = new Nursery($_POST['nursery_id']);
				// if($_POST['total'] >= 28){
					// $nursery->status = 1; //ผ่านเกณฑ์
				// }else{
					// $nursery->status = 2; //ไม่ผ่านเกณฑ์
				// }
// 				
				// $nursery->approve_year = $_POST['approve_year'];
				// $nursery->save();
// 				
			// }
			
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('assessments/index');
	}
	
	function preview($nursery_id = false){
		$this->template->set_layout('blank');
		$data['nursery'] = new Nursery($nursery_id);
		
		$assessment = new Assessment();
		$data['assessment'] = $assessment->where('nursery_id = '.$nursery_id)->limit(1)->get();
		$this->template->build('preview',$data);
	}
}
?>