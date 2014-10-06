<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $template['title'] ?></title>
	<? include "_css.php";?>
    <? include "_script.php";?>
    <?php echo $template['metadata'] ?>
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
				        	
				        	<?if(is_login()):?>
				        	<style type="text/css">
				        		#memberstatus{border: 2px dashed #FFC540; padding: 5px; margin-bottom: 5px;}
				        		.tabspace{margin-left:20px;}
				        		.minispace{margin-left:10px;}
				        	</style>
				        	<div id="memberstatus">
				        		<b>สวัสดี</b> : <?php echo user_login()->name ?> 
				        		<b class="tabspace">ประเภท</b> : <?=user_login()->user_type->name?> 
				        		<?php 
				                    if(user_login()->user_type_id == 6){ // เจ้าหน้าที่ประจำเขต
				                        echo user_login()->area->area_name;
										echo ' (';
										foreach(user_login()->area->province->get() as $row){
											echo $row->name.' ';
										}
										echo ')';
				                    }elseif(user_login()->user_type_id == 7){
				                        echo user_login()->province->name;
				                    }elseif(user_login()->user_type_id == 8){
				                        echo user_login()->amphur->amphur_name;
				                    }elseif(user_login()->user_type_id == 9 or user_login()->user_type_id == 10){
										
				                    	echo '('.user_login()->nursery->nursery_category->title.user_login()->nursery->name.')';
										echo '<br><b>สถานะศูนย์เด็กเล็ก : </b>';
										
										echo '<a href="assessments/preview/'.user_login()->nursery_id.'">';
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
										echo '</a>';
									   
				                    }
				                ?>
				                
				            <?php if(user_login()->m_status == 'active'):?>
		                		<?php if(user_login()->user_type_id == 1 || user_login()->user_type_id == 6 || user_login()->user_type_id == 7 || user_login()->user_type_id == 8):?>
		                			<b class="tabspace"><a href="nurseries/register">เมนูหลัก</a></b>
		                		<?php else:?>
		                			<b class="tabspace"><a href="home/menu">เมนูหลัก</a></b>
		                		<?php endif;?>
			                <?php else:?>
			                	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
			                <?php endif;?>
		                
				                <div style="float: right;">
				                <a href="users/edit_profile">แก้ไขข้อมูล</a> | 
								<a href="users/logout">logout</a>
								</div>
				        	</div>
				        	
				        	<!------- เมนู ------->
				        	<style type="text/css">
				        	#nav
							{
							    list-style: none;
							    margin-bottom: 10px;
							    position: relative;
							    z-index: 9;
							    height: 26px;
							    padding: 4px 4px 4px 4px;
							    margin-left:0px;
							}
							
							#nav li
							{
							    float: left;
							    margin:0 5px 10px 5px;
							}
							#nav img
							{
								margin:10px 0 10px 5px;
							    border-bottom: #fff 2px solid;
							}
							#nav img:hover
							{
							    color: #fff;
							    border-bottom: #0079C2 2px solid;
							}
				        	</style>
				        	
				        	<?if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7): //เจ้าหน้าที่ประจำเขต?>
				        	<ul id="nav">
				        		<li><a href="nurseries/register"><img src="themes/hps/images/banner_menu_1.png" alt="ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/register_form"><img src="themes/hps/images/banner_menu_2.png" alt="สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/estimate?status=1"><img src="themes/hps/images/banner_menu_3.png" alt="ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="officers"><img src="themes/hps/images/banner_menu_4.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่สาธารณะสุข"></a></li>
				        		<li><a href="staffs"><img src="themes/hps/images/banner_menu_5.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<?php if(user_login()->user_type_id == 1): //ถ้าเป็นผู้ดูแลระบบ ?>
						        	<li><a href="nurseries/reports/index/basic_column"><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?elseif(user_login()->user_type_id == 6): //ถ้าเป็นเจ้าหน้าที่เขต ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=1&area_id=<?=user_login()->area_id?>"><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?elseif(user_login()->user_type_id == 7): //ถ้าเป็นเจ้าหน้าที่ประจำจังหวัด ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=2&area_id=&province_id=<?=user_login()->province_id?>&amphur_id=&district_id="><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?endif;?>
					        	
					        	<li><a href="diseases/report_staff"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่ประจำอำเภอ?>
				        	<ul id="nav">
				        		<li><a href="nurseries/register"><img src="themes/hps/images/banner_menu_1.png" alt="ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/register_form"><img src="themes/hps/images/banner_menu_2.png" alt="สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/estimate?status=1"><img src="themes/hps/images/banner_menu_3.png" alt="ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="staffs"><img src="themes/hps/images/banner_menu_5.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/reports/index/basic_column?year=&type=3&area_id=&province_id=&amphur_id=<?=user_login()->amphur_id?>&district_id="><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 9): //เจ้าหน้าที่ศูนย์?>
				        	<ul id="nav">
				        		<li><a href="childrens"><img src="themes/hps/images/banner_menu_7.png" alt="ตรวจสอบรายชื่อเด็กนักเรียน"></a></li>
				        		<li><a href="classrooms"><img src="themes/hps/images/banner_menu_8.png" alt="ตรวจสอบรายชื่อห้องเรียน"></a></li>
				        		<li><a href="teachers"><img src="themes/hps/images/banner_menu_9.png" alt="ตรวจสอบรายชื่อครู / เจ้าหน้าที่"></a></li>
				        		<li><a href="diseases"><img src="themes/hps/images/banner_menu_10.png" alt="บันทึกแบบคัดกรองโรค"></a></li>
				        		<li><a href="diseases/report"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
				        		<li><a href="assessments/preview/<?=user_login()->nursery_id?>"><img src="themes/hps/images/banner_menu_12.png" alt="รายงานแบบประเมินเข้าร่วมโครงการ"></a></li>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 10): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก?>
				        	<ul id="nav">
				        		<li><a href="childrens"><img src="themes/hps/images/banner_menu_7.png" alt="ตรวจสอบรายชื่อเด็กนักเรียน"></a></li>
				        		<li><a href="classrooms"><img src="themes/hps/images/banner_menu_8.png" alt="ตรวจสอบรายชื่อห้องเรียน"></a></li>
				        		<li><a href="diseases"><img src="themes/hps/images/banner_menu_10.png" alt="บันทึกแบบคัดกรองโรค"></a></li>
				        		<li><a href="diseases/report"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
				        		<li><a href="assessments/preview/<?=user_login()->nursery_id?>"><img src="themes/hps/images/banner_menu_12.png" alt="รายงานแบบประเมินเข้าร่วมโครงการ"></a></li>
				        	</ul>
				        	<?endif;?>
				        	<!------- จบเมนู ------->
				        	
				        	<?endif; //is_login()?>
				        	<br clear="all">
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