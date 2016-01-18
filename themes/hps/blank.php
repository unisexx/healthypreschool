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
				        	<!-- /*<style type="text/css">
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
				        	<?endif;?>*/ -->
				        	<!------- จบเมนู ------->


				        	<!-- new dropdown menu -->
				        	<style>
									#menubar{margin:15px 0;}
				        		#menubar nav {
									    display: block;
									    text-align: left;
									  }
									  #menubar nav ul {
									    margin: 0;
									    padding:0;
									    list-style: none;
									  }
									  #menubar .nav a {
									    display:block;
									    background: #007DCC;
									    color:#fff;
									    text-decoration: none;
									    padding: .8em 1.8em;
									    /*text-transform: uppercase;*/
									    /*font-size: 80%;*/
											/*letter-spacing: 2px;*/
									    /*text-shadow: 0 -1px 0 #000;*/
									    position: relative;
									  }
									  #menubar .nav{
									    vertical-align: top;
									    display: inline-block;
									    box-shadow: 1px -1px -1px 1px #000, -1px 1px -1px 1px #fff, 0 0 6px 3px #fff;
									    border-radius:6px;
									  }
									  #menubar .nav li{position: relative;}
									  #menubar .nav > li {
									    float:left;
									    border-bottom: 4px #aaa solid;
									    margin-right: 1px;
									  }
									  #menubar .nav > li > a {
									    /*margin-bottom:1px;*/
									    /*box-shadow:inset 0 2em .33em -.5em #555;*/
									  }
									  #menubar .nav > li:hover , #menubar.nav > li:hover >a{  border-bottom-color:orange; background-color: #004566!important;}
									  #menubar .nav li:hover > a {
											color:orange; background-color: #004566!important;
										}
										#menubar .nav > li.sub_menu:hover , #menubar.nav > li.sub_menu:hover >a.sub_menu{
											border-bottom-color:orange; background-color: #F4F4F4 !important;
										}
										#menubar .nav li.sub_menu:hover > a { color:orange; background-color: #F4F4F4 !important;}
									  #menubar .nav > li:first-child  { border-radius: 4px 0 0 4px;}
									  #menubar .nav > li:first-child>a{border-radius: 4px 0 0 0;}
									  #menubar .nav > li:last-child  {
									  	border-radius: 0 0 4px 0;
									  	margin-right: 0;
									  }
									  #menubar .nav > li:last-child >a{border-radius: 0 4px 0 0; }
									  /*#menubar .nav li li a { margin-top:1px}*/

									    #menubar .nav li a:first-child:nth-last-child(2):before {
									     content:"";
									     position: absolute;
									     height:0;
									     width: 0;
									     border: 5px solid transparent;
									     top: 50% ;
									     right:5px;

									   }

									   /* submenu positioning*/
									#menubar .nav ul {
									  position: absolute;
									  white-space: nowrap;
									  border-bottom: 5px solid  orange;
									  z-index: 1;
									  left: -99999em;
									}
									#menubar ul.nav li {padding:0 0 2px !important;}
									#menubar .nav > li:hover > ul {
									  left: auto;
									  padding-top: 5px  ;
									  min-width: 100%;
									}
									#menubar .nav > li li ul {  border-left:1px solid #fff;}


									#menubar .nav > li li:hover > ul {
									 /* margin-left: 1px */
									  left: 100%;
									  top: -1px;
									}
									/* arrow hover styling */
									#menubar .nav > li > a:first-child:nth-last-child(2):before {
									  border-top-color: #aaa;
									}
									#menubar .nav > li:hover > a:first-child:nth-last-child(2):before {
									  border: 5px solid transparent;
									  border-bottom-color: orange;
									  margin-top:-5px
									}
									#menubar .nav li li > a:first-child:nth-last-child(2):before {
									  border-left-color: #aaa;
									  margin-top: -5px
									}
									#menubar .nav li li:hover > a:first-child:nth-last-child(2):before {
									  border: 5px solid transparent;
									  border-right-color: orange;
									  right: 10px;
									}
									#menubar .nav>li>a:hover{background-color: #004566!important;}
								  a.sub_menu{
										background:#FFFFFF !important;
										color:#000000 !important;
										margin-left:15px;
										border-left:2px solid #CCCCCC !important;
										border-right:2px solid #CCCCCC !important;
									}
				        	</style>
									<!------------------------------------------------------
											$current_user->user_type_id == 1	ผู้ดูแลระบบ
											$current_user->user_type_id == 6	เจ้าหน้าที่ประจำเขต
											$current_user->user_type_id == 7	เจ้าหน้าที่ประจำจังหวัด
											$current_user->user_type_id == 8	เจ้าหน้าที่ประจำอำเภอ
											$current_user->user_type_id == 9	เจ้าหน้าที่ศูนย์
											$current_user->user_type_id == 10	เจ้าหน้าที่ครู/ผู้ดูแลเด็ก
									-------------------------------------------------------->
								<div id="menubar">
									<nav>
								  <ul class="nav">
										<?if (in_array($current_user->user_type_id, array(1,6,7,8,9,10))):?>
								    <li><a href="#">บริหารจัดการศูนย์เด็กเล็ก</a>
											<ul>
												<?if (in_array($current_user->user_type_id, array(1,6,7,8))):?>
												<li><a href="nurseries/register">ตรวจสอบรายชื่อศูนย์เด็กเล็ก</a></li>
												<li><a href="nurseries/register_form">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
												<li><a href="nurseries/estimate?status=0">ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
												<?endif;?>
												<?if (in_array($current_user->user_type_id, array(9))):?>
												<li><a href="teachers?nursery_id=<?=$current_user->nursery_id?>">ตรวจสอบรายชื่อครู / เจ้าหน้าที่</a></li>
												<?endif;?>
												<?if (in_array($current_user->user_type_id, array(9,10))):?>
												<li><a href="classrooms?nursery_id=<?=$current_user->nursery_id?>">ตรวจสอบรายชื่อห้องเรียยน</a></li>
												<li><a href="childrens?nursery_id=<?=$current_user->nursery_id?>">ตรวจสอบรายชื่อเด็ก / นักเรียน</a></li>
												<?endif;?>
											</ul>
										</li>
										<?endif;?>
										<?if (in_array($current_user->user_type_id, array(1,6,7,8))):?>
										<li><a href="#">เจ้าหน้าที่</a>
											<ul>
												<?if (in_array($current_user->user_type_id, array(1,6,7))):?>
												<li><a href="officers">ตรวจสอบรายชื่อเจ้าหน้าที่สาธารณสุข</a></li>
												<?endif;?>
												<?if (in_array($current_user->user_type_id, array(1,6,7,8))):?>
												<li><a href="staffs">ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค</a></li>
												<?endif;?>
											</ul>
										</li>
										<?endif;?>
										<?if (in_array($current_user->user_type_id, array(9,10))):?>
								    <li><a href="#">แบบคัดกรองโรค</a>
								      <ul>
								        <li><a href="diseases">ตรวจสอบรายการแบบคัดกรองโรค</a></li>
								      </ul>
								    </li>
										<?endif;?>
										<?if (in_array($current_user->user_type_id, array(1,6,7,8,9,10))):?>
								    <li><a href="#">E-learning</a>
								      <ul>
								        <li><a href="pages/view/1">คำแนะนำ</a></li>
								        <li><a href="elearnings/learns">บทเรียน</a></li>
								        <li><a href="elearnings/testing_index">แบบทดสอบ</a></li>
								      </ul>
								    </li>
										<?endif;?>
										<?if (in_array($current_user->user_type_id, array(1,6,7,8,9,10))):?>
								    <li><a href="#" onclick="return false;">เหตุการณ์การเฝ้าระวังโรคติดต่อ</a>
											<ul>
												<li><a href="desease_watch/index">ข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ</a></li>
											</ul>
										</li>
										<?endif;?>
										<?if (in_array($current_user->user_type_id, array(1,6,7,8,9,10))):?>
										<li><a href="#">รายงาน</a>
											<ul>
												<?if (in_array($current_user->user_type_id, array(1,6,7,8))):?>
												<li><a href="nurseries/reports/index/basic_column">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
												<?endif;?>
												<?if (in_array($current_user->user_type_id, array(1,6,7,8,9,10))):?>
												<li><a href="diseases/newreport">รายงานแบบคัดกรองโรค</a></li>
												<li><a href="surveillances/index">รายงานการเฝ้าระวังโรค</a></li>
												<li class="main_menu_nolink"><a href="#" onclick="return false;">รายงานข้อมูลเหตุการณ์การเฝ้าระวังโรค</a></li>
												<li class="sub_menu"><a class="sub_menu" href="reports/desease_watch_number">- รายงานจำนวนเหตุการณ์การเฝ้าระวังโรค</a></li>
												<li class="sub_menu"><a class="sub_menu" href="reports/desease_watch_symptom">- รายงานกลุ่มอาการป่วยจากข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ</a></li>
												<?endif;?>
												<?if (in_array($current_user->user_type_id, array(9,10))):?>
												<li><a href="assessments/preview/<?=$current_user->nursery_id?>">รายงานแบบประเมินเข้าร่วมโครงการ</a></li>
												<?endif;?>
											</ul>
										</li>
										<?endif;?>
								  </ul>
									</nav>
									<!-- test dropdown menu -->
								</div>
								<?endif; //is_login()?>


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
