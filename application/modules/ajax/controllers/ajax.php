<?php
Class Ajax extends Public_Controller
{
function get_province(){
		if($_POST){
			$condition = ' 
				WHERE
					id IN (
					select 
					province_id 
					FROM 
					area_provinces 
					WHERE 
					area_id = '.$_POST['area_id'].' and province_id > 0 )'; 
			echo form_dropdown('province_id',get_option('id','name','provinces',$condition.' order by name asc'),'','','--- เลือกจังหวัด  ---');
		}
	}	
	
function get_amphur(){
		if($_POST){
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_POST['province_id'].' order by amphur_name asc'),'','','--- เลือกอำเภอ ---');
		}
	}

function get_district(){
		if($_POST){
			get_district_dropdown(@$_POST['amphur_id'],'');
			//echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_POST['amphur_id'].' order by district_name asc'),'','','--- เลือกตำบล ---');
		}
	}
}
?>