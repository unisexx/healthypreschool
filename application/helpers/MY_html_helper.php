<?php 

if(!function_exists('cycle'))
{
	function cycle()
	{
		static $i;	
		
		if (func_num_args() == 0)
		{
			$args = array('even','odd');
		}
		else
		{
			$args = func_get_args();
		}
		return 'class="'.$args[($i++ % count($args))].'"';
	}
}
if(!function_exists('menu_active'))
{
	function menu_active($module,$controller = FALSE,$class='active')
	{
		$CI =& get_instance();
		if($controller)
		{
			return ($CI->router->fetch_module() == $module && $CI->router->fetch_class() == $controller) ? 'class='.$class : '';	
		}
		else
		{
			return ($CI->router->fetch_module() == $module) ? 'class='.$class : '';	
		}
	}
}

if(!function_exists('menu_active2'))
{
    function menu_active2($module,$controller = FALSE,$class='active')
    {
        $CI =& get_instance();
        if($controller)
        {
            return ($CI->router->fetch_module() == $module && $CI->router->fetch_class() == $controller) ? 'class='.$class : '';    
        }
        else
        {
            return ($CI->router->fetch_module() == $module) ? 'class='.$class : ''; 
        }
    }
}

if(!function_exists('page_active'))
{
	function page_active($page,$uri=4,$class='active')
	{
		$CI =& get_instance();
		return ($CI->uri->segment($uri)==$page) ? 'class='.$class : '';
	}
}

if(!function_exists('option_publish'))
{
	function option_publish()
	{
		return array('on' => 'ON', 'off' => 'OFF');
	}
}

if(!function_exists('get_option'))
{
	function get_option($value,$text,$table,$condition = NULL,$lang = NULL)
	{
		$CI =& get_instance();
		$query = $CI->db->query("select * from $table $condition");
		foreach($query->result() as $item) $option[$item->{$value}] = lang_decode($item->{$text},$lang);
		return $option;
	}
}

function fix_file(&$files)
{
    $names = array( 'name' => 1, 'type' => 1, 'tmp_name' => 1, 'error' => 1, 'size' => 1);

    foreach ($files as $key => $part) {
        // only deal with valid keys and multiple files
        $key = (string) $key;
        if (isset($names[$key]) && is_array($part)) {
            foreach ($part as $position => $value) {
                $files[$position][$key] = $value;
            }
            // remove old key reference
            unset($files[$key]);
        }
    }
}

function thumb($imgUrl,$width,$height,$zoom_and_crop,$param = NULL){
	if(strpos($imgUrl, "http://") !== false){
		return "<img ".$param." src=".$imgUrl." width=".$width." height=".$height.">";
	}else{
		return "<img ".$param." src=".site_url("media/timthumb/timthumb.php?src=".site_url($imgUrl)."&zc=".$zoom_and_crop."&w=".$width."&h=".$height)." width=".$width." height=".$height.">";
	}
}

if(!function_exists('avatar'))
{
    function avatar($img=FALSE,$size = NULL)
    {
        return ($img)?'uploads/users/'.$size.$img:'media/images/webboard/noavatar.gif';
    }
}

function webboard_group($post,$type){
    $CI =& get_instance();
    $webboard_post_level = new Webboard_post_level();
    $webboard_post_level->where('post <',$post)->order_by('post','desc')->limit(1)->get();
    if($webboard_post_level->exists())
    {
        if($type == "name")
        {
            return $webboard_post_level->name;
        }
        else
        {
            return $webboard_post_level->image;
        }
    }
    else
    {
        $webboard_post_level->get_by_name('Starter');
        if($type == "name")
        {
            return $webboard_post_level->name;
        }
        else
        {
            return $webboard_post_level->image;
        }
    }
    
}

function stripUploadString($uploadString){
	$fileName = explode("/", $uploadString);
	$last_key = key(array_slice($fileName, -1, 1, TRUE));
	return $fileName[$last_key];
}

