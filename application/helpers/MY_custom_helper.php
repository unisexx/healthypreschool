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
                
    $sql = "
    SELECT COUNT(*)n_nopass FROM (
SELECT
qr.*,
question_topics.orderlist,
(
        SELECT
            `user_question_result`.`create_date`
        FROM
            `user_question_result`
        WHERE
            (
                (
                    `user_question_result`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS `create_date`,
(
        SELECT
            `user_question_result`.`update_date`
        FROM
            `user_question_result`
        WHERE
            (
                (
                    `user_question_result`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS `update_date`,
(
        SELECT
            ifnull(
                sum(`question_choices`.`score`),
                0
            )
        FROM
            (
                (
                    `question_choices`
                    JOIN `question_answers` ON (
                        (
                            `question_choices`.`id` = `question_answers`.`choice_id`
                        )
                    )
                )
                LEFT JOIN `question_titles` ON (
                    (
                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                    )
                )
            )
        WHERE
            (
                (
                    `question_answers`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `question_titles`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS score,
(
        SELECT
            ifnull(count(0), 0)
        FROM
            (
                `question_answers`
                LEFT JOIN `question_titles` ON (
                    (
                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                    )
                )
            )
        WHERE
            (
                (
                    `question_titles`.`topic_id` = `qr`.`topic_id`
                )
                AND (
                    `question_answers`.`user_id` = `qr`.`user_id`
                )
            )
    ) AS `n_answer`
FROM
(
SELECT
    `users`.`id` AS `user_id`,
    `users`.`name` AS `name`,
    `qt`.`id` AS `topic_id`,
    `qt`.`title` AS `topic_title`,
    `qt`.`set_final` AS `set_final`,
    `qt`.`status` AS `topic_status`,
    `qt`.`pass` AS `pass`,
  `qt`.`random` AS `n_question` 
FROM
    (
        `users`
        JOIN `question_topics` `qt`
    )
WHERE 
users.id = ".$user_id."
)qr
left join question_topics on qr.topic_id = question_topics.id
WHERE
ifnull(qr.set_final,0) = 0
and topic_status = 'approve'
)b
WHERE score < pass
    ";
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
    
    $sql = "
SELECT COUNT(*)n_pass FROM (
SELECT
qr.*,
question_topics.orderlist,
(
        SELECT
            `user_question_result`.`create_date`
        FROM
            `user_question_result`
        WHERE
            (
                (
                    `user_question_result`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS `create_date`,
(
        SELECT
            `user_question_result`.`update_date`
        FROM
            `user_question_result`
        WHERE
            (
                (
                    `user_question_result`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `user_question_result`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS `update_date`,
(
        SELECT
            ifnull(
                sum(`question_choices`.`score`),
                0
            )
        FROM
            (
                (
                    `question_choices`
                    JOIN `question_answers` ON (
                        (
                            `question_choices`.`id` = `question_answers`.`choice_id`
                        )
                    )
                )
                LEFT JOIN `question_titles` ON (
                    (
                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                    )
                )
            )
        WHERE
            (
                (
                    `question_answers`.`user_id` = `qr`.`user_id`
                )
                AND (
                    `question_titles`.`topic_id` = `qr`.`topic_id`
                )
            )
    ) AS score,
(
        SELECT
            ifnull(count(0), 0)
        FROM
            (
                `question_answers`
                LEFT JOIN `question_titles` ON (
                    (
                        `question_answers`.`questionaire_id` = `question_titles`.`id`
                    )
                )
            )
        WHERE
            (
                (
                    `question_titles`.`topic_id` = `qr`.`topic_id`
                )
                AND (
                    `question_answers`.`user_id` = `qr`.`user_id`
                )
            )
    ) AS `n_answer`
FROM
(
SELECT
    `users`.`id` AS `user_id`,
    `users`.`name` AS `name`,
    `qt`.`id` AS `topic_id`,
    `qt`.`title` AS `topic_title`,
    `qt`.`set_final` AS `set_final`,
    `qt`.`status` AS `topic_status`,
    `qt`.`pass` AS `pass`,
  `qt`.`random` AS `n_question` 
FROM
    (
        `users`
        JOIN `question_topics` `qt`
    )
WHERE 
users.id = ".$user_id."
)qr
left join question_topics on qr.topic_id = question_topics.id
WHERE
ifnull(qr.set_final,0) = 1
and topic_status = 'approve'
)b
WHERE score >= pass    
    ";
				
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
				}elseif(@$current_user->user_type_id == 8){
			  		$ext_condition = ' WHERE id in (SELECT province_id FROM amphures WHERE id = '.$current_user->amphur_id.')';
					$selected_value = $current_user->province_id;
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
	}else if($show_all==false && @$current_user->user_type_id >= 8){
	      	$ext_condition = ' WHERE id = '.$current_user->amphur_id;
			$selected_value = $current_user->amphur_id;
			echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures',$ext_condition.' order by amphur_name asc'),@$selected_value,'style="width:250px;"','--- เลือกอำเภอ ---');
	}
	else{
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
   		echo @form_dropdown('district_id',@get_option('id','district_name','districts',$ext_condition.' order by district_name asc'),@$selected_value,'style="width:250px;"','--- เลือกตำบล ---');
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

function get_elearning_count($condition=FALSE){
  $CI = &get_instance();
  $sql = "
  select count(*)nresult from (
        SELECT
                        `users`.`id` AS `user_id`,
                        `users`.`name` AS `name`,
                        `qt`.`id` AS `topic_id`,
                        `qt`.`title` AS `topic_title`,
                        `qt`.`set_final` AS `set_final`,
                        `qt`.`status` AS `topic_status`,                
                        (
                            SELECT
                                ifnull(count(0), 0)
                            FROM
                                (
                                    `question_answers`
                                    LEFT JOIN `question_titles` ON (
                                        (
                                            `question_answers`.`questionaire_id` = `question_titles`.`id`
                                        )
                                    )
                                )
                            WHERE
                                (
                                    (
                                        `question_titles`.`topic_id` = `qt`.`id`
                                    )
                                    AND (
                                        `question_answers`.`user_id` = `users`.`id`
                                    )
                                )
                        ) AS `n_answer`,
                        `qt`.`random` AS `n_question`
                    FROM
                        (
                            `users`
                            JOIN `question_topics` `qt`
                        )
                                WHERE set_final = 1
        )a 
        where 
        n_answer > 0
    ";
    
    $sql = "SELECT
    COUNT(*)nresult
FROM
    v_users as users
    INNER JOIN  (SELECT user_question_result.* FROM user_question_result LEFT JOIN question_topics ut ON user_question_result.topic_id = ut.id WHERE set_final = 1)as uqr
    ON users.id = uqr.user_id
WHERE
    1=1 ".$condition;
    
    $result = $CI -> db -> query($sql)->result();
    return @$result[0]->nresult;  
} 

function get_elearning_pass_count($condition=FALSE){
  $CI = &get_instance();

     $sql = "SELECT
    count(*)nresult
FROM
    (
        SELECT
            users.*, `qt`.`id` AS `topic_id`,
            `qt`.`title` AS `topic_title`,
            `qt`.`set_final` AS `set_final`,
            `qt`.`status` AS `topic_status`,
            `qt`.`pass` AS `pass`,
            (
                SELECT
                    ifnull(count(0), 0)
                FROM
                    (
                        `question_answers`
                        LEFT JOIN `question_titles` ON (
                            (
                                `question_answers`.`questionaire_id` = `question_titles`.`id`
                            )
                        )
                    )
                WHERE
                    (
                        (
                            `question_titles`.`topic_id` = `qt`.`id`
                        )
                        AND (
                            `question_answers`.`user_id` = `users`.`id`
                        )
                    )
            ) AS `n_answer`,
            (
                SELECT
                    sum(`question_choices`.`score`)
                FROM
                    (
                        (
                            `question_choices`
                            JOIN `question_answers` ON (
                                (
                                    `question_choices`.`id` = `question_answers`.`choice_id`
                                )
                            )
                        )
                        LEFT JOIN `question_titles` ON (
                            (
                                `question_answers`.`questionaire_id` = `question_titles`.`id`
                            )
                        )
                    )
                WHERE
                    (
                        (
                            `question_answers`.`user_id` = `users`.`id`
                        )
                        AND (
                            `question_titles`.`topic_id` = `qt`.`id`
                        )
                    )
            ) AS `score`,
            `qt`.`random` AS `n_question`
        FROM
            (
                `v_users` as users
                JOIN `question_topics` `qt`
            )
        WHERE
            set_final = 1
    ) a LEFT JOIN user_question_result uqr ON a.id = uqr.user_id and a.topic_id = uqr.topic_id
WHERE
    n_answer > 0
AND score >= pass".$condition;
$sql = "SELECT
	count(*) nresult
FROM
	(
		SELECT
			users.*, `qt`.`id` AS `topic_id`,
			`qt`.`title` AS `topic_title`,
			`qt`.`set_final` AS `set_final`,
			`qt`.`status` AS `topic_status`,
			`qt`.`pass` AS `pass`,					
			`qt`.`random` AS `n_question`
		FROM
			(
				`v_users` AS users
				JOIN `question_topics` `qt`
			)
		WHERE
			set_final = 1
	) a
LEFT JOIN user_question_result uqr ON a.id = uqr.user_id
AND a.topic_id = uqr.topic_id
WHERE
	n_user_answer > 0
AND n_user_score >= pass".$condition;
    $result = $CI -> db -> query($sql)->result();
    return @$result[0]->nresult;  
}   

function report_desease_watch_report_column($value,$mode='all',$add_class){
    //$child_style = 'style="border-left:2px dotted #CCCCCC;"';
    $child_style = '';
    $data ='';
    if($mode=='all'){
        $data.= create_desease_watch_report_column(@$value[0]->n_event,'',$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->total_amount,'',$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->boy_amount,'',$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->girl_amount,'',$add_class);
    }else if($mode='school'){
        $data.= create_desease_watch_report_column(@$value[0]->n_event_school,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->total_amount_school,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->boy_amount_school,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->girl_amount_school,$child_style,$add_class);
    }else if($mode=='community'){
        $data.= create_desease_watch_report_column(@$value[0]->n_event_community,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->total_amount_community,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->boy_amount_community,$child_style,$add_class);
        $data.= create_desease_watch_report_column(@$value[0]->girl_amount_community,$child_style,$add_class);
    }
    echo $data;        
}

function create_desease_watch_report_column($dvalue,$style='',$add_class){
    $str_column ='<td class="'.$add_class.'" '.$style.'>';    
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

function report_desease_watch_symptom_report_column($sql,$mode='all',$col_class_name=''){    
        $CI = &get_instance();
        if($mode=='all'){
            $all = $CI->db->query($sql)->result();
            echo $column =$all[0]->n_symptom > 0 ?'<td style="width:250px;" class="'.$col_class_name.'">'.$all[0]->n_symptom.'</td>' : '<td style="width:250px;" class="'.$col_class_name.'">&nbsp;</td>';
        }else if($mode=='school'){
            $school = $CI->db->query($sql.' and place_type = 1 ')->result();
            echo $column =$school[0]->n_symptom > 0 ?'<td style="width:100px;" class="'.$col_class_name.'">'.$school[0]->n_symptom.'</td>' : '<td style="width:100px;" class="'.$col_class_name.'">&nbsp;</td>';
        }else if($mode=='community'){
            $community = $CI->db->query($sql.' and place_type = 2 ')->result();
            echo $column =$community[0]->n_symptom > 0 ?'<td style="width:100px;" class="'.$col_class_name.'">'.$community[0]->n_symptom.'</td>' : '<td style="width:100px;" class="'.$col_class_name.'">&nbsp;</td>';
        }
}

function count_desease_watch_event($condition){
    $n_event = 0;
    $sql = " SELECT COUNT(*)n_event FROM v_disease_watch WHERE 1=1 ".$condition;
    $CI = &get_instance();
    $result = $CI->db->query($sql)->result();
    $n_event = $result[0]->n_event;
    return $n_event;
}
?>