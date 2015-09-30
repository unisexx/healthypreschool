<?php 
	function get_pass_all_status($user_id = false)
	{
		$status = 1;
		$CI=& get_instance();
		$sql = "SELECT
					ifnull(count(*),0)n_nopass
				FROM
					v_user_question_result
				WHERE
					user_id = ".$user_id."
				and set_final = 0
				and topic_status = 'approve'
				and score < pass";
		$result = $CI->db->query($sql)->result();
		$status = $result[0]->n_nopass > 0 ? FALSE : TRUE;
		return $status;
	}
?>