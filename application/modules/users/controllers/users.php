<?php
class Users extends Public_Controller{
    
    function __construct(){
        parent::__construct();
		ini_set('memory_limit', '-1');
    }
    
    function register(){ // เจ้าหน้าที่สาธารณสุข
        $this->template->build('register');
    }
	
	function register_center(){ // เจ้าหน้าที่ศูนย์เด็กเล็ก
		$condition = " 1=1 ";
		if(@$_GET['name']) $condition .= ' and nurseries.name like "%'.$_GET['name'].'%"';
		if(@$_GET['province_id']) $condition .= ' and nurseries.province_id = '.$_GET['province_id'];
		if(@$_GET['amphur_id']) $condition .= ' and nurseries.amphur_id = '.$_GET['amphur_id'];
		if(@$_GET['district_id']) $condition .= ' and nurseries.district_id = '.$_GET['district_id'];
		
		$sql = "SELECT
				nurseries.id,
				nurseries.`name`,
				districts.district_name,
				amphures.amphur_name,
				provinces.`name` AS province_name
				FROM
				nurseries
				LEFT JOIN districts on nurseries.district_id = districts.id
				LEFT JOIN amphures on nurseries.amphur_id = amphures.id
				LEFT JOIN provinces on nurseries.province_id = provinces.id
				WHERE ".$condition." ORDER BY nurseries.id DESC";
		$nursery = new Nursery();
        $data['nurseries'] = $nursery->sql_page($sql, 20);
		$data['pagination'] = $nursery->sql_pagination;
		
		// นับจำนวน
		$sql = "SELECT
				count(nurseries.id) total
				FROM
				nurseries
				LEFT JOIN districts on nurseries.district_id = districts.id
				LEFT JOIN amphures on nurseries.amphur_id = amphures.id
				LEFT JOIN provinces on nurseries.province_id = provinces.id
				WHERE ".$condition." 
				AND nursery_type != 2
				ORDER BY nurseries.id DESC";
		$data['count'] = $this->db->query($sql)->row();
		
		$this->template->build('register_center_index',$data);
	}
	
	function register_center_school(){ // เจ้าหน้าที่ศูนย์โรงเรียนอนุบาล (โค้ดเดียวกับ register_center ต่างกันแค่ nursery_type)
		$condition = " 1=1 ";
		if(@$_GET['name']) $condition .= ' and nurseries.name like "%'.$_GET['name'].'%"';
		if(@$_GET['province_id']) $condition .= ' and nurseries.province_id = '.$_GET['province_id'];
		if(@$_GET['amphur_id']) $condition .= ' and nurseries.amphur_id = '.$_GET['amphur_id'];
		if(@$_GET['district_id']) $condition .= ' and nurseries.district_id = '.$_GET['district_id'];
		
		$sql = "SELECT
				nurseries.id,
				nurseries.`name`,
				districts.district_name,
				amphures.amphur_name,
				provinces.`name` AS province_name
				FROM
				nurseries
				LEFT JOIN districts on nurseries.district_id = districts.id
				LEFT JOIN amphures on nurseries.amphur_id = amphures.id
				LEFT JOIN provinces on nurseries.province_id = provinces.id
				WHERE ".$condition."
				AND nursery_type = 2
				ORDER BY nurseries.id DESC";
		$nursery = new Nursery();
        $data['nurseries'] = $nursery->sql_page($sql, 20);
		$data['pagination'] = $nursery->sql_pagination;
		
		// นับจำนวน
		$sql = "SELECT
				count(nurseries.id) total
				FROM
				nurseries
				LEFT JOIN districts on nurseries.district_id = districts.id
				LEFT JOIN amphures on nurseries.amphur_id = amphures.id
				LEFT JOIN provinces on nurseries.province_id = provinces.id
				WHERE ".$condition." 
				AND nursery_type = 2
				ORDER BY nurseries.id DESC";
		$data['count'] = $this->db->query($sql)->row();
		
		$this->template->build('register_center_school',$data);
	}
	
