<?php

function login($email,$password)
{
	$CI =& get_instance();
	$user = new User();
	$user->where(array('email'=>$email,'password'=>$password))->get();
	if($user->exists())
	{
		$CI->session->set_userdata('id',$user->id);
		$CI->session->set_userdata('level',$user->level_id);
		$CI->session->set_userdata('user_type',$user->user_type_id);
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function is_login($level_name = FALSE)
{
	$CI =& get_instance();
	$user = new User($CI->session->userdata('id'));
	if($level_name)
	{
		$level = new Level();
		if($user->level->level)
		{
			$id = ($level->get_by_level($level_name)->id >= $user->level->id)? true : false ;
		}
		else
		{
			$id = false;
		}
	}
	else
	{
		$id = $user->id;
	}
	return ($id) ? true : false;
}

function user_login($id=FALSE)
{
    $CI =& get_instance();
    $id = ($id)?$id:$CI->session->userdata('id');
    $user = new User($id);
    return $user;
}

function user($id=FALSE)
{
    $CI =& get_instance();
    $id = ($id)?$id:$CI->session->userdata('id');
    $user = new User($id);
    return $user;
}

function logout()
{
	$CI =& get_instance();
	$CI->session->unset_userdata('id');
	$CI->session->unset_userdata('level');
	$CI->session->unset_userdata('user_type');
}

function is_owner($id)
{
    $CI =& get_instance();
    if($id == $CI->session->userdata('id') && $CI->session->userdata('id') != 0)
    {
        return TRUE;
    }
    else
    {
        return FALSE;
    }
}

function permission($module, $action)
{
	$CI =& get_instance();
	$permission = new Permission();
	$perm = $permission->where("user_type_id = ".$CI->session->userdata('user_type')." and module = '".$module."'")->get();
	
	if($perm->$action){
		return TRUE;
	}else{
		return FALSE;
	}
}

function get_user_type_province($user_type_id=false,$user_id=false){
	$CI =& get_instance();
	$user = user_login($user_id);
	$province = new Province();
	$user_type_id = $user_type_id > 0 ? $user_type_id : $user->user_type_id;
	switch($user_type_id)
	{
		case 1: //ผู้ดูแลระบบ
			break;
		case 6:
				$province->where('area_id = '.$user->area_id);
			break;
		case 7:
				$province->where('id = '.$user->province_id);
			break;
		case 8:
				$province->where('id = '.$user->province_id);
			break;
		case 9:
				$province->where('id = '.$user->province_id);
			break;
		case 10:
				$province->where('id = '.$user->province_id);
			break;
		default:
			break;
	}
	return $province;
}

function get_user_type_amphur($user_type_id = false,$user_id = false,$province_id){
	$CI =& get_instance();
	$user = user_login($user_id);
	$amphur = new Amphur();
	$user_type_id = $user_type_id > 0 ? $user_type_id : $user->user_type_id;
	switch($user_type_id)
	{
		case 1: //ผู้ดูแลระบบ
			$amphur->where('province_id = '.$province_id);
			break;
		case 6://เจ้าหน้าที่ประจำเขต
			$amphur->where('province_id = '.$province_id);
			break;
		case 7://เจ้าหน้าที่ประจำจังหวัด
			$amphur->where('province_id = '.$province_id);
			break;
		case 8://เจ้าหน้าที่ประจำอำเภอ
			$amphur->where('id = '.$user->amphur_id);
			break;
		case 9://เจ้าหน้าที่ศูนย์
			$amphur->where('id = '.$user->amphur_id);
			break;
		case 10://เจ้าหน้าที่ครู / ผู้ดูแลเด็ก
			$amphur->where('id = '.$user->amphur_id);
			break;
		default:
			break;
	}
	return $amphur;
}
?>