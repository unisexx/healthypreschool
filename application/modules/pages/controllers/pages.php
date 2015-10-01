<?php
class Pages extends Public_Controller
{
	
	function __construct()
	{
		parent::__construct();
	}
	
	function index($slug)
	{
		if($_POST&&($slug=='contactus'))
		{
			$this->load->library('email');
			$data['contact'] = new Contact;
			$data['contact']->from_array($_POST);
			$data['contact']->save();
			
			$group = new Group($_POST['group_id']);
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($_POST['email'], $_POST['name']);
			$email = 'jakepong@hotmail.com';
			$this->email->to($email);
			//$this->email->to($group->email);
			
			$this->email->subject($_POST['title']);
			$this->email->message($this->load->view('view',$data,TRUE));
			$this->email->send();
			//echo $this->email->print_debugger();
			set_notify('success','ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['page'] = new Page();
		$data['page']->get_by_slug($slug);
		$this->template->build('page_index',$data);
	}
	
	function view($id)
	{
		if($_POST&&($slug=='contactus'))
		{
			$this->load->library('email');
			$contact = new Contact;
			$contact->from_array($_POST);
			$contact->save();
			
			$group = new Group($_POST['group_id']);
			
			$config['mailtype'] = 'html';
			$this->email->initialize($config);
			$this->email->from($_POST['email'], $_POST['name']);
			$this->email->to($group->email);
			$this->email->subject($_POST['title']);
			$this->email->message($_POST['detail']);
			$this->email->send();
			
			set_notify('success','ระบบได้ทำการบันทึกข้อมูลเรียบร้อยแล้วค่ะ');
			redirect($_SERVER['HTTP_REFERER']);
		}
		$data['page'] = new Page($id);
		$data['page']->counter();
		$this->template->build('page_index',$data);
	}
	
	function txtslide($id=66){
		$data['page'] = new Page($id);
		$this->load->view('txtslide',$data);
		// echo'<div id="marquee">
				// <marquee  align="middle" scrollamount="5" scrolldelay="91" onmouseover="this.stop();" onmouseout="this.start();">'.lang_decode($page->detail).'</marquee>
			// </div>';
	}
	
}
?>