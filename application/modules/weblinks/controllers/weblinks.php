<?php
class Weblinks extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function inc_home()
	{
		$data['weblinks'] = new Weblink();
		$data['weblinks']->where("status = 'approve'")->get();
		$this->load->view('inc_home',$data);
	}
}
?>