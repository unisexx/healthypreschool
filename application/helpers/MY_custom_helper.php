<?php
function get_area_province($area_id) {
	$CI = &get_instance();
	$sql = "SELECT
					*
				FROM
					provinces
				WHERE
					id IN (
					select 
					province_id 
					FROM 
					area_provinces 
					WHERE 
					area_id = ".$area_id." and province_id > 0 
					)
		   ";
	$result = $CI -> db -> query($sql)->result();
	return $result;
}

function get_pass_all_status($user_id = false) {
	$status = 1;
	$CI = &get_instance();
	$sql = "SELECT
					ifnull(count(*),0)n_nopass
				FROM
					questionresults
				WHERE
					user_id = " . $user_id . "
				and ifnull(set_final,0) = 0
				and topic_status = 'approve'
				and score < pass";
	$result = $CI -> db -> query($sql) -> result();
	$status = $result[0] -> n_nopass > 0 ? FALSE : TRUE;
	return $status;
}

function get_pass_final_status($user_id = false){
	$status = 0;
	$CI = &get_instance();
	$sql = "SELECT
					ifnull(count(*),0)n_pass
				FROM
					questionresults
				WHERE
					user_id = " . $user_id . "
				and ifnull(set_final,0) = 1
				and topic_status = 'approve'
				and score >= pass ";
	$result = $CI -> db -> query($sql) -> result();
	$status = $result[0] -> n_pass > 0 ? TRUE : FALSE;
	return $status;
}

 
function get_area_dropdown($selected_value=''){
	$current_user = user_login();	
    if(@$current_user->user_type_id >= 6){
		$ext_condition = ' WHERE id = '.$current_user->area_id;
		$selected_value = $current_user->area_id;
	}	
	else{
		$ext_condition = ' WHERE 1=1 ';
	}
  	echo form_dropdown('area_id',get_option('id','area_name','areas',@$ext_condition.' order by id asc'),@$selected_value,' style="width:150px;"','--- เลือกเขตสคร. ---');
}   

function get_province_dropdown($area_id, $selected_value='',$show_all = false){
	$current_user = user_login();	
	if($show_all==false){
		
				if(@$current_user->user_type_id == 6){
			  		$ext_condition = ' WHERE id in (SELECT province_id FROM area_provinces WHERE area_id='.$current_user->area_id.')';
				}
				else if(@$current_user->user_type_id >= 7){
			  		$ext_condition = ' WHERE id = '.$current_user->province_id;
			  		$selected_value = $current_user->province_id;
				}
				else if(@$area_id>0){
					$ext_condition = ' WHERE id in (SELECT province_id FROM area_provinces WHERE area_id='.$area_id.')';
				}
				else{
					$ext_condition = ' WHERE 1=1 ';
				}

	}else{
		if(@$area_id>0){
			$ext_condition = ' WHERE id in (SELECT province_id FROM area_provinces WHERE area_id='.$area_id.')';
		}
		else{
			$ext_condition = ' WHERE 1=1 ';
		}
	}
  	echo form_dropdown('province_id',get_option('id','name','provinces',@$ext_condition.' order by name asc'),@$selected_value,' style="width:150px;"','--- เลือกจังหวัด ---'); 
}
function get_amphur_dropdown($province_id='', $selected_value='',$show_all = false){
	$current_user = user_login();
	if($province_id>0){                       	
    	$ext_condition = 'where province_id = '.$province_id;
		if($show_all==false){
	    	if(@$current_user->user_type_id >= 8){
	      		$ext_condition .= ' AND id = '.$current_user->amphur_id;
			}
		}
       echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures',$ext_condition.' order by amphur_name asc'),@$selected_value,'style="width:250px;"','--- เลือกอำเภอ ---');
	}else{
	   echo '<select name="amphur_id" id="amphur_id" disabled="disabled"><option value="">แสดงทั้งหมด</option></select>';
	}
}
function get_district_dropdown($amphur_id, $selected_value='', $show_all = false){
	$current_user = user_login();
	if($amphur_id>0){
    	$ext_condition = 'where amphur_id = '.$amphur_id;
		if($show_all==false){
	    	if(@$current_user->user_type_id > 8){
	      		$ext_condition .= ' AND id = '.$current_user->district_id;
			}
		}
   		echo form_dropdown('district_id',get_option('id','district_name','districts',$ext_condition.' order by district_name asc'),@$selected_value,'style="width:250px;"','--- เลือกตำบล ---');
	}else{ 
        echo '<select name="district_id" id="district_id" disabled="disabled"><option value="">แสดงทั้งหมด</option></select>';
	}
}

