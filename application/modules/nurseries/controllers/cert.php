<?php
class Cert extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index($nursery_id){
		$nursery = new Nursery($nursery_id);
		$data['nursery_name'] = $nursery->name;
		$data['approve_year'] = thainumDigit($nursery->assessment_approve_year,"F");
		$data['expired'] = thainumDigit(($nursery->assessment_approve_year)+2,"F");
		$this->load->view('cert/nursery_diploma', $data);
	}
	
	// function index($assessment_id){
 		// $assessment = new Assessment($assessment_id);
 		// $data['nursery_name'] = $assessment->nursery->name;
		// $data['approve_year'] = thainumDigit($assessment->approve_year,"F");
		// $data['expired'] = thainumDigit(($assessment->approve_year)+2,"F");
		// $this->load->view('cert/nursery_diploma', $data);
	// }
}
?>