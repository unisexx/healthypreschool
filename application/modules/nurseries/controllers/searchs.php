<?php
class Searchs extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	function index(){
		$data['nurseries'] = new Nursery();
		if(@$_GET['nursery_category_id'])$data['nurseries']->where("nursery_category_id = ".$_GET['nursery_category_id']);
        if(@$_GET['name'])$data['nurseries']->where("name like '%".$_GET['name']."%'");
		if(@$_GET['province_id'])$data['nurseries']->where('province_id',$_GET['province_id']);
		if(@$_GET['amphur_id'])$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
		if(@$_GET['district_id'])$data['nurseries']->where("district_id = ".$_GET['district_id']);
		
		$data['nurseries']->order_by('id','desc')->get_page();
		$data['count'] = $data['nurseries']->paged->total_rows;
		$this->template->build('search_index',$data);
	}

	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by id asc'),'','','--- เลือกอำเภอ ---');
		}
	}
	
	function get_district(){
		if($_POST){
			echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_POST['amphur_id'].' order by id asc'),'','','--- เลือกตำบล ---');
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
					$nuchk = $nuchk->where('year = '.$_POST['year'].' and name = "'.$_POST['name'].'" and district_id = '.$_POST['district_id'])->get()->result_count();
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