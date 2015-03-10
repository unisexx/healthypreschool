<?php
class Surveillances extends Public_Controller
{
    function __construct()
    {
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index($id=false)
    {
        $this->template->build('index');
    }
    
	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),'','','--- เลือกอำเภอ ---');
		}
	}
	
	function get_district(){
		if($_POST){
			echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_POST['amphur_id'].' order by district_name asc'),'','','--- เลือกตำบล ---');
		}
	}
	
	function get_nursery(){
		if($_POST){
			echo @form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.$_POST['district_id'].' order by name asc'),'','','--- เลือกศูนย์เด็กเล็ก ---');
		}
	}
}
?>