<?php
class Assessments extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
	
	function form(){
		//$this->template->set_layout('disease');
		$this->template->set_layout('blank');
		$data['nursery'] = new Nursery($_GET['nursery_id']);
		
		$assessment = new Assessment();
		$data['assessment'] = $assessment->where('nursery_id = '.$_GET['nursery_id'])->limit(1)->get();
		$this->template->build('form',$data);
	}
	
	function save(){
		if($_POST){
			$assessment = new Assessment($id);
	        $assessment->from_array($_POST);
	        $assessment->save();	
			
			// อัพเดท status
			$nursery = new Nursery($_POST['nursery_id']);
			if($_POST['total'] >= 28){ //ผ่านเกณฑ์
				$nursery->status = 1;
			}else{
				$nursery->status = 0;
			}
			$nursery->save();
			
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect($_POST['referer']);
	}
}
?>