function get_nursery_dropdown($area_id='',$province_id='',$amphur_id='',$district_id='',$selected_value=''){
		$condition = ' WHERE 1=1';
		$condition .= $area_id > 0 ? ' AND area_id = '.$district_id : '';
		$condition .= $province_id > 0 ? ' AND province_id = '.$province_id : '';
		$condition .= $amphur_id > 0 ? ' AND amphur_id = '.$amphur_id : '';
		$condition .= $district_id > 0 ? ' AND district_id = '.$district_id : '';
		if($condition!='1=1'){
			echo form_dropdown('nursery_id',get_option('id','nursery_name','v_nurseries',$ext_condition.' order by nursery_name asc'),@$selected_value,'style="width:250px;"','--- เลือกศูนย์เด็กเล็ก/โรงเรียนอนุบาล ---');
		}else{
			echo '<select name="nursery_id" id="nursery_id" disabled="disabled"><option value="">แสดงทั้งหมด</option></select>';
		}
}

function get_elearning_count(){
  $CI = &get_instance();
  $sql = "SELECT
                count(*)nresult
            FROM
                v_user_question_result
            WHERE
                set_final = 1
                AND n_answer > 0;
         ";
    $result = $CI -> db -> query($sql)->result();
    return @$result[0]->nresult;  
} 

function get_elearning_pass_count(){
  $CI = &get_instance();
  $sql = "SELECT
                count(*)nresult
            FROM
                v_user_question_result
            WHERE
                set_final = 1
                AND n_answer > 0
                AND score>=pass
         ";

    $result = $CI -> db -> query($sql)->result();
    return @$result[0]->nresult;  
}   

function report_desease_watch_report_column($value){
    //$child_style = 'style="border-left:2px dotted #CCCCCC;"';
    $child_style = '';
    $data ='';
    $data.= create_desease_watch_report_column(@$value[0]->n_event);
    $data.= create_desease_watch_report_column(@$value[0]->n_event_school,$child_style);
    $data.= create_desease_watch_report_column(@$value[0]->n_event_community,$child_style);
    
    $data.= create_desease_watch_report_column(@$value[0]->total_amount);
    $data.= create_desease_watch_report_column(@$value[0]->total_amount_school,$child_style);
    $data.= create_desease_watch_report_column(@$value[0]->total_amount_community,$child_style);
    
    $data.= create_desease_watch_report_column(@$value[0]->boy_amount);
    $data.= create_desease_watch_report_column(@$value[0]->boy_amount_school,$child_style);
    $data.= create_desease_watch_report_column(@$value[0]->boy_amount_community,$child_style);
    
    $data.= create_desease_watch_report_column(@$value[0]->girl_amount);
    $data.= create_desease_watch_report_column(@$value[0]->girl_amount_school,$child_style);
    $data.= create_desease_watch_report_column(@$value[0]->girl_amount_community,$child_style);
    
    echo $data;        
}

function create_desease_watch_report_column($dvalue,$style=''){
    $str_column ='<td '.$style.'>';    
    $str_column.= @$dvalue > 0 ? number_format($dvalue,0) : '&nbsp;';
    $str_column.='</td>';
    return $str_column;
}

function get_desease_watch_sql($condition){
                        $sql = " SELECT
                        disease,                        
                        COUNT(v_disease_watch.id)n_event,
                        (
                            SELECT count(*) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 1 ".$condition."
                        )n_event_school,
                        (
                            SELECT count(*) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 2 ".$condition."
                        )n_event_community,
                        SUM(total_amount)total_amount,
                        (
                            SELECT SUM(total_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 1 ".$condition."
                        )total_amount_school,
                        (
                            SELECT SUM(total_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 2 ".$condition."
                        )total_amount_community,
                        SUM(boy_amount)boy_amount,
                        (
                            SELECT SUM(boy_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 1 ".$condition."
                        )boy_amount_school,
                        (
                            SELECT SUM(boy_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 2 ".$condition."
                        )boy_amount_community,
                        SUM(girl_amount)girl_amount,
                        (
                            SELECT SUM(girl_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 1 ".$condition."
                        )girl_amount_school,
                        (
                            SELECT SUM(girl_amount) FROM
                                v_disease_watch
                            WHERE 1=1 AND place_type = 2 ".$condition."
                        )girl_amount_community
                    FROM
                        v_disease_watch
                    WHERE
                        1=1 ".$condition;     
                    return $sql;
}

function report_desease_watch_symptom_report_column($sql){
        $CI = &get_instance();
        $all = $CI->db->query($sql.' and place_type = 1 ')->result();
        $school = $CI->db->query($sql.' and place_type = 1 ')->result();
        $community = $CI->db->query($sql.' and place_type = 2 ')->result();
        echo $column =$all[0]->n_symptom > 0 ?'<td style="width:100px;">'.$all[0]->n_symptom.'</td>' : '<td style="width:100px;">&nbsp;</td>';
        echo $column =$school[0]->n_symptom > 0 ?'<td style="width:100px;">'.$school[0]->n_symptom.'</td>' : '<td style="width:100px;">&nbsp;</td>';
        echo $column =$community[0]->n_symptom > 0 ?'<td style="width:100px;">'.$community[0]->n_symptom.'</td>' : '<td style="width:100px;">&nbsp;</td>';
}
?>