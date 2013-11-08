<?php
class Hilights extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}
	
	function inc_home()
	{
		$data['hilights'] = new Hilight();
		$data['hilights']->where("status = 'approve'")->order_by('id','random')->limit(5)->get();
		//$this->load->view('aviaslider',$data);
		$this->load->view('easyslider',$data);
	}
}
?>