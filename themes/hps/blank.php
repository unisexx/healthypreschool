<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $template['title'] ?></title>
	<?php echo $template['metadata'] ?>
	<? include "_css.php";?>
    <? include "_script.php";?>
</head>
<body>
	<div class="main">
		<div class="header">
	    	<? include "_header.php";?>
	        <div class="content">
				<div class="content_resize">
				<div class="col2" style="width:100%">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_top_left.png" width="9" height="9" /></td>
				        <td height="9" background="themes/hps/images/table_content_top.png"> </td>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_top_right.png" width="9" height="9" /></td>
				      </tr>
				      <tr>
				        <td background="themes/hps/images/table_content_left.png">&nbsp;</td>
				        <td bgcolor="#FFFFFF" class="main_content_blk">
				        	<style type="text/css">
				        		#memberstatus{border: 2px dashed #FFC540; padding: 5px; margin-bottom: 5px;}
				        		.tabspace{margin-left:20px;}
				        		.minispace{margin-left:10px;}
				        	</style>
				        	<div id="memberstatus">
				        		<b>สวัสดี</b> : <?php echo user_login()->email ?> 
				        		<b class="tabspace">ประเภท</b> : <?=user_login()->user_type->name?> <?php 
				                    if(user_login()->user_type_id == 6){
				                        echo user_login()->area->area_name;
				                    }elseif(user_login()->user_type_id == 7){
				                        echo user_login()->province->name;
				                    }elseif(user_login()->user_type_id == 8){
				                        echo user_login()->amphur->amphur_name;
				                    }elseif(user_login()->user_type_id == 9 or user_login()->user_type_id == 10){
										
				                    	echo '('.user_login()->nursery->nursery_category->title.user_login()->nursery->name.')';
										echo '<br><b>สถานะศูนย์เด็กเล็ก : </b>';
										
										if(user_login()->nursery->status == 0){
							        		if(user_login()->nursery->assessment->total != 0){
							        			echo '<span style="color:#D14">ไม่ผ่านเกณฑ์ ('.user_login()->nursery->assessment->total.' คะแนน)</span>';
							        		}else{
							        			echo 'รอการประเมิน';
							        		}
								       }else{
							        		echo '<span style="color:teal">ผ่านเกณฑ์';
							        		if(user_login()->nursery->approve_year != 0){
							        			echo ' (พ.ศ. '.user_login()->nursery->approve_year.')';
							        		}else{
							        			echo ' ('.user_login()->nursery->assessment->total.' คะแนน)';
							        		}
							        		echo '</span>';
								        }
									   
				                    }
				                ?>
				                
				            <?php if(user_login()->m_status == 'active'):?>
		                		<b class="tabspace"><a href="home/menu">เมนูหลัก</a></b>
			                <?php else:?>
			                	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
			                <?php endif;?>
		                
				                <div style="float: right;">
				                <a href="users/edit_profile">แก้ไขข้อมูล</a> | 
								<a href="users/logout">ล็อกเอ้า</a>
								</div>
				        	</div>
				        	
				        	<?php echo $template['body'] ?>
				        </td>
				        <td background="themes/hps/images/table_content_right.png">&nbsp;</td>
				      </tr>
				      <tr>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_bottom_left.png" width="9" height="9" /></td>
				        <td height="9" background="themes/hps/images/table_content_bottom.png"> </td>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_bottom_right.png" width="9" height="9" /></td>
				      </tr>
				    </table>
				</div>
	       	 	<div class="clr"></div>
			</div>
		</div>
	    <? include "_footer.php";?>
		</div>
	</div>
</body>
</html>