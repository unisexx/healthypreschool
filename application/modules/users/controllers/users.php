<?php
class Users extends Public_Controller{
    
    function __construct(){
        parent::__construct();
    }
    
    function register(){ // เจ้าหน้าที่สาธารณสุข
        $this->template->build('register');
    }
	
	function register_center(){ // เจ้าหน้าที่ศูนย์
		$this->template->build('register_center');
	}
	
	function signup_center(){
		if($_POST){
			$captcha = $this->session->userdata('captcha');
			if(($_POST['captcha'] == $captcha) && !empty($captcha)){
				
				$nursery = new Nursery();
				$nursery->from_array($_POST);
				$nursery->save();
				
				$nursery = new Nursery();
				$nursery->order_by('id','desc')->get(1);
				
				$_POST['nursery_id'] = $nursery->id;
				
				$user = new User();
	            $user->from_array($_POST);
	            $user->save();
				
				set_notify('success', 'สมัครสมาชิกเรียบร้อย');
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
				if($_POST['user_type_id'] == 7){ // ถ้าเป็นเจ้าหน้าที่จังหวัดหา area_id
					$province = new Province($_POST['province_id']);
					$_POST['area_id'] = $province->area_id;
				}
				if($_POST['user_type_id'] == 8){ // ภ้าเป็นเจ้าหน้าที่อำเภอหา area_id กับ province_id
					$province = new Province($_POST['province_to_select_amphur']);
					$_POST['area_id'] = $province->area_id;
					$_POST['province_id'] == $_POST['province_to_select_amphur'];
				}
	            $user = new User();
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
		$nurseries->where('name = "'.$_POST['nursery_name'].'"')->get();
		if($nurseries->exists())
		{
			echo "<div style='border:1px dashed #888; padding:7px; margin-bottom:10px;'>";
			echo "พบศูนย์เด็กเล็กที่มีชื่อตรงกันอยู่ ".$nurseries->result_count()." ศูนย์";
			echo "<ul>";
			foreach($nurseries as $row){
			echo "<li>".$row->nursery_category->title.$row->name.' ตำบล'.$row->district->district_name.' อำเภอ'.$row->amphur->amphur_name.' จังหวัด'.$row->province->name."</li>";
			}
			echo "</ul>";
			echo "</div>";
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
				//redirect('nurseries/register');
                redirect($_SERVER['HTTP_REFERER']);
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
				echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.$_POST['area_id'].' order by id asc'),'','class="input-xlarge" style="margin-top:5px;"','--- สังกัดจังหวัด ---');
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