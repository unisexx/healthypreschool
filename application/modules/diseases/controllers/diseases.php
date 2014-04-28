<?php
class Diseases extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
    
    function index(){
    	$classroom = new Classroom();
		$data['classes'] = $classroom->where('user_id = '.user_login()->id)->order_by('id','desc')->get_page();
    	$this->template->build('index',$data);
    }
	
	function form($id=false){
		$this->template->set_layout('disease');
		
		// หาจำนวนห้อง
		$classroom = new Classroom();
		$data['classrooms'] = $classroom->where('user_id = '.user_login()->id)->get();
		
		// หาจำนวนเด็กในห้องที่เลือก
		if($_GET['classroom_id'] != ""){
			$classroom_detail = new Classroom_detail();
			$data['childs'] = $classroom_detail->where('classroom_id = '.$_GET['classroom_id'])->get();
		}
		
		$this->template->build('form',$data);
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
					$data['c2'] = $_POST['c2'][$key];
					$data['c3'] = $_POST['c3'][$key];
					$data['c4'] = $_POST['c4'][$key];
					$data['c5'] = $_POST['c5'][$key];
					
					$disease = new Disease($_POST['id'][$key]);
					$disease->from_array($data);
					$disease->save();
					$data = array();
					
				}
				set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
			}
		}
		redirect($_SERVER['HTTP_REFERER']);
	}
}
?>