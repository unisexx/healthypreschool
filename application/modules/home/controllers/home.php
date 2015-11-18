<?php
class Home extends Public_Controller {

	function __construct()
	{
		parent::__construct();	
	}
	
	function first_page()
	{
		$coverpage = new Coverpage();
		$coverpage->where("status = 'approve' and active = 1")->get();
		if($coverpage->id != ""){
			redirect("coverpages/index/".$coverpage->id);
		}else{
			redirect("home");
		}
	}
	
	function index(){
		$this->template->build('index');
	}
	
	function menu(){
		if(user_login()->m_status != "active"){
			set_notify('error', 'สถานะของผู้ใช้งานไม่ได้รับอนุญาติ');
			redirect('home');
		}
		$this->template->set_layout('blank');
		$this->template->build('menu');
	}
	
	function intro(){
		$this->load->view('intro');
	}
	
	public function lang($lang)
	{
		$this->load->library('user_agent');
		$this->session->set_userdata('lang',$lang);
		
		redirect($this->agent->referrer());
	}
	
	public function sitemap()
	{
		$data['categories'] = new Category();
		$data['childs'] = new Category();
		$data['categories']->where("parents = 0 and id not in (74)")->get();
		$data['num'] = ceil($data['categories']->where("parents = 0 and id not in (74)")->count()/2);
		$this->template->build('sitemap',$data);
	}
	
	function testmail(){
			$this->load->library('email');
			$this->email->from('ampzimeow@gmail.com', 'เคน ธีรเดช วงสืบพันธุ์');
			$this->email->to('unisexx@hotmail.com');
			$this->email->subject('นี่คือสแปม');
			$this->email->message('555+');
			$this->email->send();
			echo $this->email->print_debugger();
	}
	
	function search()
	{
		$this->template->title(lang('search').' - zulex.co.th');
		$this->template->build('search');
	}
	
	function under_construction(){
		$this->template->build('under_contruction');
	}
	
	function get_province(){
		if(isset($_GET['area_id']) && ($_GET['area_id']!="")){
			$rs = new Province();
			$rs->where("area_id = ".$_GET['area_id'])->order_by('name','asc')->get();
			echo'[';
			echo'[ "","--- เลือกจังหวัด ---" ]';
			foreach($rs as $key=>$row){
					echo',[ "'.$row->id.'","'.$row->name.'"]';
			}
			echo']';
		}else{
			$rs = new Province();
			$rs->order_by('name','asc')->get();
			echo'[';
			echo'[ "","--- เลือกจังหวัด ---" ]';
			foreach($rs as $key=>$row){
					echo',[ "'.$row->id.'","'.$row->name.'"]';
			}
			echo']';
		}
	}
	
	function get_ampor(){
		if(isset($_GET['province_id']) && ($_GET['province_id']!="")){
			$rs = new Amphur();
			$rs->where("province_id = ".$_GET['province_id'])->order_by('amphur_name','asc')->get();
			
			echo'[';
			echo'[ "","--- เลือกอำเภอ ---" ]';
			foreach($rs as $key=>$row){
					echo',[ "'.$row->id.'","'.$row->amphur_name.'"]';
			}
			echo']';
		}else{
			echo '[[ "","---" ]]';
		}
	}
	
	function get_tumbon(){
		if(isset($_GET['amphur_id']) && ($_GET['amphur_id']!="")){
			$rs = new District();
			$rs->where("amphur_id = ".$_GET['amphur_id'])->order_by('district_name','asc')->get();
			
			echo'[';
			echo'[ "","--- เลือกตำบล ---" ]';
			foreach($rs as $key=>$row){
					echo',[ "'.$row->id.'","'.$row->district_name.'"]';
			}
			echo']';
		}else{
			echo '[[ "","---" ]]';
		}
	}
	
	function get_nursery(){
		if(isset($_GET['district_id']) && ($_GET['district_id']!="")){
			$rs = new Nursery();
			$rs->where("district_id = ".$_GET['district_id'])->order_by('name','asc')->get();
			
			echo'[';
			echo'[ "","--- เลือกศูนย์เด็กเล็ก ---" ]';
			foreach($rs as $key=>$row){
					echo',[ "'.$row->id.'","'.$row->name.'"]';
			}
			echo']';
			
		}else{
			echo '[[ "","---" ]]';
		}
	}
	
	
}
?>