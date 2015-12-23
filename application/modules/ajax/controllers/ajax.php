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
}
?>