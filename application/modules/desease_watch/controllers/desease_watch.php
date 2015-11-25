<?php
class Desease_watch extends Public_Controller {

	function __construct() {
		parent::__construct();
	}

	function index(){
		//Model
		$current_user = user_login();
		$data['current_user'] = $current_user;
		if($current_user->user_type_id == 7){
			$_GET['province_id'] = $current_user->province_id;
		}else if($current_user->user_type_id >= 8){
			$_GET['province_id'] = $current_user->province_id;
			$_GET['amphur_id'] = $current_user->amphur_id;
			if($current_user->user_type_id > 8){
				$_GET['district_id'] = $current_user->district_id;	
			}
		}
		$data['list'] = new Disease_watch();
		//--Search filter
		if(!empty($_GET['name'])) {		$data['list']->like_related('nurseries', 'name', $_GET['name']);	}
		if(!empty($_GET['province_id'])) {	$data['list']->where_related('nurseries', 'province_id', $_GET['province_id']);	}
		if(!empty($_GET['amphur_id'])) {	$data['list']->where_related('nurseries', 'amphur_id', $_GET['amphur_id']);	}
		if(!empty($_GET['district_id'])) {	$data['list']->where_related('nurseries', 'district_id', $_GET['district_id']);	}

		// Get list data& number value
		$data['list']->get_page();
		$data['no'] = (empty($_GET['page']))?0:($_GET['page']-1)*20;
		
		$data['diseaseText'] = array(''=>'--กรุณาเลือกโรค--', 1 => 'โรค มือ เท้า ปาก', 2 => 'โรคอีสุกอีใส', 3 => 'โรคไข้หวัด/ไข้หวัดใหญ่', 4 => 'โรคอุจจาระร่วง');

		$this->template->build('index', @$data);
	}	public function form($id = false) {		if($id) {			// Form data			$data['rs'] = new Disease_watch();			$data['rs']->where('id', $id)->get(1);			// Question data			$question = new Disease_watch_question;			foreach($question->where('disease_watch_id', $id)->get() as $item) {				$data['q'][$item->question] = $item->value;			}		}		$this->template->build('form', @$data);	}	public function save() {		//Question data.		foreach($_POST as $key => $item) {			if(strstr($key, 'qCbox_') || strstr($key, 'qRdo_')) {				$q[$key] = $item;				unset($_POST[$key]);			}		}		//Form data.		$_POST['start_date'] = DATE2DB($_POST['start_date']);		$_POST['end_date'] = DATE2DB($_POST['end_date']);		for($i=1; $i<4; $i++) { $_POST['measure_filter_'.$i] = (empty($_POST['measure_filter_'.$i]))?0:1; }		for($i=1; $i<7; $i++) { $_POST['measure_clean_'.$i] = (empty($_POST['measure_clean_'.$i]))?0:1; }						//Save		$save = new Disease_watch();		foreach($_POST as $key => $item) {			$save->{$key} = $item;		}				//Created_date & updated_date data.		if(empty($_POST['id'])) { 			$save->created_date = date('Y-m-d H:i:s'); 		}		$save->updated_date = date('Y-m-d H:i:s');				$save->save();		//save Question		//--Clear data.		$save->disease_watch_question->delete_all();		//--Update&check data.		foreach($q as $key => $item) {			$qSave = new Disease_watch_question();			$qSave->disease_watch_id = $save->id;			$qSave->question = $key;			$qSave->value = $item;			$qSave->save();		}		redirect('desease_watch');	}	public function nurseries_list() {		if(!empty($_GET) && (!empty($_GET['name']) || !empty($_GET['province_id']) || !empty($_GET['amphur_id']) || !empty($_GET['district_id']))) {			$sql = "SELECT				nurseries.id,				nurseries.code,				nurseries.name,				nurseries.year,				nurseries.p_title,				nurseries.p_name,				nurseries.p_surname,				nurseries.status,				nurseries.approve_year,				nursery_categories.title,				districts.district_name,				amphures.amphur_name,				provinces.name province_name				FROM				nurseries				INNER JOIN nursery_categories ON nurseries.nursery_category_id = nursery_categories.id				INNER JOIN districts on nurseries.district_id = districts.id				INNER JOIN amphures on nurseries.amphur_id = amphures.id				INNER JOIN provinces on nurseries.province_id = provinces.id				WHERE 1=1";			if(@$_GET['name']) $sql .= ' and CONCAT(nursery_categories.title,nurseries.name) like "%'.$_GET['name'].'%"';			if(@$_GET['province_id']) $sql .= ' and nurseries.province_id = '.$_GET['province_id'];			if(@$_GET['amphur_id']) $sql .= ' and nurseries.amphur_id = '.$_GET['amphur_id'];			if(@$_GET['district_id']) $sql .= ' and nurseries.district_id = '.$_GET['district_id'];			$sql .= " ORDER BY nurseries.id DESC";			$nurseries = new Nursery();			$data['list'] = $nurseries->sql($sql)->get_page();			$data['count'] = $nurseries->paged->total_rows;			$data['no'] = (empty($_GET['page']))?0:($_GET['page']-1)*20;		}		$this->load->view('nurseries-list', @$data);	}			public function get_amphur() {			if(empty($_GET['province_id'])) {				echo form_dropdown('amphur_id', array(), false, 'disabled="disabled"', '---กรุณาเลือกข้อมูลจังหวัด---');			} else {				echo form_dropdown('amphur_id', get_option('id', 'amphur_name', 'amphures', ' where province_id = \''.$_GET['province_id'].'\' order by amphur_name asc'), false, false, '---เลือกอำเภอ---');			}		}				public function get_district() {			if(empty($_GET['amphur_id'])) {				echo form_dropdown('district_id', array(), false, 'disabled="disabled"', '---กรุณาเลือกข้อมูลอำเภอ---');			} else {				echo form_dropdown('district_id', get_option('id', 'district_name', 'districts', ' where amphur_id = \''.$_GET['amphur_id'].'\' order by district_name asc'), false, false, '---เลือกตำบล---');			}		}}?>
