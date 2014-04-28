<?php
class Assessments extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
	
	function form(){
		$this->template->set_layout('disease');
		
		$assessment = new Assessment();
		$data['assessment'] = $assessment->where('nursery_id = '.$_GET['nursery_id'])->limit(1)->get();
		$this->template->build('form',$data);
	}
	
	function save(){
		if($_POST){
			$assessment = new Assessment($id);
	        $assessment->from_array($_POST);
	        $assessment->save();	
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>