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
				        	
				        	<?php if(is_login()):?>
				        	<?php $current_user = user_login();?>
				        	<style type="text/css">
				        		#memberstatus{border: 2px dashed #FFC540; padding: 5px; margin-bottom: 5px;}
				        		.tabspace{margin-left:20px;}
				        		.minispace{margin-left:10px;}
				        	</style>
				        	<div id="memberstatus">
				        		<b>สวัสดี</b> : <?php echo $current_user->name ?> 
				        		<b class="tabspace">ประเภท</b> : <?php echo $current_user->user_type->name?> 
				        		<?php 
				                    if($current_user->user_type_id == 6){ // เจ้าหน้าที่ประจำเขต
				                        echo $current_user->area->area_name;
										echo ' (';
										$province = get_area_province($current_user->area_id);
										//var_dump($province);
										foreach($province as $row){
											echo $row->name.' ';
										}
										echo ')';
				                    }elseif($current_user->user_type_id == 7){
				                        echo $current_user->province->name;
				                    }elseif($current_user->user_type_id == 8){
				                        echo $current_user->amphur->amphur_name;
				                    }elseif($current_user->user_type_id == 9 or $current_user->user_type_id == 10){
										
				                    	echo '('.$current_user->nursery->name.')';
										echo '<br><b>สถานะศูนย์เด็กเล็ก : </b>';
										
										echo '<a href="assessments/preview/'.$current_user->nursery_id.'">';
										if($current_user->nursery->status == 0){
							        		if($current_user->nursery->assessment->total != 0){
							        			echo '<span style="color:#D14">ไม่ผ่านเกณฑ์ ('.$current_user->nursery->assessment->total.' คะแนน)</span>';
							        		}else{
							        			echo 'รอการประเมิน';
							        		}
								       }else{
							        		echo '<span style="color:teal">ผ่านเกณฑ์';
							        		if($current_user->nursery->approve_year != 0){
							        			echo ' (พ.ศ. '.$current_user->nursery->approve_year.')';
							        		}else{
							        			echo ' ('.$current_user->nursery->assessment->total.' คะแนน)';
							        		}
							        		echo '</span>';
								        }
										echo '</a>';
									   
				                    }
				                ?>
				                
				            <?php if($current_user->m_status == 'active'):?>
		                		<?php if($current_user->user_type_id == 1 || $current_user->user_type_id == 6 || $current_user->user_type_id == 7 || $current_user->user_type_id == 8):?>
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
				        	
				        	<?if($current_user->user_type_id == 1 or $current_user->user_type_id == 6 or $current_user->user_type_id == 7): //เจ้าหน้าที่ประจำเขต?>
				        	<ul id="nav">
				        		<li><a href="nurseries/register"><img src="themes/hps/images/banner_menu_1.png" alt="ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/register_form"><img src="themes/hps/images/banner_menu_2.png" alt="สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/estimate?status=0"><img src="themes/hps/images/banner_menu_3.png" alt="ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="officers"><img src="themes/hps/images/banner_menu_4.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่สาธารณะสุข"></a></li>
				        		<li><a href="staffs"><img src="themes/hps/images/banner_menu_5.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<?php if($current_user->user_type_id == 1): //ถ้าเป็นผู้ดูแลระบบ ?>
						        	<li><a href="nurseries/reports/index/basic_column"><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?elseif($current_user->user_type_id == 6): //ถ้าเป็นเจ้าหน้าที่เขต ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=1&area_id=<?=$current_user->area_id?>"><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?elseif($current_user->user_type_id == 7): //ถ้าเป็นเจ้าหน้าที่ประจำจังหวัด ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=2&area_id=&province_id=<?=$current_user->province_id?>&amphur_id=&district_id="><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
					        	<?endif;?>
					        	
					        	<li><a href="diseases/report_staff"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
					        	<li><a href="surveillances/index"><img src="themes/hps/images/report_banner.png" alt="รายงานติดตามการเฝ้าระวังโรค"></a></li>
					        	<li>
					        		<a href="pages/view/1">					        			
					        			<div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
					        			<img src="themes/hps/images/elearning.jpg" border="0" style="height:52px;border:0px;"><br>
						        			<div style="margin-top:-7px;">
						        			E-Learning
						        			</div>
					        			</div>
					        		</a>
					        	</li>
					        	<li>
                                    <a href="desease_watch/index">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease.jpg" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                              ข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="reports/desease_watch_number">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease_event_report.png" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                                รายงานข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
				        	</ul>
				        	<?elseif($current_user->user_type_id == 8): //เจ้าหน้าที่ประจำอำเภอ?>
				        	<ul id="nav">
				        		<li><a href="nurseries/register"><img src="themes/hps/images/banner_menu_1.png" alt="ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/register_form"><img src="themes/hps/images/banner_menu_2.png" alt="สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/estimate?status=0"><img src="themes/hps/images/banner_menu_3.png" alt="ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="staffs"><img src="themes/hps/images/banner_menu_5.png" alt="ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="nurseries/reports/index/basic_column?year=&type=3&area_id=&province_id=&amphur_id=<?=$current_user->amphur_id?>&district_id="><img src="themes/hps/images/banner_menu_6.png" alt="รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค"></a></li>
				        		<li><a href="surveillances/index"><img src="themes/hps/images/report_banner.png" alt="รายงานติดตามการเฝ้าระวังโรค"></a></li>
				        		<li>
					        		<a href="pages/view/1">					        			
					        			<div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
					        			<img src="themes/hps/images/elearning.jpg" border="0" style="height:52px;border:0px;"><br>
						        			<div style="margin-top:-7px;">
						        			E-Learning
						        			</div>
					        			</div>
					        		</a>
					        	</li>
					        	<li>
                                    <a href="desease_watch/index">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease.jpg" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                             ข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="reports/desease_watch_number">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease_event_report.png" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                                รายงานข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
				        	</ul>
				        	<?elseif($current_user->user_type_id == 9): //เจ้าหน้าที่ศูนย์?>
				        	<ul id="nav">
				        		<li><a href="teachers?nursery_id=<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_9.png" alt="ตรวจสอบรายชื่อครู / เจ้าหน้าที่"></a></li>
				        		<li><a href="classrooms?nursery_id=<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_8.png" alt="ตรวจสอบรายชื่อห้องเรียน"></a></li>
				        		<li><a href="childrens?nursery_id=<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_7.png" alt="ตรวจสอบรายชื่อเด็กนักเรียน"></a></li>
				        		<li><a href="diseases"><img src="themes/hps/images/banner_menu_10.png" alt="บันทึกแบบคัดกรองโรค"></a></li>
				        		<li><a href="diseases/report"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
				        		<li><a href="assessments/preview/<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_12.png" alt="รายงานแบบประเมินเข้าร่วมโครงการ"></a></li>
				        		<li><a href="surveillances/index"><img src="themes/hps/images/report_banner.png" alt="รายงานติดตามการเฝ้าระวังโรค"></a></li>
				        		<li>
					        		<a href="pages/view/1">					        			
					        			<div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
					        			<img src="themes/hps/images/elearning.jpg" border="0" style="height:52px;border:0px;"><br>
						        			<div style="margin-top:-7px;">
						        			E-Learning
						        			</div>
					        			</div>
					        		</a>
					        	</li>
					        	<li>
                                    <a href="desease_watch/index">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease.jpg" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                             ข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="reports/desease_watch_number">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease_event_report.png" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                                รายงานข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
				        	</ul>
				        	<?elseif($current_user->user_type_id == 10): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก?>
				        	<ul id="nav">
				        		<li><a href="classrooms?nursery_id=<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_8.png" alt="ตรวจสอบรายชื่อห้องเรียน"></a></li>
				        		<li><a href="childrens?nursery_id=<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_7.png" alt="ตรวจสอบรายชื่อเด็กนักเรียน"></a></li>
				        		<li><a href="diseases"><img src="themes/hps/images/banner_menu_10.png" alt="บันทึกแบบคัดกรองโรค"></a></li>
				        		<li><a href="diseases/report"><img src="themes/hps/images/banner_menu_11.png" alt="รายงานแบบคัดกรองโรค"></a></li>
				        		<li><a href="assessments/preview/<?=$current_user->nursery_id?>"><img src="themes/hps/images/banner_menu_12.png" alt="รายงานแบบประเมินเข้าร่วมโครงการ"></a></li>
				        		<li><a href="surveillances/index"><img src="themes/hps/images/report_banner.png" alt="รายงานติดตามการเฝ้าระวังโรค"></a></li>
				        		<li>
					        		<a href="pages/view/1">					        			
					        			<div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
					        			<img src="themes/hps/images/elearning.jpg" border="0" style="height:52px;border:0px;"><br>
						        			<div style="margin-top:-7px;">
						        			E-Learning
						        			</div>
					        			</div>
					        		</a>
					        	</li>
					        	<li>
					        		<a href="desease_watch/index">					        			
					        			<div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
					        			<img src="themes/hps/images/desease.jpg" border="0" style="height:52px;border:0px;"><br>
						        			<div style="margin-top:-7px;">
						        			ข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
						        			</div>
					        			</div>
					        		</a>
					        	</li>
					        	<li>
                                    <a href="reports/desease_watch_number">                                      
                                        <div style="font-size: 15px;font-weight: bold;margin:0 auto;margin-left:30px;text-align:center;">
                                        <img src="themes/hps/images/desease_event_report.png" border="0" style="height:52px;border:0px;"><br>
                                            <div style="margin-top:-7px;">
                                                                                                                                                รายงานข้อมูลเหตุการณ์<br>การเฝ้าระวังโรคติดต่อ
                                            </div>
                                        </div>
                                    </a>
                                </li>
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