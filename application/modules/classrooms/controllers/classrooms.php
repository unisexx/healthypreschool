<?php
class Classrooms extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index(){
    	$classroom = new Classroom();
		if (in_array(user_login()->user_type_id, array(1,6,7,8,9,11))){ //เจ้าหน้าที่ศูนย์ & สาธารณะสุข
			$classroom->where('nursery_id = '.$_GET['nursery_id']);
		}elseif(user_login()->user_type_id == 10){ //เจ้าหน้าที่ครู ผู้ดูแลเด็ก
			$classroom->where('user_id = '.user_login()->id);
		}
		$data['classes'] = $classroom->order_by('id','desc')->get_page();
		
		// $classroom = new Classroom();
        // $data['classes'] = $classroom->sql_page($sql, 20);
		// $data['pagination'] = $classroom->sql_pagination;
    	$this->template->build('index',$data);
    }
	
	function classroom_teacher(){
		$condition = " 1=1 ";
		if(@$_GET['year']){ @$condition.=" and classroom_teachers.`year` = ".$_GET['year'];  }
		if(@$_GET['room_name']){ @$condition .= " and classrooms.room_name like '%".$_GET['room_name']."%'"; }
		
		$sql = "SELECT
			classrooms.id,
			classrooms.room_name,
			classroom_teachers.`year`,
			(select count(id) from classroom_childrens WHERE classroom_id = classrooms.id AND `year` = classroom_teachers.`year` ) children_count
			FROM
			classrooms
			LEFT JOIN classroom_teachers ON classrooms.id = classroom_teachers.classroom_id 
			WHERE
			".$condition."
			and classroom_teachers.user_id = ".user_login()->id."
		";
		
		$classroom = new Classroom();
        $data['classes'] = $classroom->sql_page($sql, 20);
		$data['pagination'] = $classroom->sql_pagination;
		$this->template->build('classroom_teacher',$data);
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
			// เช็กว่ามีครูหรือนักเรียนอยู่ในห้องหรือไม่ ถ้ามี ไม่ให้ลบ
			$children = $this->db->query("SELECT
														count(classroom_childrens.id) total
														FROM
														classrooms
														INNER JOIN classroom_childrens ON classroom_childrens.classroom_id = classrooms.id
														WHERE classrooms.id = ".$id)->row_array();
			
			$teacher = $this->db->query("SELECT
												count(classroom_teachers.id) total
												FROM
												classrooms
												INNER JOIN classroom_teachers ON classroom_teachers.classroom_id = classrooms.id
												WHERE classrooms.id = ".$id)->row_array();
												
			if($children['total'] == 0 and $teacher['total'] == 0){
				$classroom = new Classroom($id);
				$classroom->delete();
				set_notify('success', 'ลบข้อมูลเรียบร้อย');	
			}else{
				set_notify('error', 'ไม่สามารถลบได้ เนื่องจากมีรายชื่อครูหรือเด็กอยู่ในห้องเรียน');
			}
			
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
		$sql = "SELECT year FROM classroom_teachers where classroom_id = ".$id." 
UNION
SELECT year FROM classroom_childrens where classroom_id = ".$id." 
ORDER BY year desc";
		$data['years'] = $this->db->query($sql)->result();
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
		redirect('classrooms?nursery_id='.$_POST['nursery_id']);
	}
	
	function ajax_delete_teacher(){
		if($_POST){
			$rs = new Classroom_teacher($_POST['id']);
			$rs->delete();
		}
	}
	
	function ajax_delete_teacher_from_system(){
		if($_POST){
			$rs = new User($_POST['id']);
			$rs->delete();
		}
	}
	
	function ajax_get_teacher_data(){
		if($_POST){
			$rs = new User($_POST['id']);
			// echo $rs;
			$array = array(
				$rs->id,
				$rs->name,
				$rs->sex,
				$rs->position,
				$rs->phone,
				$rs->email,
				$rs->password
			);
			echo json_encode($array);
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
				$teacher = new User($id);
	            $teacher->from_array($_POST);
	            $teacher->save();
	            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
				
				echo $_POST['name'];
				// echo "<tr><td>'+childrenName+'</td><td>".$_POST['name']."</td><td><input type='hidden' name='childrenID[]' value=".$teacher->id."><button class='btn btn-mini btn-danger delButton'>ลบ</button></td></tr>";
		}
	}
	
	function ajax_children_save($id=false){
		if($_POST){
			$children = new Children($id);
			$_POST['birth_date'] = Date2DB(str_replace("-","/",$_POST['birth_date']));
            $children->from_array($_POST);
            $children->save();
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			
			echo $_POST['name'];
		}
	}
	
	function check_email()
    {
        $user = new User();
        $user->get_by_email($_GET['email']);
		if($_GET['id'] != ""){ // ถ้า เป็นงาน edit ให้ผ่าน
			echo "true";
		}else{
			echo ($user->email)?"false":"true";
		}
    }
}
?>