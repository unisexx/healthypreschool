<?php
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
?>