<?php
class Cert extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index($assessment_id){
		// if (is_login()) {
// 			
			// if($nursery_id){ //ถ้าเป็นเจ้าหน้าที่สาธารณะสุข, admin
// 				
				// if(user_login()->user_type_id!=1 and user_login()->user_type_id!=6 and user_login()->user_type_id!=7 and user_login()->user_type_id!=8 or user_login()->m_status != "active"){
					// set_notify('error', 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ค่ะ');
					// redirect('home');
				// }
// 				
				// $nursery = new Nursery($nursery_id);
				// $data['nursery_name'] = $nursery->name;
				// $data['approve_year'] = thainumDigit($nursery->assessment_approve_year,"F");
				// $data['expired'] = thainumDigit(($nursery->assessment_approve_year)+2,"F");
				// $this->load->view('cert/nursery_diploma', $data);
// 				
			// }else{ // เจ้าหน้าที่ศูนย์, เจ้าหน้าที่ครู ผู้ดูแลเด็ก	// set_notify('error', 'ศูนย์เด็กเล็กหรือโรงเรียนอนุบาลของท่านยังไม่ผ่านเกณฑ์การประเมิน');
	            	// redirect('home');
				// }else{
					
					// $data['nursery_name'] = $user->nursery->name;
					// $data['approve_year'] = thainumDigit($user->nursery->assessment_approve_year,"F");
					// $data['expired'] = thainumDigit(($user->nursery->assessment_approve_year)+2,"F");
					// $this->load->view('cert/nursery_diploma', $data);
					
					$assessment = new Assessment($assessment_id);
					$data['nursery_name'] = $assessment->nursery->name;
					$data['approve_year'] = thainumDigit($assessment->approve_year,"F");
					$data['expired'] = thainumDigit(($assessment->approve_year)+2,"F");
					$this->load->view('cert/nursery_diploma', $data);

				// }	
				
			// }
// 			
        // } else {
            // set_notify('error', 'กรุณาล้อกอินเข้าสู่ระบบ');
            // redirect('home'); 
        // }
	}
}
?>