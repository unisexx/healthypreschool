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
										
										echo '<a href="assessments/preview">';
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
		                		<b class="tabspace"><a href="home/menu">เมนูหลัก</a></b>
			                <?php else:?>
			                	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
			                <?php endif;?>
		                
				                <div style="float: right;">
				                <a href="users/edit_profile">แก้ไขข้อมูล</a> | 
								<a href="users/logout">logout</a>
								</div>
				        	</div>
				        	
				        	<!-- เมนู -->
				        	<?if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7): //เจ้าหน้าที่ประจำเขต?>
				        	<ul>
				        		<li><a href="nurseries/register">ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="nurseries/register_form">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="nurseries/estimate/0">ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="officers">ตรวจสอบรายชื่อเจ้าหน้าที่สาธารณะสุข</a></li>
				        		<li><a href="staffs">ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<?php if(user_login()->user_type_id == 1): //ถ้าเป็นผู้ดูแลระบบ ?>
						        	<li><a href="nurseries/reports/index/basic_column">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
					        	<?elseif(user_login()->user_type_id == 6): //ถ้าเป็นเจ้าหน้าที่เขต ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=1&area_id=<?=user_login()->area_id?>">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
					        	<?elseif(user_login()->user_type_id == 7): //ถ้าเป็นเจ้าหน้าที่ประจำจังหวัด ?>
					        		<li><a href="nurseries/reports/index/basic_column?year=&type=2&area_id=&province_id=<?=user_login()->province_id?>&amphur_id=&district_id=">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
					        	<?endif;?>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่ประจำอำเภอ?>
				        	<ul>
				        		<li><a href="nurseries/register">ตรวจสอบรายชื่อศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="nurseries/register_form">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="nurseries/estimate/0">ประเมินผลโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="staffs">ตรวจสอบรายชื่อเจ้าหน้าที่ศูนย์เด็กเล็กปลอดโรค</a></li>
				        		<li><a href="nurseries/reports/index/basic_column?year=&type=3&area_id=&province_id=&amphur_id=<?=user_login()->amphur_id?>&district_id=">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 9): //เจ้าหน้าที่ศูนย์?>
				        	<ul>
				        		<li><a href="teachers">จัดการครู / ผู้ดูอลเด็ก</a></li>
				        	</ul>
				        	<?elseif(user_login()->user_type_id == 10): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก?>
				        	<ul>
				        		<li><a href="classrooms">ห้องเรียน ชั้นเรียน และเด็ก</a></li>
				        		<li><a href="diseases/form?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=date("m")?>&year=<?=date("Y")+543?>" target="_blank">บันทึกผลแบบคัดกรองโรค</a></li>
				        	</ul>
				        	<?endif;?>
				        	<!-- จบเมนู -->
				        	
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