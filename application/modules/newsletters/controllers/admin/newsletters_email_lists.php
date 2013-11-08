<?php
class Newsletters_email_lists extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data['newsletters_email_lists'] = new Newsletters_email_list();
		if(@$_GET['search'])$data['newsletters_email_lists']->where("email like '%".$_GET['search']."%'");
		$data['newsletters_email_lists']->order_by('id','desc')->get_page(30);
		$this->template->build('admin/emaillist_index',$data);
	}
	
	function form($id=FALSE)
	{
		$data['email'] = new Newsletters_email_list($id);
		
		$categories = new Category();
			$data['categories'] = $categories->where("module = 'newsletters' and parents <> 0 and status = 'approve'")->order_by('id','desc')->get_page();
			
		$this->template->build('admin/emaillist_form',$data);
	}
	
	function save($id=FALSE)
	{
		if($_POST){
			$newsletters_email_list = new Newsletters_email_list($id);
			
			if($id != ""){
					$_POST['user_id'] = $this->session->userdata('id');
					$newsletters_email_list->from_array($_POST);
					if(isset($_POST['newsletters'])){
						$newsletters_email_list->newsletter = implode(',',$_POST['newsletters']);
					}
					$newsletters_email_list->save();
					set_notify('success', lang('save_data_complete'));	
				
			}else{
				$newsletters_email_list->get_by_email($_POST['email']);
				if($newsletters_email_list->email){
					set_notify('error', 'มี email นี้อยู่ในระบบแล้ว');
				}else{
					$_POST['user_id'] = $this->session->userdata('id');
					$newsletters_email_list->from_array($_POST);
					if(isset($_POST['newsletters'])){
						$newsletters_email_list->newsletter = implode(',',$_POST['newsletters']);
					}
					$newsletters_email_list->save();
					set_notify('success', lang('save_data_complete'));	
				}
			}
		}
		redirect('newsletters/admin/newsletters_email_lists');
	}
	
	function delete($id=FALSE)
	{
		if($id)
		{
			$newsletters_email_list = new Newsletters_email_list($id);
			$newsletters_email_list->delete();
			set_notify('success', lang('delete_data_complete'));
		}
		redirect('newsletters/admin/newsletters_email_lists');
	}
	
	function check_email()
	{
		$user = new Newsletters_email_list();
		$user->get_by_email($_GET['email']);
		echo ($user->email)?"false":"true";
	}
}
?>