	function register_center_form($id=false){
		if($id){
			$u = new User();
			$u->query("select id from users where user_type_id = 9 and nursery_id = ".$id);
			if($u->exists())
			{
				set_notify('success', 'ศูนย์เด็กเล็กนี้มีเจ้าหน้าที่ศูนย์แล้ว');
				redirect('users/register_center');
			}	
		}

		$data['nursery'] = new Nursery($id);
		$this->template->build('register_center_form',$data);
	}
	
	function register_center_school_form($id=false){
		if($id){
			$u = new User();
			$u->query("select id from users where user_type_id = 11 and nursery_id = ".$id);
			if($u->exists())
			{
				set_notify('success', 'ศูนย์เด็กเล็กนี้มีเจ้าหน้าที่ศูนย์แล้ว');
				redirect('users/register_center_school');
			}	
		}

		$data['nursery'] = new Nursery($id);
		$this->template->build('register_center_school_form',$data);
	}
	
	function signup_center($id=false){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				$_POST['area_province_id'] = get_area_province_id($_POST['user_type_id'],$_POST['province_id']);
				
				$nursery = new Nursery($id);
				$nursery->from_array($_POST);
				$nursery->save();
				
				if(!$id){
					$nursery = new Nursery();
					$nursery->order_by('id','desc')->get(1);
				}
				
				$_POST['nursery_id'] = $nursery->id;
				$_POST['m_status'] = 'active';
				$_POST['name'] = $_POST['p_name'].' '.$_POST['p_surname'];
				
				$user = new User();
	            $user->from_array($_POST);
	            $user->save();
	            
	            // สมัครเสร็จ login ต่อทันที
	            if(login($_POST['email'], $_POST['password']))
	            {
	                set_notify('success', 'ยินดีต้อนรับเข้าสู่ระบบค่ะ');
					
					redirect('teachers?nursery_id='.$_POST['nursery_id']);
	            }
				
				// set_notify('success', 'ลงทะเบียนเรียบร้อย');
			}else{
				
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
				redirect($_SERVER['HTTP_REFERER']);
				
			}
            redirect('home');
        }
	}
    
    function signup()
    {
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
				
				$_POST['m_status'] = "active";
                $user->from_array($_POST);
                $user->save();
				
				$mailuser = new User();
				$mailuser->order_by('id','desc')->get(1);
				$this->send_mail2($mailuser);
	            set_notify('success', 'สมัครสมาชิกเรียบร้อย');
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
				redirect($_SERVER['HTTP_REFERER']);
			}
            redirect('home');
        }
    }
    
    function check_username(){
        $user = new User();
        $user->get_by_username($_GET['username']);
        echo ($user->username)?"false":"true";
    }
    
    function check_email()
    {
        $user = new User();
        $user->get_by_email($_GET['email']);
		if($_GET['email'] == user_login()->email){ // ถ้า user ไม่เปลี่ยนอีเมล์
			echo "true";
		}else{
			echo ($user->email)?"false":"true";
		}
    }
	
	function check_nursery(){
		$nurseries = new Nursery();
		if(strlen($_GET['nursery_name']) > 4){
			
			$nurseries->where('name like "%'.$_GET['nursery_name'].'%"')->get();
			if($nurseries->exists())
			{
				echo "<div style='border:1px dashed #888; padding:7px; margin-bottom:10px;'>";
				echo "พบศูนย์เด็กเล็กที่มีชื่อตรงกันอยู่ ".$nurseries->result_count()." ศูนย์";
				echo "<ul>";
				foreach($nurseries as $row){
				echo "<li>".$row->nursery_category->title.$row->name.' ตำบล'.$row->district->district_name.' อำเภอ'.$row->amphur->amphur_name.' จังหวัด'.$row->province->name."<a href='users/register_center/".$row->id."'>ลงทะเบียน</a></li>";
				}
				echo "</ul>";
				echo "</div>";
			}
		}
	}
    
    function check_captcha()
    {
        if($this->session->userdata('captcha')==$_GET['captcha'])
        {
            echo "true";
        }
        else
        {
            echo "false";
        }
    }
    
    function login_frm()
    {
        $this->template->build('login_frm');
    }
    
    function login()
    {
        if($_POST)
        {
            if(login($_POST['email'], $_POST['password']))
            {
                set_notify('success', 'ยินดีต้อนรับเข้าสู่ระบบค่ะ');
				
				
				// if(user_login()->user_type_id == 1 || user_login()->user_type_id == 6 || user_login()->user_type_id == 7 || user_login()->user_type_id == 8){
					// redirect('nurseries/register');
				// }elseif(user_login()->user_type_id == 9){
					// redirect('teachers?nursery_id='.user_login()->nursery_id);
				// }elseif(user_login()->user_type_id == 10){
					// redirect('classrooms/classroom_teacher?nursery_id='.user_login()->nursery_id);
				// }elseif(user_login()->user_type_id == 11){
					// redirect('home/menu');
				// }
				
				redirect('home/menu');
                // redirect($_SERVER['HTTP_REFERER']);
            }
            else
            {
                set_notify('error', 'ชื่อผู้ใช้หรือรหัสผ่านผิดพลาดค่ะ');
                redirect($_SERVER['HTTP_REFERER']);
            }   
        }
        else
        {
            set_notify('error', 'กรุณาทำการล็อคอินค่ะ');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
    
    function inc_login()
    {
        if(is_login())
        {
            $data['user'] = new User($this->session->userdata('id'));
            $this->load->view('inc_member',$data);
        }
        else
        {
            $this->load->view('inc_loginlink');
        }
    }
    
    function logout()
    {
        logout();
        set_notify('error', 'ออกจากระบบเรียบร้อยแล้วค่ะ');
        redirect('home');
        //redirect($_SERVER['HTTP_REFERER']);
    }
    
    function forget_pass_form(){
        
    }
    
    function forget_pass(){
        $this->template->build('forget_pass');
    }
    
    function forget_pass_save(){
        if($_POST){
            $user = new User();
            $user = $user->where('email', $_POST['email'])->limit(1)->get();
            
            $this->send_mail2($user);
            set_notify('success', 'ระบบได้ทำการส่งเมล์แจ้งรหัสผ่านเรียบร้อยแล้วค่ะ');
        }
        redirect('home');
    }
    
    function repass($auth_key){
        if($auth_key != ""){
            $user = new User();
            $data['user'] = $user->where("auth_key = '".$auth_key."'")->get();
            if($user->exists()){
                $this->template->build('repass',$data);
            }else{
                set_notify('error', 'คุณไม่อนุญาติให้เข้าใช้งาน');
                redirect('home');
            }
        }else{
            set_notify('error', 'คุณไม่อนุญาติให้เข้าใช้งาน');
            redirect('home');
        }
    }
    
    function repass_save(){
        if($_POST){
            $user = new User();
            $_POST['password'] = md5(sha1($_POST['password']."secret"));
            $user->where('auth_key', $_POST['auth_key'])->update(array(
                'password'=>$_POST['password'],
                'auth_key'=>''
            ));
            set_notify('success', 'ทำการเปลี่ยนรหัสเรียบร้อย');
        }
        redirect('home');
    }
    
    function send_mail($user){
        if($user->m_status == 'active'){
        	$status = "ผ่านการตรวจสอบจากเจ้าหน้าที่แล้ว";
        }else{
        	$status = "รอการตรวจสอบจากเจ้าหน้าที่";
        }
		
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
        $this->email->to($user->email); //ส่งถึงใคร
        $this->email->subject('แจ้งรหัสผ่าน เว็บไซต์ศูนย์เด็กเล็กปลอดโรค'); //หัวข้อของอีเมล
        $this->email->message('สวัสดีครับ<br><br>ยูสเซอร์เนม : '.$user->email.'<br>รหัสผ่าน : '.$user->password.'<br>สถานะ : '.$status); //เนื้อหาของอีเมล
        
        $result = $this->email->send();
        //echo $this->email->print_debugger();
    }

	function send_mail2($user){
		if($user->m_status == 'active'){
        	$status = "ผ่านการตรวจสอบจากเจ้าหน้าที่แล้ว";
        }else{
        	$status = "รอการตรวจสอบจากเจ้าหน้าที่";
        }
		
	    // ###### PHPMailer #### 
	    require_once("PHPMailer_v5.1/class.phpmailer.php"); // ประกาศใช้ class phpmailer กรุณาตรวจสอบ ว่าประกาศถูก path
	    $mail = new PHPMailer();
	    $mail->IsSMTP();
	    $mail->Host = 'ssl://smtp.googlemail.com';
	    $mail->Port = 465;
	    $mail->Username = 'fdsiakrin@gmail.com';
	    $mail->Password = 'f@vourite';
	    $mail->SMTPAuth = true;
	    $mail->CharSet = "utf-8";
	    $mail->From = "fdsiakrin@gmail.com";       //  account e-mail ของเราที่ใช้ในการส่งอีเมล
	    $mail->FromName = "ศูนย์เด็กเล็กปลอดโรค";
	    $mail->IsHTML(true);                            // ถ้า E-mail นี้ มีข้อความในการส่งเป็น tag html ต้องแก้ไข เป็น true
	    $mail->Subject = 'แจ้งรหัสผ่าน เว็บไซต์ศูนย์เด็กเล็กปลอดโรค';            // หัวข้อที่จะส่ง
	    $mail->Body = 'สวัสดีครับ<br><br>ยูสเซอร์เนม : '.$user->email.'<br>รหัสผ่าน : '.$user->password.'<br>สถานะ : '.$status.'<br><br>เว็บไซต์ศูนย์เด็กเล็กปลอดโรค : <a href="http://demo.favouritedesign.com/healthypreschool/home" target="_blank">http://demo.favouritedesign.com/healthypreschool/home</a>';              // ข้อความ ที่จะส่ง
	    $mail->SMTPDebug = false;
	    $mail->do_debug = 0;
	    $mail->AddAddress($user->email);                      // Email ปลายทางที่เราต้องการส่ง
	    $mail->send();
	    $mail->ClearAddresses();
	    // if (!$mail->send())
	    // {                                                                            
	        // echo "Mailer Error: " . $mail->ErrorInfo;
	        // exit;                        
	    // }
	}
    
    function account_setting(){
        if(is_login()){
            $data['user'] = new User($this->session->userdata('id'));
            $this->template->build('account_setting',$data);
        }else{
            redirect("home");
        }
    }
    
    function account_setting_save(){
        if($_POST){
            $user = new User();
            $_POST['id'] = $this->session->userdata('id');
            $_POST['signature'] = $_POST['detail'];
            $user->from_array($_POST);
            $user->save();
            set_notify('success', 'บันทึกข้อมูลเรียบร้อย');
        }
        redirect($_SERVER['HTTP_REFERER']);
    }
	
	function edit_profile(){
		$data['user'] = new User($this->session->userdata('id'));
		$this->template->build('profile',$data);
	}
	
	function edit_profile_save(){
		if($_POST)
        {
        	$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
	            $user = new User($this->session->userdata('id'));
	            $user->from_array($_POST);
	            $user->save();
	            set_notify('success', 'อัพเดทข้อมูลส่วนตัวเรียบร้อย');
			}else{
				set_notify('error','กรอกรหัสไม่ถูกต้อง');
			}
            redirect($_SERVER['HTTP_REFERER']);
        }
	}
	
	function get_province_under_area(){
		if($_POST){
			if($_POST){
				echo form_dropdown('province_id',get_option('id','name','v_provinces','where area_id = '.$_POST['area_id'].' order by id asc'),'','id="province_under_area" class="input-xlarge" style="margin-top:5px;"','--- สังกัดจังหวัด ---');
			}
		}
	}
	
	function get_province(){
		echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$_GET['province_id'],'class="input-xlarge"','--- เลือกจังหวัด ---');
	}
	
	function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by id asc'),@$_GET['province_id'],'class="input-xlarge" style="margin-top:5px";','--- เลือกอำเภอ ---');
		}
	}
}
?>