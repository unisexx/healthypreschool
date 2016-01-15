<?php
Class Ajax extends Public_Controller
{
function get_province(){
		$area_id = @$_POST['area_id']!=''? $_POST['area_id'] : @$_GET['area_id'];
		get_province_dropdown($area_id,'');
	}

function get_amphur(){
		$province_id = @$_POST['province_id']!=''? $_POST['province_id'] : @$_GET['province_id'];
		get_amphur_dropdown(@$province_id,'');
	}

function get_district(){
		$amphur_id = @$_POST['amphur_id']!=''? $_POST['amphur_id'] : @$_GET['amphur_id'];
		get_district_dropdown(@$amphur_id,'');
	}

function get_nursery(){
	if(isset($_GET['district_id']) && ($_GET['district_id']!="")){
		echo @form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.@$_GET['district_id'].' order by name asc'),@$_GET['nursery_id'],'id="nursery"','--- เลือกศูนย์เด็กเล็ก ---');
	}else{
		echo form_dropdown('nursery_id',array(''=>'--- เลือกศูนย์เด็กเล็ก ---'),'','id="nursery" class="span4" disabled');
	}
}

function get_classroom(){
	if(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
		echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.@$_GET['nursery_id'].' order by room_name asc'),@$_GET['classroom_id'],'id="classroom"','--- เลือกห้องเรียน ---');
	}else{
		echo form_dropdown('nursery_id',array(''=>'--- เลือกห้องเรียน ---'),'','id="classroom" class="span4" disabled');
	}
}

}
?>
