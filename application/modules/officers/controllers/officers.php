<?php
class Officers extends Public_Controller
{
    function __construct()
    {
        if(user_login()->user_type_id!=1 and user_login()->user_type_id!=6 and user_login()->user_type_id!=7  or user_login()->m_status != "active"){
			set_notify('error', 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ค่ะ');
			redirect('home');
		}
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index()
    {
    	
		if(@$_GET['search']==1){ //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล
		
	        $data['users'] = new User();
			if(@$_GET['name'])$data['users']->where("name like '%".$_GET['name']."%' or email like '%".$_GET['name']."%'");
			if(@$_GET['user_type_id'])$data['users']->where("user_type_id = ".$_GET['user_type_id']);
			if(@$_GET['area_id'])$data['users']->where("area_id = ".$_GET['area_id']);
			if(@$_GET['user_type_id'] == 8){
				if(@$_GET['province_id'])$data['users']->where("amphur_id in (select id from amphures where province_id = ".$_GET['province_id'].')');
			}else{
				if(@$_GET['province_id'])$data['users']->where("province_id = ".$_GET['province_id']);
			}
			
			if(@$_GET['amphur_id'])$data['users']->where("amphur_id = ".$_GET['amphur_id']);
			if(@$_GET['m_status'])$data['users']->where("m_status = '".$_GET['m_status']."'");
	        
	        if(user_login()->user_type_id == 1){ // admin เห็นทั้งหมด
	            $data['users']->where('user_type_id > '.user_login()->user_type_id.' and user_type_id < 9 ');
	        }elseif(user_login()->user_type_id == 6){ // เจ้าหน้าที่เขต เห็นเจ้าหน้าที่จังหวัด กับอำเภอ
	            $data['users']->where('(user_type_id > 6 and user_type_id < 9) and area_province_id in (select area_province_id from area_provinces_detail where area_id = '.user_login()->area_id.')');
	        }elseif(user_login()->user_type_id == 7){ // เจ้าหน้าที่จังหวัด เห็นเจ้าหน้าที่อำเภอ
	            $data['users']->where('user_type_id = 8 and amphur_id in (select id from amphures where province_id = '.user_login()->province_id.')');
	        }
	        $data['users']->order_by('id','desc')->get_page();
			// $data['users']->check_last_query();
			
		} //endif search=1
		
        $this->template->build('index',@$data);
    }
    
    function form($id=false){
        $data['user'] = new User($id);
        $this->template->build('form',$data);
    }
    
    function save($id=false){
    	// var_dump($_POST);
        if($_POST)
        {
            $captcha = $this->session->userdata('captcha');
            if(($_POST['captcha'] == $captcha) && !empty($captcha)){
                $user = new User($id);
				
				if($_POST['user_type_id'] == 6){
					$_POST['area_province_id'] = get_area_province_id($_POST['user_type_id'],$_POST['area_id']);
				}elseif($_POST['user_type_id']==7){
					$_POST['area_province_id'] = get_area_province_id($_POST['user_type_id'],$_POST['province_id']);
				}elseif($_POST['user_type_id']==8){
					$_POST['area_province_id'] = get_area_province_id($_POST['user_type_id'],$_POST['province_to_select_amphur']);
				}
				
                $user->from_array($_POST);
                $user->save();
				if($_POST['m_status'] == 'active'){
					$this->send_mail($_POST);
				}
				
                set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
            }else{
                set_notify('error','กรอกรหัสไม่ถูกต้อง');
                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect('officers');
        }
    }
    
    function delete($id=false){
        if($id)
        {
            // $user = new User($id);
            // $user->delete();
			
			$this->db->query('DELETE FROM users WHERE id='.$id);
            set_notify('success', lang('delete_data_complete'));
        }
        redirect('officers');
    }
	
	function check_email($id=false)
    {
        $user = new User();
        $user->get_by_email($_GET['email']);
		
		$curr_user = new User($id);
		
		if($_GET['email'] == $curr_user->email){ // ถ้า user เป็นเมล์เดิม
			echo "true";
		}else{
			echo ($user->email)?"false":"true";
		}
    }
	
	function send_mail(){
        if($_POST){
	        $config = Array(
	            'protocol' => 'smtp',
	            'smtp_host' => 'ssl://smtp.googlemail.com',
	            'smtp_port' => 465,
	            'smtp_user' => 'fdsiakrin@gmail.com',
	            'smtp_pass' => 'f@vourite',
	            'mailtype'  => 'html', 
	            'charset'   => 'utf-8'
	        );
	        $this->load->library('email', $config);
	        $this->email->set_newline("\r\n");
	        
	        // Set to, from, message, etc.
	        $this->email->from('fdsiakrin@gmail.com', 'ศูนย์เด็กเล็กปลอดโรค');
	        $this->email->to($_POST['email']); //ส่งถึงใคร
	        $this->email->subject('แจ้งสถานะสมาชิกเว็บไซต์ศูนย์เด็กเล็กปลอกโรค'); //หัวข้อของอีเมล
	        $this->email->message('สวัสดีครับ<br><br>เจ้าหน้าที่ได้ทำการตรวจสอบข้อมูลแล้ว คุณสามารถล็อกอินเพื่อเข้าใช้งานระบบได้ทันที ตามลิ้งค์ที่แนบไว้ด้านล่างนี้<br><br><a href="http://'.$_SERVER['SERVER_NAME'].'/healthypreschool">http://'.$_SERVER['SERVER_NAME'].'/healthypreschool</a><br><br>ขอบคุณครับ'); //เนื้อหาของอีเมล
	        
	        $result = $this->email->send();
	        //echo $this->email->print_debugger();
	    }
    }

	function get_area(){
		echo form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12','13'=>'สคร.13'),@$_POST['area_id'],'class="input-medium"','--- เลือกสคร. ---');
	}
	
	function get_province(){
		if(user_login()->user_type_id == 6){ $condition = " where area_id = ".user_login()->area_id; }
		echo form_dropdown('province_id',get_option('id','name','v_provinces '.@$condition.' order by name asc'),@$_POST['province_id'],'','--- เลือกจังหวัด ---');
	}
	
	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),@$_POST['amphur_id'],'','--- เลือกอำเภอ ---');
		}
	}
	
}
?>