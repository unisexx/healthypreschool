<?php
class Assessments extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
	
	function index(){
		$this->template->set_layout('blank');
		$data['nursery_id'] = user_login()->nursery_id;
		$data['assessments'] = new Assessment();
		$data['assessments']->where('nursery_id = '.$data['nursery_id'])->order_by('approve_year','asc')->get();
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
			
			$_POST['approve_user_id'] = user_login()->id;
			$_POST['approve_date'] = date("Y-m-d H:i:s");
			
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
			
			/*** อัพเดท status ของ approve_year ล่าสุด ที่ table nursery ***/
			update_last_assessment_status($_POST['nursery_id']);
			
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