<?php
class Ereports extends Admin_Controller
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
		if(@$_GET['topic_id'])$data['reports']->where("topic_id = '".$_GET['topic_id']."'");
		if(@$_GET['status']) ($_GET['status'] == 1)? $data['reports']->where("score >= pass") : $data['reports']->where("score < pass") ;
		if(@$_GET['search'])$data['reports']->where("name like '%".$_GET['search']."%'");
		if(@$_GET['user_type_id'])$data['reports']->where_related_user("user_type_id = ".$_GET['user_type_id']);
		if(@$_GET['province_id'])$data['reports']->where_related_user("province_id = ".$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['reports']->where_related_user("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['reports']->where_related_user("district_id = ".$_GET['district_id']);
		
        $data['reports']->order_by('user_id','asc')->get_page();
		
		// $data['reports']->check_last_query();
        
		$this->template->build('admin/reports/index',$data);
	}
}
?>