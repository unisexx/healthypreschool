<?php
class Searchs extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}

	function index(){
		// if(@$_GET['nursery_category_id'])$data['nurseries']->where("nursery_category_id = ".$_GET['nursery_category_id']);
        // if(@$_GET['name'])$data['nurseries']->where("name like '%".$_GET['name']."%'");
		// if(@$_GET['province_id'])$data['nurseries']->where('province_id',$_GET['province_id']);
		// if(@$_GET['amphur_id'])$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
		// if(@$_GET['district_id'])$data['nurseries']->where("district_id = ".$_GET['district_id']);
		
		$sql = "SELECT
				nurseries.id,
				nurseries.name,
				nurseries.year,
				nurseries.p_title,
				nurseries.p_name,
				nurseries.p_surname,
				nurseries.status,
				nurseries.approve_year,
				nursery_categories.title,
				districts.district_name,
				amphures.amphur_name,
				provinces.name province_name
				FROM
				nurseries
				INNER JOIN nursery_categories ON nurseries.nursery_category_id = nursery_categories.id
				INNER JOIN districts on nurseries.district_id = districts.id
				INNER JOIN amphures on nurseries.amphur_id = amphures.id
				INNER JOIN provinces on nurseries.province_id = provinces.id
				WHERE 1=1";
		if(@$_GET['name']) $sql .= ' and CONCAT(nursery_categories.title,nurseries.name) like "%'.$_GET['name'].'%"';
		if(@$_GET['province_id']) $sql .= ' and nurseries.province_id = '.$_GET['province_id'];
		if(@$_GET['amphur_id']) $sql .= ' and nurseries.amphur_id = '.$_GET['amphur_id'];
		if(@$_GET['district_id']) $sql .= ' and nurseries.district_id = '.$_GET['district_id'];
		$sql .= " ORDER BY nurseries.id DESC";
		
		$nurseries = new Nursery();
		$data['nurseries'] = $nurseries->sql($sql)->get_page();
		$data['count'] = $nurseries->paged->total_rows;
		$this->template->build('search_index',$data);
	}

	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),'','','--- เลือกอำเภอ ---');
		}
		
		$province = new Province($_POST['province_id']);
		echo "<input type='hidden' name='area_id' value='".$province->area_id."'>";
	}
	
	function get_district(){
		if($_POST){
			echo @form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_POST['amphur_id'].' order by district_name asc'),'','','--- เลือกตำบล ---');
		}
	}

	function register_form($id=false){
		$data['nursery'] = new Nursery($id);
		$this->template->build('search_register_form',$data);
	}
	
	function register_save($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				
				if($id == ""){
					$nuchk = new Nursery();
					$nuchk = $nuchk->where('name like "%'.$_POST['name'].'%" and district_id = '.$_POST['district_id'])->get()->result_count();
					if($nuchk > 0){
						set_notify('error', 'ชื่อศูนย์เด็กเล็กนี้มีแล้วค่ะ');
						redirect($_SERVER['HTTP_REFERER']);
					}
				}
				
				$_POST['user_id'] = $this->session->userdata('id');
				//$_POST['area_id'] = login_data('nursery');
				$nursery = new Nursery($id);
				$nursery->from_array($_POST);
				$nursery->save();
				set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
				redirect($_SERVER['HTTP_REFERER']);
			}
			redirect('nurseries/searchs');
		}
	}
	
}
?>