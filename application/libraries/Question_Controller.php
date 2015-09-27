<?php
class Question_Controller extends Master_Controller
{
	
	function __construct()
	{
		parent::__construct();
		// Check Auth Login
		
		$this->template->title('Thaigcd.ddc.moph.go.th - ระบบแบบสอบถาม');
		$this->template->set_theme('question');
		$this->template->set_layout('layout');
		$this->lang->load('admin');
		$this->template->append_metadata(js_notify());
		$this->template->append_metadata(js_lightbox());
	}
	
}
?>