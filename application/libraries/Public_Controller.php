<?php
class Public_Controller extends Master_Controller
{
	function __construct()
	{
		parent::__construct();
		
		// check lang
		$this->template->title('ศูนย์เด็กเล็กปลอดโรค');
		$this->template->set_theme('hps');
    	$this->template->set_layout('layout');
		
		// Set js
		$this->lang->load('admin');
		//$this->template->append_metadata(js_notify());
		//$this->template->append_metadata(js_lightbox());
		
		if(!$this->session->userdata('lang')) $this->session->set_userdata('lang','th');
		if(@$this->session->userdata('lang') == "th"){
			$this->lang->load('public','thai');
		}else{
			$this->lang->load('public','english');
		}
	}
}
?>