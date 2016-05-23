<?php
class Cert extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index($nursery_id=false){
		if (is_login()) {
			
			if($nursery_id){ //ถ้าเป็นเจ้าหน้าที่สาธารณะสุข, admin
				
				if(user_login()->user_type_id!=1 and user_login()->user_type_id!=6 and user_login()->user_type_id!=7 and user_login()->user_type_id!=8 or user_login()->m_status != "active"){
					set_notify('error', 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ค่ะ');
					redirect('home');
				}
				
				$nursery = new Nursery($nursery_id);
				if($nursery->approve_year != 0){ 
					$data['nursery_name'] = $nursery->name;
					$data['approve_year'] = thainumDigit($nursery->approve_year,"F");
					$data['expired'] = thainumDigit(($nursery->approve_year)+2,"F");
				}else{ //ผ่านเกณฑ์โดยการทำแบบทดสอบ 35 ข้อ
					$data['nursery_name'] = $nursery->name;
					$data['approve_year'] = thainumDigit(date("Y", strtotime($nursery->approve_date)) + 543,"F");
					$data['expired'] = thainumDigit((date("Y", strtotime($nursery->approve_date)) + 543)+2,"F");
				}
				$this->load->view('cert/nursery_diploma', $data);
				
			}else{ // เจ้าหน้าที่ศูนย์, เจ้าหน้าที่ครู ผู้ดูแลเด็ก
			
				$user = user_login();
				if($user->nursery->status == 0){
					set_notify('error', 'ศูนย์เด็กเล็กหรือโรงเรียนอนุบาลของท่านยังไม่ผ่านเกณฑ์การประเมิน');
	            	redirect('home');
				}else{
					
					if($user->nursery->approve_year != 0){
						$data['nursery_name'] = $user->nursery->name;
						$data['approve_year'] = thainumDigit($user->nursery->approve_year,"F");
						$data['expired'] = thainumDigit(($user->nursery->approve_year)+2,"F");
					}else{ //ผ่านเกณฑ์โดยการทำแบบทดสอบ 35 ข้อ
						$data['nursery_name'] = $user->nursery->name;
						$data['approve_year'] = thainumDigit(date("Y", strtotime($user->nursery->approve_date)) + 543,"F");
						$data['expired'] = thainumDigit((date("Y", strtotime($user->nursery->approve_date)) + 543)+2,"F");
					}
					
					$this->load->view('cert/nursery_diploma', $data);
				}	
				
			}
			
        } else {
            set_notify('error', 'กรุณาล้อกอินเข้าสู่ระบบ');
            redirect('home');
        }
	}
}
?>