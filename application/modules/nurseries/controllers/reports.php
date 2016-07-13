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
		
		if(@$_GET['search_type'] == 1){ //ย้อนหลัง 3 ปี
			
			if(@$_GET['three_year']){
			$txt = "ปี ".($_GET['three_year']-2)." - ".$_GET['three_year'];
			}
			
		}elseif(@$_GET['search_type'] == 2){ // ระหว่างปี
			
			if(@$_GET['start_year'] and @$_GET['end_year']){
			$txt = "ปี ".$_GET['start_year']." - ".$_GET['end_year'];
			}
			if(@$_GET['start_year'] and @empty($_GET['end_year'])){
				$txt = "ตั้งแต่ปี พ.ศ. ".$_GET['start_year'];
			}
			if(@$_GET['end_year'] and @empty($_GET['start_year'])){
				$txt = "จนถึงปี พ.ศ. ".$_GET['end_year'];
			}
			
		}
		
		
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new V_province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			$data['text'] = "ผลการดำเนินงานป้องกันควบคุมโรคติดต่อในศดล.".$txt." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			$data['text'] = "ผลการดำเนินงานป้องกันควบคุมโรคติดต่อในศดล.".$txt." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			$data['text'] = "ผลการดำเนินงานป้องกันควบคุมโรคติดต่อในศดล.".$txt." (อำเภอ".$data['amphur']->amphur_name.")";
			$this->template->build('amphur_report',$data);
		}elseif(@$_GET['type'] == 4 ){ // ตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			$data['text'] = "ผลการดำเนินงานป้องกันควบคุมโรคติดต่อในศดล.".$txt." (ตำบล".$data['district']->district_name.")";
			$this->template->build('amphur_report',$data);
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			
			$data['text'] = "ผลการดำเนินงานป้องกันควบคุมโรคติดต่อในศดล.แยกรายสคร.".$txt;
			
			// if(@$_GET['year']){
				// $data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคปีงบประมาณ ".$_GET['year'];
			// }else{
				// $data['text'] = "สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคโดยรวมทั้งหมด";
			// }
		}
		if($graphtype=="basic_column"){
			
			if(@$_GET['export_type'] == 'print'){
				$this->load->view('report',$data);
			}else{
				$this->template->build('report',$data);
			}
			
			// $this->template->build('report',$data);
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
		
		$condition = " 1=1 ";
		
		if(@$_GET['area_id']){
			$condition .= " and area_provinces_detail.area_id = ".$_GET['area_id'];
			$data['area'] = "สคร.".$_GET['area_id'];
		}
		if(@$_GET['province_id']){
			$condition .= " and area_provinces_detail.province_id = ".$_GET['province_id'];
			$data['province'] = "จังหวัด".get_province_name($_GET['province_id']);
		}
		if(@$_GET['amphur_id']){
			$condition .=" and v_nurseries.amphur_id = ".$_GET['amphur_id'];
			$data['amphur'] = "อำเภอ".get_amphur_name($_GET['amphur_id']);
		}

		if(@$_GET['district_id']){
			$condition .=" and v_nurseries.district_id = ".$_GET['district_id'];
			$data['district'] = "ตำบล".get_district_name($_GET['district_id']);
		}
		if(@$_GET['year']){
			$condition .=" and v_nurseries.year = ".$_GET['year'];
			$data['year'] = "ปี ".$_GET['year'];
		}

		if(@$_GET['search_type'] == 1){ //ย้อนหลัง 3 ปี
			
			if(@$_GET['three_year']){
				$condition .= " and v_nurseries.year between ".($_GET['three_year'] - 2)." and ".$_GET['three_year'];
				$data['year'] = "ตั้งแต่ปี พ.ศ. ".($_GET['three_year']-2)." ถึง พ.ศ. ".$_GET['three_year'];
			}
			
		}elseif(@$_GET['search_type'] == 2){ // ระหว่างปี
			
			if(@$_GET['start_year'] and @$_GET['end_year']){
				$condition .= " and v_nurseries.year between ".$_GET['start_year']." and ".$_GET['end_year'];
				$data['year'] = "ระหว่างปี ".$_GET['start_year']." ถึง ".$_GET['end_year'];
			}
			if(@$_GET['start_year'] and @empty($_GET['end_year'])){
				$condition .= " and v_nurseries.year >= ".$_GET['start_year'];
				$data['year'] = "ตั้งแต่ปี ".$_GET['start_year'];
			}
			if(@$_GET['end_year'] and @empty($_GET['start_year'])){
				$condition .= " and v_nurseries.year >= ".$_GET['end_year'];
				$data['year'] = "จนถึงปี ".$_GET['end_year'];
			}
			
		}
		
		if($_GET['status'] != ""){
			$condition .=" and v_nurseries.status = ".$_GET['status'];
		}
		
		$sql="SELECT
						v_nurseries.id,
						v_nurseries.name,
						v_nurseries.p_title,
						v_nurseries.p_name,
						v_nurseries.p_surname,
						v_nurseries.created,
						v_nurseries.user_id,
						v_nurseries.status,
						v_nurseries.year,
						v_nurseries.approve_year,
						v_nurseries.approve_date,
						v_nurseries.approve_user_id,
						area_provinces_detail.name province_name,
						amphures.amphur_name,
						districts.district_name,
						assessments.total assessments_total
					FROM
						v_nurseries
					LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
					LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
					LEFT JOIN districts ON v_nurseries.district_id = districts.id
					LEFT JOIN assessments ON v_nurseries.id = assessments.nursery_id
					WHERE
					".@$condition." order by v_nurseries.id desc";
		
		$nursery = new V_nursery();
		$data['nurseries'] = $nursery->sql_page($sql, 20);
		$data['pagination'] = $nursery->sql_pagination;
		// echo $sql;
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
		
		$condition = " 1=1 ";
		
		if(@$_GET['area_id']){
			$condition .= " and area_provinces_detail.area_id = ".$_GET['area_id'];
			$data['area'] = "สคร.".$_GET['area_id'];
		}
		if(@$_GET['province_id']){
			$condition .= " and area_provinces_detail.province_id = ".$_GET['province_id'];
			$data['province'] = "จังหวัด".get_province_name($_GET['province_id']);
		}
		if(@$_GET['amphur_id']){
			$condition .=" and v_nurseries.amphur_id = ".$_GET['amphur_id'];
			$data['amphur'] = "อำเภอ".get_amphur_name($_GET['amphur_id']);
		}

		if(@$_GET['district_id']){
			$condition .=" and v_nurseries.district_id = ".$_GET['district_id'];
			$data['district'] = "ตำบล".get_district_name($_GET['district_id']);
		}
		if(@$_GET['year']){
			$condition .=" and v_nurseries.year = ".$_GET['year'];
			$data['year'] = "ปี ".$_GET['year'];
		}
		if(isset($_GET['status'])){
			$condition .=" and v_nurseries.status = ".$_GET['status'];
		}
		
		$sql="SELECT
						v_nurseries.id,
						v_nurseries.name,
						v_nurseries.p_title,
						v_nurseries.p_name,
						v_nurseries.p_surname,
						v_nurseries.created,
						v_nurseries.user_id,
						v_nurseries.status,
						v_nurseries.year,
						v_nurseries.approve_year,
						v_nurseries.approve_date,
						v_nurseries.approve_user_id,
						area_provinces_detail.name province_name,
						amphures.amphur_name,
						districts.district_name,
						assessments.total assessments_total
					FROM
						v_nurseries
					LEFT JOIN area_provinces_detail ON v_nurseries.area_province_id = area_provinces_detail.area_province_id
					LEFT JOIN amphures ON v_nurseries.amphur_id = amphures.id
					LEFT JOIN districts ON v_nurseries.district_id = districts.id
					LEFT JOIN assessments ON v_nurseries.id = assessments.nursery_id
					WHERE
					".@$condition." order by v_nurseries.id desc";
		
		$nursery = new V_nursery();
		$data['nurseries'] = $nursery->sql_page($sql, 999999);
		
		$this->load->view('export_detail',$data);
	}

	function export_province($filetype){
		$data['filetype'] = $filetype;
		for ($x = 1; $x <= 77; $x++) {
			$data['nurseries'] = new Nursery();
			
			$data['nurseries']->where('province_id',$x);
			$province = new Province($x);
			$data['province'] = "จังหวัด".$province->name;
			
			$data['nurseries']->order_by('id','desc')->get();
			$this->load->view('export_detail',$data);
		} 
	}
}
?>