function YoutubeIframe2Thumb($iframeCode,$width,$height){
  $regexstr = '~(?:(?:<iframe [^>]*src=")?|(?:(?:<object .*>)?(?:<param .*</param>)*(?:<embed [^>]*src=")?)?)?(?:https?:\/\/(?:[\w]+\.)*(?:youtu\.be/| youtube\.com| youtube-nocookie\.com)(?:\S*[^\w\-\s])?([\w\-]{11})[^\s]*)"?(?:[^>]*>)?(?:</iframe>|</embed></object>)?~ix';
  $thumb = '<img src="http://img.youtube.com/vi/$1/0.jpg" width="'.$width.'" height="'.$height.'"><input type="hidden" name="cover_pic[]" value="http://img.youtube.com/vi/$1/0.jpg">';
  return preg_replace($regexstr, $thumb, $iframeCode);
}

function remove_dir($dir) 
{ 
	if(is_dir($dir)) 
	{ 
		$dir = (substr($dir, -1) != "/")? $dir."/":$dir; $openDir = opendir($dir); 
		while($file = readdir($openDir)) 
		{ 
			if(!in_array($file, array(".", ".."))) 
			{ 
				if(!is_dir($dir.$file)) 
				{ 
					@unlink($dir.$file); 
				} 
				else 
				{ 
				remove_dir($dir.$file); 
				} 
			} 
		} 
		closedir($openDir); @rmdir($dir); 
	} 
} 

function randomPassword() {
    $alphabet = "abcdefghijklmnopqrstuwxyz123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 6; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function get_user_name($id=false){
	$CI =& get_instance();
	if($id != ""){
		$u = new User();
		$u->query("select name from users where id =".$id);
		$name = $u->name;
	}else{
		$name = "";
	}
	return $name;
}

function chk_center_status($id=false){
	$CI =& get_instance();
	$u = new User();
	$u->query("select id from users where user_type_id = 9 and nursery_id = ".$id);
	if($u->exists())
	{
		return '<span style="color:#D14">ลงทะเบียนแล้ว</span>';
	}
	else
	{
		return '<a href="users/register_center_form/'.$id.'" class="btn btn-mini">ลงทะเบียน</a>';
	}
}

function get_nursery_name($nursery_id=false){
	$CI =& get_instance();
	
	$u = new Nursery();
	$u->query("SELECT
	nurseries.name,
	nursery_categories.title
	FROM
	nurseries
	INNER JOIN nursery_categories ON nursery_categories.id = nurseries.nursery_category_id where nurseries.id =".$nursery_id);
	// $name = $u->title.$u->name;
	$name = $u->name;
	return $name;
}

function get_province_name($id=false){
	$CI =& get_instance();
	$p = new Province();
	$p->query("select name from provinces where id =".$id);
	$name = $p->name;
	
	return $name;
}

function get_amphur_name($id=false){
	$CI =& get_instance();
	$p = new Province();
	$p->query("select amphur_name from amphures where id =".$id);
	$name = $p->amphur_name;
	
	return $name;
}

function get_district_name($id=false){
	$CI =& get_instance();
	$p = new Province();
	$p->query("select district_name from districts where id =".$id);
	$name = $p->district_name;
	
	return $name;
}

function get_student_room_name($id=false){
	$CI =& get_instance();
	$c= new Classroom();
	$c->query("select room_name from classrooms where id =".$id);
	$name = $c->room_name;
	
	return $name;
}

function get_month_name($id=false){
	$arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม');
	
	return $arrayMonth[$id];
}

function get_diseases_name($id=false){
	$arrayDisease = array('C' => 'หวัด', 'H' => 'มือ เท้า ปาก', 'D' => "อุจจาระร่วง", 'F' => 'ไข้', 'R' => 'ไข้ออกผื่น', 'O' => 'อื่นๆ');
	
	return $arrayDisease[$id];
}

function get_querystring($url=false){
	if($url==""){
		$url = basename($_SERVER['REQUEST_URI']);
	}
	preg_match("/\?(.+)/", $url, $matches);
	if (!$matches) {
	    // no matches
	}
	
	return $matches[1];
}
?>