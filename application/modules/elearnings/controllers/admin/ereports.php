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
	    /*
		$data['reports'] = new Questionresult();
		if(@$_GET['topic_id'])$data['reports']->where("topic_id = '".$_GET['topic_id']."'");
		if(@$_GET['status']) ($_GET['status'] == 1)? $data['reports']->where("score < pass") : $data['reports']->where("score >= pass") ;
		if(@$_GET['date_status']) ($_GET['date_status'] == 1)? $data['reports']->where("(create_date BETWEEN '".Date2DB($_GET['start_date'])."' AND '".Date2DB($_GET['end_date'])."')") : $data['reports']->where("(update_date BETWEEN '".Date2DB($_GET['start_date'])."' AND '".Date2DB($_GET['end_date'])."')") ;
		if(@$_GET['search'])$data['reports']->where("name like '%".$_GET['search']."%'");
		if(@$_GET['user_type_id'])$data['reports']->where_related_user("user_type_id = ".$_GET['user_type_id']);
		if(@$_GET['province_id'])$data['reports']->where_related_user("province_id = ".$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['reports']->where_related_user("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['reports']->where_related_user("district_id = ".$_GET['district_id']);
		
        $data['reports']->order_by('user_id','asc')->get_page();
		*/
		// $data['reports']->check_last_query();
        $condition = ' WHERE 1=1 ';
        $condition.= @$_GET['topic_id'] != '' ? " and topic_id = '".$_GET['topic_id']."'" : '';
        if(@$_GET['status']=='1')$condition.=" and n_user_score < pass ";
        if(@$_GET['status']=='2')$condition.=" and n_user_score >= pass ";
        if(@$_GET['user_type_id']!='')$condition.=" and user_type_id = ".@$_GET['user_type_id'];
        if(@$_GET['province_id']!='')$condition.=" and v_users.province_id = ".@$_GET['province_id'];
        if(@$_GET['amphur_id']!='')$condition.=" and v_users.amphur_id = ".@$_GET['amphur_id'];
        if(@$_GET['district_id']!='')$condition.=" and v_users.district_id = ".@$_GET['district_id'];
        if(@$_GET['search']!='')$condition.=" and v_users.name like '%".@$_GET['search']."%'";
        $sql = '
            select 
            user_exam.*,
            v_users.name,
            v_users.user_type_id,
            v_users.area_id,
            v_users.province_id,
            v_users.amphur_id,
            v_users.district_id,
            v_users.nursery_id,
            area_name,
            provinces.name province_name,
            amphures.amphur_name,
            districts.district_name,
            nurseries.`name` nursery_name,
            user_types.`name` user_type_name
            from(
            select 
            uqr.*, qt.title topic_title, qt.pass
            from user_question_result uqr
            left join question_topics qt on uqr.topic_id = qt.id
            WHERE
            1=1
            )user_exam
            left join v_users on user_exam.user_id = v_users.id
            left join areas on v_users.area_id = areas.id
            left join provinces on province_id = provinces.id
            left join amphures on v_users.amphur_id = amphures.id
            left join districts on v_users.district_id = districts.id
            left join nurseries on v_users.nursery_id = nurseries.id
            left join user_types on v_users.user_type_id = user_types.id     
        ';
        $order_by = ' order by v_users.name ';
        $data['reports'] = $this->db->query($sql.$condition.$order_by)->result();
        
        $this->template->append_metadata(js_datepicker());
		$this->template->build('admin/reports/index',$data);
	}
}
?>