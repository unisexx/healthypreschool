<?php
class Desease_watch extends Public_Controller{
	
	function __construct(){
		parent::__construct();
		
		
	}
	
	function index(){
		// Call model
		$data['list'] = new Disease_watch();
		
		// Search filter
		if(!empty($_GET['name'])) {		$data['list']->like_related('nurseries', 'name', $_GET['name']);	}
		if(!empty($_GET['province_id'])) {	$data['list']->where_related('nurseries', 'province_id', $_GET['province_id']);	}
		if(!empty($_GET['amphur_id'])) {	$data['list']->where_related('nurseries', 'amphur_id', $_GET['amphur_id']);	}
		if(!empty($_GET['district_id'])) {	$data['list']->where_related('nurseries', 'district_id', $_GET['district_id']);	}
		
		// Get list data& number value
		$data['list']->get_page();
		$data['no'] = (empty($_GET['page']))?0:($_GET['page']-1)*20;
	  
		$this->template->build('index', @$data);
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
	*/
}
?>