<?php
class Abouts extends Public_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$data['seats'] = new Seat();
        $data['seats']->where("category_id = 33 and status = 'approve'")->order_by("id","desc")->get();
		
		$data['abouts'] = new About();
		$data['abouts']->where('id > 1 and id < 7')->order_by('id','asc')->get();
        
        $this->template->title('เกี่ยวกับองค์กร');
		$this->template->build('about_index',$data);
	}
	// function view($id){
		// $data['about'] = new About($id);
		// $this->template->build('about_index',$data);
	// }
	
	function maquee_inc(){
		$data['mq'] = new About(7);
		$this->load->view('maquee_inc',$data);
	}
	
	function board(){
		$data['data'] = new About(8);
		$data['attachs'] = new Attach();
        $data['attachs']->where("module = 'abouts' and content_id = 8")->order_by('id','asc')->get();
		$this->template->build('board_index',$data);
	}
}
?>
