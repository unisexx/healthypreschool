<?php
		if($_REQUEST["posttest_score"] >=24)
		{
			require_once( '../wp-load.php' );
			global $current_user;
			$current_user = wp_get_current_user();	
			
			$update_value = "ผ่านการทดสอบเมื่อวันที่  \"".date("d/m/Y")."\"" ;
			$result = set_cimyFieldValue($current_user->ID, 'CERT_DATE', $update_value);
			
		/*manual method (the right one is above by use set_cimyFieldValue();	
			$query_string = "
					UPDATE wp_cimy_uef_data 
					SET VALUE = \"ผ่านการทดสอบ เมื่อวันที่ \"".date("d/m/Y")."\"\"  
					WHERE USER_ID=".$current_user->ID." and FIELD_ID=3 ;
					";
			//echo "query = ".$query_string ;
			
			$wpdb->query($query_string);
		*/
		}
		
		echo "<SCRIPT LANGUAGE='javascript'>parent.change_parent_url('http://thaigcd.ddc.moph.go.th/e-learning/wp-admin/profile.php');</SCRIPT>";
		
?>