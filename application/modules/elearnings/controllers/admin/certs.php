<?php
class Certs extends Admin_Controller
{
	
	function __construct()
	{
		// if(!is_publish('questionaire'))
		// {
				// //set_notify('error','คุณไม่มีสิทธิเข้าใช้งานในส่วนนี้ค่ะ');
				// redirect('docs/publics');
		// }
		parent::__construct();
	}
	
	function index()
	{
		$data['reports'] = new Questionresult();
		$data['reports']->where("score >= pass and set_final = 1") ;
		if(@$_GET['date_status']) ($_GET['date_status'] == 1)? $data['reports']->where("(create_date BETWEEN '".Date2DB($_GET['start_date'])."' AND '".Date2DB($_GET['end_date'])."')") : $data['reports']->where("(update_date BETWEEN '".Date2DB($_GET['start_date'])."' AND '".Date2DB($_GET['end_date'])."')") ;
		if(@$_GET['search'])$data['reports']->where("name like '%".$_GET['search']."%'");
		if(@$_GET['user_type_id'])$data['reports']->where_related_user("user_type_id = ".$_GET['user_type_id']);
		if(@$_GET['province_id'])$data['reports']->where_related_user("province_id = ".$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['reports']->where_related_user("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['reports']->where_related_user("district_id = ".$_GET['district_id']);
		
        $data['reports']->order_by('user_id','asc')->get_page();
		
		// $data['reports']->check_last_query();
        $this->template->append_metadata(js_datepicker());
		$this->template->build('admin/certs/index',$data);
	}

	function printcert($id){
		$data['user'] = new User($id);
		$this->load->view('admin/certs/diploma',$data);
	}
}
?>