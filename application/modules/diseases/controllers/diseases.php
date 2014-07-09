<?php
class Diseases extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$disease = new Disease();
		
		if(user_login()->user_type_id == 9){ $condition = " and diseases.nursery_id = ".user_login()->nursery_id; }
		if(user_login()->user_type_id == 10){ $condition = " and diseases.classroom_id in (select id from classrooms where user_id = ".user_login()->id.")"; }
		
		$sql = "SELECT DISTINCT diseases.year,`month`,classroom_id,room_name,users.name teacher_name,diseases.nursery_id,diseases.user_id from diseases
LEFT JOIN classrooms ON classrooms.id = diseases.classroom_id
LEFT JOIN nurseries ON nurseries.id = diseases.nursery_id
LEFT JOIN users ON users.id = classrooms.user_id
WHERE 1=1 ".$condition;
		
		$data['diseases'] = $disease->sql_page($sql);
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
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
		$data['text'] = "สรุปรายงานแบบคัดกรองโรค ";
		
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
		$this->load->view('get_disease_form',$data);
	}

	function save_disease(){
		$disease = new Disease($_GET['id']);
		$disease->from_array($_GET);
		$disease->save();
		
		echo $_GET['c1'].$_GET['c2'].$_GET['c3'].$_GET['c4'].$_GET['c5'];
		echo '<input class="h_id" type="hidden" name="id[]" value="'.$disease->id.'">';
	}
}
?>