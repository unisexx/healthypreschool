<?php
class Reports extends Public_Controller
{
	function __construct()
	{
		parent::__construct();
		ini_set('memory_limit', '-1');
	}
	
	function index($graphtype=false){ // เข้าร่วมโครงการ - ผ่านเกณ
		$this->template->set_layout('blank');
		
		(@$_GET['year'])?$txt="ปีงบประมาณ ".@$_GET['year']:$txt="โดยรวมทั้งหมด";
		
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new Province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (อำเภอ".$data['amphur']->amphur_name.")";
			$this->template->build('amphur_report',$data);
		}elseif(@$_GET['type'] == 4 ){ // ตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (ตำบล".$data['district']->district_name.")";
			$this->template->build('amphur_report',$data);
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			if(@$_GET['year']){
				$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year'];
			}else{
				$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคโดยรวมทั้งหมด";
			}
		}
		if($graphtype=="basic_column"){
			$this->template->build('report',$data);
		}elseif($graphtype=="stacked_column"){
			$this->template->build('report_stackcolumn',$data);
		}
	}
	
	function report2(){ // จำนวนในพื้นที่ - เข้าร่วมโครงการ
		$this->template->build('report2');
	}

	function area_report($id=false){
		$data['provinces'] = new Province();
		$data['provinces']->where('area_id = '.$id)->get();
		$data['province_count'] = $data['provinces']->where('area_id = '.$id)->get()->result_count();
		$data['area_id'] = $id;
		$this->template->build('area_report',$data);
	}
	
	function province_report($id=false){
		$data['province'] = new Province($id);
		$data['amphurs'] = new Amphur();
		$data['amphurs']->where('province_id = '.$id)->get();
		$this->template->build('province_report',$data);
	}
	
	function amphur_report($id=false){
		$data['amphur'] = new Amphur($id);
		$data['districts'] = new District();
		$data['districts']->where('amphur_id = ',$id)->get();
		$this->template->build('amphur_report',$data);
	}
	
	function detail(){
		$this->template->set_layout('blank');
		
		$data['nurseries'] = new Nursery();
		
		if(@$_GET['area_id']){
			// $data['nurseries']->where('area_id',$_GET['area_id']);
			$data['nurseries']->where_related_province('area_id',$_GET['area_id']);
			$data['area'] = "สคร.".$_GET['area_id'];
		}
		if(@$_GET['province_id']){
			$data['nurseries']->where('province_id',$_GET['province_id']);
			$province = new Province($_GET['province_id']);
			$data['province'] = "จังหวัด".$province->name;
		}
		if(@$_GET['amphur_id']){
			$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
			$amphur = new Amphur($_GET['amphur_id']);
			$data['amphur'] = "อำเภอ".$amphur->amphur_name;
		}

		if(@$_GET['district_id']){
			$data['nurseries']->where("district_id = ".$_GET['district_id']);
			$district = new District($_GET['district_id']);
			$data['district'] = "ตำบล".$district->district_name;
		}
		if(@$_GET['year']){
			$data['nurseries']->where("year = ".$_GET['year']);
			$data['year'] = "ปี ".$_GET['year'];
		}
		if(isset($_GET['status'])){
			$data['nurseries']->where("status = ".$_GET['status']);
		}
		
		$data['nurseries']->order_by('id','desc')->get_page();
		// $data['nurseries']->check_last_query();
		
		$this->template->build('report_detail',$data);
	}

	function export_graphpage($filetype){
		$data['filetype'] = $filetype;
		(@$_GET['year'])?$txt="ปีงบประมาณ ".@$_GET['year']:$txt="โดยรวมทั้งหมด";
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new Province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			$data['text'] = "ผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (อำเภอ".$data['amphur']->amphur_name.")";
		}elseif(@$_GET['type'] == 4 ){ // ตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรค".$txt." (ตำบล".$data['district']->district_name.")";
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			if(@$_GET['year']){
				$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year'];
			}else{
				$data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคโดยรวมทั้งหมด";
			}
		}
		$this->load->view('export_graphpage',$data);
	}

	function export_detail($filetype){
		$data['filetype'] = $filetype;
		$data['nurseries'] = new Nursery();
		if(@$_GET['area_id']){
			$data['nurseries']->where('area_id',$_GET['area_id']);
			$data['area'] = "สคร.".$_GET['area_id'];
		}
		if(@$_GET['province_id']){
			$data['nurseries']->where('province_id',$_GET['province_id']);
			$province = new Province($_GET['province_id']);
			$data['province'] = "จังหวัด".$province->name;
		}
		if(@$_GET['amphur_id']){
			$data['nurseries']->where("amphur_id = ".$_GET['amphur_id']);
			$amphur = new Amphur($_GET['amphur_id']);
			$data['amphur'] = "อำเภอ".$amphur->amphur_name;
		}

		if(@$_GET['district_id']){
			$data['nurseries']->where("district_id = ".$_GET['district_id']);
			$district = new District($_GET['district_id']);
			$data['district'] = "ตำบล".$district->district_name;
		}
		if(@$_GET['year']){
			$data['nurseries']->where("year = ".$_GET['year']);
			$data['year'] = "ปี ".$_GET['year'];
		}
		if(@$_GET['status'])$data['nurseries']->where("status = ".$_GET['status']);
		$data['nurseries']->order_by('id','desc')->get();
		$this->load->view('export_detail',$data);
	}
}
?>