<?php
class Weblinks extends Admin_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$data['hilights'] = new Weblink();
		if(@$_GET['status'])$data['hilights']->where('status',$_GET['status']);
		$data['hilights']->order_by('id','desc')->get_page();
		$this->template->append_metadata(js_lightbox());
		$this->template->append_metadata(js_checkbox('approve'));
		$this->template->build('admin/index',$data);
	}
	
	function form($id=FALSE)
	{
		$data['hilight'] = new Weblink($id);
		$this->template->append_metadata(js_datepicker());
		$this->template->build('admin/form',$data);
	}
	
	function save($id=FALSE)
	{
		if($_POST)
		{
			$Weblink = new Weblink($id);
			$_POST['title'] = lang_encode($_POST['title']);
            $_POST['status'] = "approve";
			if(!$id)$_POST['user_id'] = $this->session->userdata('id');
			// $_POST['start_date'] = Date2DB($_POST['start_date']);
			// $_POST['end_date'] = Date2DB($_POST['end_date']);
			if($_FILES['image']['name'])
			{
				if($Weblink->id){
					$Weblink->delete_file($Weblink->id,'uploads/weblink','image');
				}
				$_POST['image'] = $Weblink->upload($_FILES['image'],'uploads/weblink/',185,63);
			}
			$Weblink->from_array($_POST);
			$Weblink->save();
			set_notify('success', lang('save_data_complete'));
		}
		redirect('weblinks/admin/weblinks');
	}
	
	function delete($id=FALSE)
	{
		if($id)
		{
			$Weblink = new Weblink($id);
			$Weblink->delete();
			set_notify('success', lang('delete_data_complete'));
		}
		redirect('weblinks/admin/weblinks');
	}

	function approve($id)
	{
		if($_POST)
		{
			$Weblink = new Weblink($id);
			$_POST['approve_id'] = $this->session->userdata('id');
			$Weblink->approve_date = date("Y-m-d H:i:s");
			$Weblink->from_array($_POST);
			$Weblink->save();
			echo approve_comment($Weblink);
		}

	}
	

}
?>