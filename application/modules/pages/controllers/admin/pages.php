<?php
class Pages extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$pages = new Page();
		if(@$_GET['search'])$pages->where("title like '%".$_GET['search']."%'");
		$data['pages'] = $pages->order_by('id','desc')->get_page();
		$this->template->build('admin/page_index',$data);
	}
	
	function form($id=FALSE)
	{
		$data['page'] = new Page($id);
		$this->template->append_metadata(js_datepicker());
		$this->template->build('admin/page_form',$data);
	}
	
	function save($id=FALSE)
	{
		// $this->db->debug = true;
		if($_POST)
		{
			$page = new Page($id);
			$_POST['title'] = lang_encode($_POST['title']);
			$_POST['detail'] = lang_encode($_POST['detail']);
			$_POST['user_id'] = $this->session->userdata('id');
			$page->from_array($_POST);
			$page->save();
			
			set_notify('success', lang('save_data_complete'));
		}
		redirect('pages/admin/pages');
	}
	
	function delete($id)
	{
		$page = new Page($id);
		$page->delete();
		set_notify('success', lang('delete_data_complete'));
		redirect('pages/admin/pages');
	}
	
	
}
?>