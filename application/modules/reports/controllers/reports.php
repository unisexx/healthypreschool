<?php
class Reports extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		$this->template->set_layout('blank');	
	}
	
	// กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโต (น้ำหนัก)
	function children_weight(){
		$data['text'] = "กราฟแสดงเกณฑ์อ้างอิงการเจริญเติบโต (น้ำหนัก)";
		
		if(isset($_GET['classroom_id']) && ($_GET['classroom_id']!="")){
			$data['rs'] = new Classroom();
			$data['rs']->where('id = ',$_GET['classroom_id'])->order_by('room_name','asc')->get();
		}elseif(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
			$data['rs'] = new Classroom();
			$data['rs']->where('nursery_id = ',$_GET['nursery_id'])->order_by('room_name','asc')->get();
		}elseif(isset($_GET['district_id']) && ($_GET['district_id']!="")){
			$data['rs'] = new Nursery();
			$data['rs']->where('district_id = ',$_GET['district_id'])->order_by('name','asc')->get();
		}elseif(isset($_GET['amphur_id']) && ($_GET['amphur_id']!="")){
			$data['rs'] = new District();
			$data['rs']->where('amphur_id = ',$_GET['amphur_id'])->order_by('district_name','asc')->get();
		}elseif(isset($_GET['province_id']) && ($_GET['province_id']!="")){
			$data['rs'] = new Amphur();
			$data['rs']->where('province_id = '.$_GET['province_id'])->order_by('amphur_name','asc')->get();
		}elseif(isset($_GET['area_id']) && ($_GET['area_id']!="")){
			$data['rs'] = new Province();
			$data['rs']->where('area_id = '.$_GET['area_id'])->order_by('name','asc')->get();
		}else{
			$data['rs'] = new Area();
			$data['rs']->order_by('id','asc')->get();
		}
		
		$this->template->build('children_weight',$data);
	}

	function desease_watch_number(){
		$data = '';
		$this->template->build('desease_watch_number',$data);
	}
    function desease_watch_number_table_year(){
        $data = '';
        $this->load->view('desease_watch_number_table_year',$data);
    }
    function desease_watch_number_table_month_year(){
        $data = '';
        $this->load->view('desease_watch_number_table_month_year',$data);
    }
    function desease_watch_number_table_time(){
        $data = '';
        $this->load->view('desease_watch_number_table_time',$data);
    }
    function desease_watch_number_table_default(){
        $data = '';
        $this->load->view('desease_watch_number_table_default',$data);
    }    
}
?>