<?php
class Diseases extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$disease = new Disease();
		
		if(in_array(user_login()->user_type_id, array(9,11))){ $condition = " and diseases.nursery_id = ".user_login()->nursery_id; }
		if(in_array(user_login()->user_type_id, array(10))){ $condition = " and diseases.classroom_id in (select classroom_id from classroom_teachers where user_id = ".user_login()->id.")"; }
		
		$sql = "SELECT DISTINCT diseases.year,`month`,classroom_id,room_name,users.name teacher_name,diseases.nursery_id,diseases.user_id from diseases
LEFT JOIN classrooms ON classrooms.id = diseases.classroom_id
LEFT JOIN nurseries ON nurseries.id = diseases.nursery_id
LEFT JOIN users ON users.id = classrooms.user_id
WHERE 1=1 ".$condition;
		
		$data['diseases'] = $disease->sql_page($sql);
    	$this->template->build('index',$data);
    }
	
	function index2(){
		$data['rs'] = new Classroom_children_detail();
		$data['rs']->distinct();
		$data['rs']->select('year');
		$data['rs']->where_related('classrooms', 'nursery_id', user_login()->nursery_id)->get();
		
		$this->template->build('index2',$data);
		// $data['rs']->check_last_query();
	}
	
	function form($id=false){
		$this->template->set_layout('disease');
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		if(in_array(user_login()->user_type_id, array(9,11))){ $classroom->where('nursery_id = '.user_login()->nursery_id); }
		if(in_array(user_login()->user_type_id, array(10))){ $classroom->where_related('classroom_teachers','user_id = '.user_login()->id); }
		$data['classrooms'] = $classroom->order_by('room_name','asc')->get();
		// $data['classrooms']->check_last_query();
		
		// หาจำนวนเด็กในห้องที่เลือก
		if($_GET['classroom_id'] != ""){
			$data['childs'] = new Classroom_children();
			$data['childs']->where('year = '.$_GET['year']);
			$data['childs']->where('classroom_id = '.$_GET['classroom_id'])->order_by('id','asc')->get();
		}
		
		// $this->template->build('form',$data);
		$this->template->build('form2',$data);
	}
	
	function save(){
		if($_POST){
			// $disease = new Disease();
			// $disease->where('nursery_id = '.$_POST['nursery_id'][0].' and classroom_id = '.$_POST['classroom_id'][0])->get();
			// $disease->delete_all();
			
			if(isset($_POST['classroom_detail_id'])){
				foreach($_POST['classroom_detail_id'] as $key=>$item){
					
					$data['nursery_id'] = $_POST['nursery_id'][$key];
					$data['classroom_id'] = $_POST['classroom_id'][$key];
					$data['classroom_detail_id'] = $item;
					$data['day'] = $_POST['day'][$key];
					$data['month'] = $_POST['month'][$key];
					$data['year'] = $_POST['year'][$key];
					$data['c1'] = $_POST['c1'][$key];
					$data['user_id'] = user_login()->id;
					// $data['c2'] = $_POST['c2'][$key];
					// $data['c3'] = $_POST['c3'][$key];
					// $data['c4'] = $_POST['c4'][$key];
					// $data['c5'] = $_POST['c5'][$key];
					
					$disease = new Disease($_POST['id'][$key]);
					$disease->from_array($data);
					$disease->save();
					$data = array();
					
				}
				set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			}
			
			$data['nursery_id'] = $_POST['nursery_id'][$key];
			$data['classroom_id'] = $_POST['classroom_id'][$key];
			$data['day'] = $_POST['day'][$key];
			$data['month'] = $_POST['month'][$key];
			$data['year'] = $_POST['year'][$key];
			$data['user_id'] = user_login()->id;
			
			$disease_log = new Disease_log();
			$disease_log->from_array($data);
			$disease_log->save();
			
		}
		redirect('diseases');
	}

	function delete(){
		if($_GET){
			$sql = 'delete from diseases where classroom_id = '.$_GET['classroom_id'].' and month = '.$_GET['month'].' and year = '.$_GET['year'];
			$this->db->query($sql);
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function report(){
		$data['text'] = "สรุปรายงานแบบคัดกรองโรค<br>";
		if(user_login()->nursery_id != ""){ $data['text'] .= get_nursery_name(user_login()->nursery_id); }
		if(@$_GET['classroom_id'] != ""){ $data['text'] .= " ห้องเรียน".get_student_room_name($_GET['classroom_id']); }
		if(@$_GET['month'] != ""){ $data['text'] .= " ประจำเดือน".get_month_name($_GET['month']); }
		if(@$_GET['year'] != ""){ $data['text'] .= " ปีพ.ศ. ".$_GET['year']; }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ $data['text'] .= "ช่วงอายุระหว่าง ".$_GET['lowage']." ถึง ".$_GET['hiage']." ปี"; }
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		if(user_login()->user_type_id == 9){ $classroom->where('nursery_id = '.user_login()->nursery_id); }
		if(user_login()->user_type_id == 10){ $classroom->where('user_id = '.user_login()->id); }
		$data['classrooms'] = $classroom->get();
		
		// หาปี
		$disease = new Disease();
		$sql = "SELECT DISTINCT year
				FROM diseases
				WHERE nursery_id = ".user_login()->nursery_id;
		$data['years'] = $disease->sql_page($sql);
		
		// หาเดือน
		$disease = new Disease();
		$sql = "SELECT DISTINCT month
				FROM diseases
				WHERE nursery_id = ".user_login()->nursery_id;
		$data['months'] = $disease->sql_page($sql);
		
		$this->template->build('report',$data);
	}
	
	function report_guest(){
		$data['text'] = "สรุปรายงานแบบคัดกรองโรค ";
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		$classroom->where('nursery_id = '.$_GET['nursery_id']);
		$data['classrooms'] = $classroom->get();
		
		// หาปี
		$disease = new Disease();
		$sql = "SELECT DISTINCT year
				FROM diseases
				WHERE nursery_id = ".$_GET['nursery_id'];
		$data['years'] = $disease->sql_page($sql);
		
		// หาเดือน
		$disease = new Disease();
		$sql = "SELECT DISTINCT month
				FROM diseases
				WHERE nursery_id = ".$_GET['nursery_id'];
		$data['months'] = $disease->sql_page($sql);
		
		$this->template->build('report_guest',$data);
	}
	
	function report_staff($graphtype=false){
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new Province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			if(@$_GET['year']){$year = 'ปี '.$_GET['year'];}
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".@$year." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			if(@$_GET['year']){$year = 'ปี '.$_GET['year'];}
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".@$year." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			if(@$_GET['year']){$year = 'ปี '.$_GET['year'];}
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".@$year." (อำเภอ".$data['amphur']->amphur_name.")";
		}elseif(@$_GET['type'] == 4 ){ // ศูนย์เด็กเล็กในตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			if(@$_GET['year']){$year = 'ปี '.$_GET['year'];}
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".@$year." (ตำบล".$data['district']->district_name.")";
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			if(@$_GET['year']){@$year = 'ปี '.@$_GET['year'];}
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรคทั้งหมด".@$year;
		}
		$this->template->build('report_staff',$data);
	}

	function detail2(){
		$condition = "";
		if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and d.child_age_year between ".$_GET['lowage']." and ".$_GET['hiage']; }
		if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
		if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
		if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
		if(@$_GET['area_id']){ @$condition.=" and n.area_id = ".$_GET['area_id']; }
		if(@$_GET['province_id']){ @$condition.=" and n.province_id = ".$_GET['province_id']; }
		if(@$_GET['amphur_id']){ @$condition.=" and n.amphur_id = ".$_GET['amphur_id']; }
		if(@$_GET['district_id']){ @$condition.=" and n.district_id = ".$_GET['district_id']; }
		if(@$_GET['nursery_id']){ @$condition.=" and n.id = ".$_GET['nursery_id']; }
		if(@$_GET['title']){ @$condition.=" and cd.title = '".$_GET['title']."'"; }

		$sql = "
		SELECT
		d.id,
		d.nursery_id,
		d.classroom_id,
		d.classroom_detail_id,
		d.`year`,
		d.`month`,
		d.`day`,
		d.start_date,
		d.end_date,
		d.child_age_year,
		d.child_age_month,
		d.c1,
		d.c2,
		d.c3,
		d.c4,
		d.c5,
		d.other,
		n.`name` AS nursery_name,
		n.number,
		n.moo,
		n.area_id,
		n.`code`,
		cd.title,
		cd.child_name,
		amphures.amphur_name,
		districts.district_name,
		provinces.`name` AS province_name,
		classrooms.room_name
		FROM
		diseases AS d
		INNER JOIN classroom_details AS cd ON d.classroom_detail_id = cd.id
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN provinces ON n.province_id = provinces.id
		INNER JOIN amphures ON n.amphur_id = amphures.id
		INNER JOIN districts ON n.district_id = districts.id
		INNER JOIN classrooms ON d.classroom_id = classrooms.id
		WHERE 1=1 and d.c1 = '".$_GET['c1']."' ".@$condition." and start_date IS NOT NULL order by d.start_date desc";
		$disease = new Disease();
		$data['diseases'] = $disease->query($sql);
		// echo $sql;
		$this->template->build('report_detail',$data);
	}

	function detail(){
		$condition = "";
		if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
		if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and d.child_age_year between ".$_GET['lowage']." and ".$_GET['hiage']; }
		if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
		if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
		if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
		if(@$_GET['area_id']){ @$condition.=" and n.area_id = ".$_GET['area_id']; }
		if(@$_GET['province_id']){ @$condition.=" and n.province_id = ".$_GET['province_id']; }
		if(@$_GET['amphur_id']){ @$condition.=" and n.amphur_id = ".$_GET['amphur_id']; }
		if(@$_GET['district_id']){ @$condition.=" and n.district_id = ".$_GET['district_id']; }
		if(@$_GET['nursery_id']){ @$condition.=" and n.id = ".$_GET['nursery_id']; }
		if(@$_GET['start_date'] and @$_GET['end_date']){
			$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
			$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
			$condition .= " and start_date between ".$start_date." and ".$end_date;
		}
		if(@$_GET['start_date'] and @empty($_GET['end_date'])){
			$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
			$condition .= " and start_date >= ".$start_date;
		}
		if(@$_GET['end_date'] and @empty($_GET['start_date'])){
			$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
			$condition .= " and start_date >= ".$end_date;
		}

		$sql = "
		SELECT d.nursery_id, 
		(SELECT count(d.id) total
							FROM
							diseases d
							INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
							INNER JOIN nurseries n ON d.nursery_id = n.id
							WHERE 1=1 and d.c1 = '".$_GET['c1']."' ".@$condition."  and start_date IS NOT NULL) as disease_total,
		(SELECT count(d.id) total
							FROM
							diseases d
							INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
							INNER JOIN nurseries n ON d.nursery_id = n.id
							WHERE 1=1 and cd.title = 'ด.ช.' and d.c1 = '".$_GET['c1']."' ".@$condition."  and start_date IS NOT NULL) as boy,
		(SELECT count(d.id) total
							FROM
							diseases d
							INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
							INNER JOIN nurseries n ON d.nursery_id = n.id
							WHERE 1=1 and cd.title = 'ด.ญ.' and d.c1 = '".$_GET['c1']."' ".@$condition."  and start_date IS NOT NULL) as girl
		FROM diseases AS d 
		INNER JOIN nurseries AS n ON d.nursery_id = n.id INNER JOIN provinces ON n.province_id = provinces.id 
		WHERE 1=1 and d.c1 = '".$_GET['c1']."' ".@$condition."
		group by n.id";
		$disease = new Disease();
		$data['diseases'] = $disease->query($sql);
		// echo $sql;
		$this->template->build('report_detail2',$data);
	}
	
	function form2(){
		$this->template->set_layout('disease');
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		if(user_login()->user_type_id == 9){ $classroom->where('nursery_id = '.user_login()->nursery_id); }
		if(user_login()->user_type_id == 10){ $classroom->where('user_id = '.user_login()->id); }
		$data['classrooms'] = $classroom->get();
		
		// หาจำนวนเด็กในห้องที่เลือก
		if($_GET['classroom_id'] != ""){
			$classroom_detail = new Classroom_detail();
			$data['childs'] = $classroom_detail->where('classroom_id = '.$_GET['classroom_id'])->get();
		}
		
		$this->template->build('form2',$data);
	}
	
	function get_disease_form(){
		$data['disease'] = new Disease($_GET['id']);
		
		// หาวันที่กำลังป่วย (ถ้ามีอยู่ในระหว่างวันที่เลือกไม่ต้องให้ datepicker แสดง)
		$data['sick_date'] = new Disease();
		$data['sick_date']->where("start_date <= '".$_GET['date']."' and '".$_GET['date']."' <= end_date and classroom_detail_id = ".$_GET['classroom_detail_id'])->get();
		
		// $data['sick_date']->check_last_query();
		
		$this->load->view('get_disease_form',$data);
	}

	function save_disease(){
		$disease = new Disease($_GET['id']);
		$explode_age = explode(' ', $_GET['age']);
		$_GET['child_age_year'] = $explode_age[0];
		$_GET['child_age_month'] = $explode_age[2];
		$_GET['start_date'] = @Date2DB($_GET['start_date']);
        $_GET['end_date'] = @Date2DB($_GET['end_date']);
		$disease->from_array($_GET);
		$disease->save();
		
		echo $_GET['c1'].$_GET['c2'].$_GET['c3'].$_GET['c5'];
		echo '<input class="h_id" type="hidden" name="id[]" value="'.$disease->id.'">';
	}

	function delete_disease(){
		$disease = new Disease($_GET['id']);
		$disease->delete();
		echo '';
	}
	
	function list_guest($nursery_id){
		$data['nursery_id'] = $nursery_id;
		$disease = new Disease();
		
		$condition = " and diseases.nursery_id = ".$nursery_id;
		
		$sql = "SELECT DISTINCT diseases.year,`month`,classroom_id,room_name,users.name teacher_name,diseases.nursery_id,diseases.user_id from diseases
LEFT JOIN classrooms ON classrooms.id = diseases.classroom_id
LEFT JOIN nurseries ON nurseries.id = diseases.nursery_id
LEFT JOIN users ON users.id = classrooms.user_id
WHERE 1=1 ".$condition;
		
		$data['diseases'] = $disease->sql_page($sql);
    	$this->template->build('list_guest',$data);
	}
	
	function form_guest(){
		$this->template->set_layout('disease');
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		$classroom->where('nursery_id = '.$_GET['nursery_id']); 
		$data['classrooms'] = $classroom->get();
		
		// หาจำนวนเด็กในห้องที่เลือก
		if($_GET['classroom_id'] != ""){
			$classroom_detail = new Classroom_detail();
			$data['childs'] = $classroom_detail->where('classroom_id = '.$_GET['classroom_id'])->get();
		}
		
		// $this->template->build('form',$data);
		$this->template->build('form_guest',$data);
	}
	
	function get_disease_form_guest(){
		$data['disease'] = new Disease($_GET['id']);
		$this->load->view('get_disease_form_guest',$data);
	}
	
	function export_graphpage($filetype){
		$data['filetype'] = $filetype;
		(@$_GET['year'])?$txt="ปีงบประมาณ ".@$_GET['year']:$txt="โดยรวมทั้งหมด";
		if(@$_GET['type'] == 1 ){ // สคร
			$data['provinces'] = new Province();
			$data['provinces']->where('area_id = '.$_GET['area_id'])->get();
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".$txt." (สคร.".$_GET['area_id'].")";
		}elseif(@$_GET['type'] == 2 ){ // จังหวัด
			$data['province'] = new Province($_GET['province_id']);
			$data['amphurs'] = new Amphur();
			$data['amphurs']->where('province_id = '.$_GET['province_id'])->get();
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".$txt." (จังหวัด".$data['province']->name.")";
		}elseif(@$_GET['type'] == 3 ){ // อำเภอ
			$data['amphur'] = new Amphur($_GET['amphur_id']);
			$data['districts'] = new District();
			$data['districts']->where('amphur_id = ',$_GET['amphur_id'])->get();
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".$txt." (อำเภอ".$data['amphur']->amphur_name.")";
		}elseif(@$_GET['type'] == 4 ){ // ตำบล
			$data['district'] = new District($_GET['district_id']);
			$data['nurseries'] = new Nursery();
			$data['nurseries']->where('district_id = ',$_GET['district_id'])->get();
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค".$txt." (ตำบล".$data['district']->district_name.")";
		}else{
			$data['areas'] = new Area();
			$data['areas']->order_by('id','asc')->get();
			if(@$_GET['year']){
				$data['text'] = "สรุปผลรายงานแบบคัดกรองโรคปีงบประมาณ ".$_GET['year'];
			}else{
				$data['text'] = "สรุปผลรายงานแบบคัดกรองโรคโดยรวมทั้งหมด";
			}
		}
		$this->load->view('export_graphpage',$data);
	}

	function newreport (){
		
		if(@$_GET['search']==1){ //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล
		
			$data['text'] = "สรุปผลรายงานแบบคัดกรองโรค";
			
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
				$data['rs'] = new V_province();
				$data['rs']->where('area_id = '.$_GET['area_id'])->order_by('name','asc')->get();
			}else{
				$data['rs'] = new Area();
				$data['rs']->order_by('id','asc')->get();
			}
		
		}
		
		$this->template->build('newreport',@$data);
	}

	function form3(){
		$this->template->set_layout('disease');
		
		// หาจำนวนห้อง
		$data['classroom'] = new Classroom(@$_GET['classroom_id']);
		// if(user_login()->user_type_id == 9){ $classroom->where('nursery_id = '.user_login()->nursery_id); }
		// if(user_login()->user_type_id == 10){ $classroom->where('user_id = '.user_login()->id); }
		// $data['classrooms'] = $classroom->get();
		
		// หาจำนวนเด็กในห้องที่เลือก
		// if($_GET['classroom_id'] != ""){
			// $classroom_detail = new Classroom_detail();
			// $data['childs'] = $classroom_detail->where('classroom_id = '.$_GET['classroom_id'])->get();
		// }
		$data['childrens'] = new Classroom_children_detail();
		$data['childrens']->where('classroom_id = '.$_GET['classroom_id'].' and year = '.$_GET['school_year'])->order_by('id asc')->get();
		
		$this->template->build('form3',$data);
	}
}
?>