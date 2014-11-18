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
    
	function get_nursery(){
		if($_POST){
			echo @form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.$_POST['district_id'].' order by name asc'),'','','--- เลือกศูนย์เด็กเล็ก ---');
		}
	}
}
?>