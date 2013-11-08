<?php
Class Galleries extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
	}	
	
	function inc_home($id=FALSE)
	{
		$data['galleries'] = new Picture();
		$data['galleries']->order_by('id','desc')->get(15);
		$this->load->view('inc_home',$data);
	}
	
	function index($id=FALSE)
	{
		$data['categories'] = new Album();
		$data['categories']->order_by('id','desc')->get();
		$this->template->build('gallery_index',$data);
	}
	
	function view($id)
	{
		$data['catagory_id'] = $id;
		$data['galleries'] = new Picture();
		$data['galleries']->where("album_id = ".$id)->order_by('id','asc')->get_page(40);
		$this->template->build('gallery_view',$data);
	}
}
?>