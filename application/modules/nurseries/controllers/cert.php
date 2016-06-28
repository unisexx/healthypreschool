<?php
class Cert extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index($assessment_id){
		$assessment = new Assessment($assessment_id);
		$data['nursery_name'] = $assessment->nursery->name;
		$data['approve_year'] = thainumDigit($assessment->approve_year,"F");
		$data['expired'] = thainumDigit(($assessment->approve_year)+2,"F");
		$this->load->view('cert/nursery_diploma', $data);
	}
}
?>