<?php
class Staffs extends Public_Controller
{
    function __construct()
    {
        // if(user_login()->user_type_id!=1 and user_login()->user_type_id!=6 and user_login()->user_type_id!=7  or user_login()->m_status != "active"){
			// set_notify('error', 'คุณไม่มีสิทธิ์ใช้งานในส่วนนี้ค่ะ');
			// redirect('home');
		// }
        parent::__construct();
		$this->template->set_layout('blank');
    }
    
    function index()
    {
    	if(@$_GET['search']==1){ //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล
    	
	        $data['users'] = new User();
			
			$condition = " user_type_id between 9 and 10 ";
			
			if(@$_GET['search']){
				$condition .= " and (v_users.name like '%".$_GET['name']."%' or v_users.email like '%".$_GET['name']."%')";
			}
			if(@$_GET['nursery_name']){
				$condition .= " and v_nurseries.name like '%".$_GET['nursery_name']."%'";
			}
			if(@$_GET['user_type_id']){
				$condition .= " and v_users.user_type_id = ".$_GET['user_type_id'];
			}
			if(@$_GET['area_id']){
				$condition .= " and v_provinces.area_id = ".$_GET['area_id'];
			}
			if(@$_GET['province_id']){
				$condition .= " and v_provinces.id = ".$_GET['province_id'];
			}
			if(@$_GET['amphur_id']){
				$condition .= " and v_users.amphur_id = ".$_GET['amphur_id'];
			}
			if(@$_GET['district_id']){
				$condition .= " and v_users.district_id = ".$_GET['district_id'];
			}
			if(@$_GET['m_status']){
				$condition .= " and v_users.m_status = '".$_GET['m_status']."'";
			}
			
			$sql = "SELECT
							v_users.user_type_id,
							v_users.id,
							v_users.`name`,
							v_users.email,
							v_provinces.`name` province_name,
							amphures.amphur_name amphur_name,
							districts.district_name district_name,
							v_users.nursery_id,
							v_nurseries.`name` nursery_name,
							v_users.created
							FROM
							v_users
							INNER JOIN v_nurseries ON v_users.nursery_id = v_nurseries.id
							LEFT JOIN v_provinces ON v_users.area_province_id = v_provinces.area_province_id
							LEFT JOIN amphures ON v_users.amphur_id = amphures.id
							LEFT JOIN districts ON v_users.district_id = districts.id
							WHERE  ".$condition." order by id desc";
		
				$user = new User();
		        $data['users'] = $user->sql_page($sql, 20);
				$data['pagination'] = $user->sql_pagination;
				
				// echo $sql;
				
			// นับจำนวนที่ทำการค้นหา
			$sql = "SELECT
							count(v_users.id) total
							FROM
							v_users
							INNER JOIN v_nurseries ON v_users.nursery_id = v_nurseries.id
							LEFT JOIN v_provinces ON v_users.area_province_id = v_provinces.area_province_id
							LEFT JOIN amphures ON v_users.amphur_id = amphures.id
							LEFT JOIN districts ON v_users.district_id = districts.id
							WHERE  ".$condition;
			$data['count'] = $this->db->query($sql)->row_array();
		
		} //endif search=1
		
        $this->template->build('index',@$data);
    }
    
    function form($nursery_id,$id=false){
    	$data['nursery'] = new Nursery($nursery_id);
        $data['user'] = new User($id);
        $this->template->build('form',$data);
    }
    
    function save($id=false){
        if($_POST)
        {
            $captcha = $this->session->userdata('captcha');
            if(($_POST['captcha'] == $captcha) && !empty($captcha)){
                $user = new User($id);
                $user->from_array($_POST);
                $user->save();
				// if($_POST['m_status'] == 'active'){
					// $this->send_mail($_POST);
				// }
                set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
            }else{
                set_notify('error','กรอกรหัสไม่ถูกต้อง');
                redirect($_SERVER['HTTP_REFERER']);
            }
            redirect('staffs');
        }
    }
    
    function delete($id=false){
        if($id)
        {
            $user = new User($id);
            $user->delete();
            set_notify('success', lang('delete_data_complete'));
        }
        redirect('staffs');
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

	function get_area(){
		echo form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_POST['area_id'],'class="input-medium"','--- เลือกสคร. ---');
	}
	
	function get_province(){
		echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$_POST['province_id'],'','--- เลือกจังหวัด ---');
	}
	
	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),@$_POST['amphur_id'],'','--- เลือกอำเภอ ---');
		}
	}
}
?>