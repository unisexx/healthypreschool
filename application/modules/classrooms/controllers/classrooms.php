<?php
class Classrooms extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$classroom = new Classroom();
		if(user_login()->user_type_id == 9 or user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7){ //เจ้าหน้าที่ศูนย์ & สาธารณะสุข
			$classroom->where('nursery_id = '.$_GET['nursery_id']);
		}elseif(user_login()->user_type_id == 10){ //เจ้าหน้าที่ครู ผู้ดูแลเด็ก
			$classroom->where('user_id = '.user_login()->id);
		}
		$data['classes'] = $classroom->order_by('id','desc')->get_page();
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
		$data['classroom'] = new Classroom($id);
		if($id != ""){
			$child = new Classroom_detail();
			$data['childs'] = $child->where("classroom_id = ".$id)->order_by('id','desc')->get();
		}
		$this->template->build('form',$data);
	}
	
	function save($id=false){
		if($_POST){
			$classroom = new Classroom($id);
            $classroom->from_array($_POST);
            $classroom->save();
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('classrooms?nursery_id='.$_POST['nursery_id']);
	}
	
	function delete($id=false){
		if($id){
			$classroom = new Classroom($id);
			$classroom->delete();
			set_notify('success', 'ลบข้อมูลเรียบร้อย');
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
	
	function childform($room_id,$id=false){
		$data['classroom'] = new Classroom($room_id);
		$data['child'] = new Classroom_detail($id);
		
		$this->template->build('childform',$data);
	}
	
	function childsave(){
		if($_POST){
			$child = new Classroom_detail($id);
            $child->from_array($_POST);
            $child->save();
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('classrooms/form/'.$_POST['classroom_id']);
	}
	
	function list_guest($nursery_id){
		$data['nursery_id'] = $nursery_id;
		$classroom = new Classroom();
		$classroom->where('nursery_id = '.$nursery_id);
		$data['classes'] = $classroom->order_by('id','desc')->get_page();
    	$this->template->build('list_guest',$data);
	}
	
	function view($id){
		$data['rs'] = new Classroom($id);
		$data['years'] = $this->db->query("SELECT year FROM classroom_teachers where classroom_id = ".$id." 
UNION
SELECT year FROM classroom_childrens where classroom_id = ".$id." 
ORDER BY year desc")->result();
		$this->template->build('view',$data);
	}
	
	function form_detail($classroom_id=false,$year=false){
		$data['classroom'] = new Classroom($classroom_id);
		if($classroom_id!=""){
			$data['v_nursery'] = new V_nursery($data['classroom']->nursery_id);	
		}
		
		if($year!=""){
			$data['teachers'] = new Classroom_teacher();
			$data['teachers']->where('classroom_id = '.$classroom_id.' and year = '.$year)->get();
			
			$data['childrens'] = new Classroom_children();
			$data['childrens']->where('classroom_id = '.$classroom_id.' and year = '.$year)->get();
			
			$data['year'] = $year;
		}
		
		$this->template->build('form_detail',$data);
	}
	
	function form_detail_save(){
		if($_POST){
			
			// บันทึกข้อมูลครูในห้องเรียน
			if(@$_POST['teacherID']){
				foreach($_POST['teacherID'] as $key=>$value){
					$teacher = new Classroom_teacher($_POST['classroom_teacher_detail_id'][$key]);
					$teacher->year = $_POST['year'];
					$teacher->classroom_id = $_POST['classroom_id'];
					$teacher->user_id = $value;
					$teacher->save();
				}
			}
			
			// บันทึกข้อมูลเด็กในห้องเรียน
			if(@$_POST['childrenID']){
				foreach($_POST['childrenID'] as $key=>$value){
					$children = new Classroom_children($_POST['classroom_children_detail_id'][$key]);
					$children->year = $_POST['year'];
					$children->classroom_id = $_POST['classroom_id'];
					$children->children_id = $value;
					$children->save();
				}
			}
			
			// อัพเดทสถานะครูถ้าเป็นปีการศึกษาปัจจุบัน (max id ของ table classroom_teacher)
			$max = new Classroom_teacher();
			$max->select_max('year');
			$max->where('classroom_id = '.$_POST['classroom_id']);
			$max->get();
			// $max->check_last_query();
			
			if($max->year == $_POST['year']){
				foreach($_POST['teacherID'] as $key=>$value){
					$user = new User($value);
					$user->nursery_id = $_POST['nursery_id'];
					$user->amphur_id = $_POST['amphur_id'];
					$user->district_id = $_POST['district_id'];
					$user->area_province_id = $_POST['area_province_id'];
					$user->save();
				}
			}
			
			set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
		}
		redirect('classrooms/view/'.$_POST['classroom_id']);
	}
	
	function ajax_delete_teacher(){
		if($_POST){
			$rs = new Classroom_teacher($_POST['id']);
			$rs->delete();
		}
	}

	function ajax_delete_children(){
		if($_POST){
			$rs = new Classroom_children($_POST['id']);
			$rs->delete();
		}
	}
	
	function ajax_teacher_save($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				$teacher = new User($id);
	            $teacher->from_array($_POST);
	            $teacher->save();
	            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
				
				echo $_POST['name'];
				// echo "<tr><td>'+childrenName+'</td><td>".$_POST['name']."</td><td><input type='hidden' name='childrenID[]' value=".$teacher->id."><button class='btn btn-mini btn-danger delButton'>ลบ</button></td></tr>";
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
			}
		}
	}
	
	function ajax_children_save($id=false){
		if($_POST){
			$children = new Children($id);
			$_POST['birth_date'] = Date2DB($_POST['birth_date']);
            $children->from_array($_POST);
            $children->save();
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			
			echo $_POST['name'];
		}
	}
}
?>