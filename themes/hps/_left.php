<div class="col1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <!-- <td width="250" height="250" class="bg_login2"> -->
        <td background="themes/hps/images/bg_col1.png">
        <!-- <div id="login"> -->
        <div>
			<?php if(is_login()):?>
				<div style="padding:10px 0 0 15px;">
	                <div>สวัสดี : <?php echo user_login()->email ?></div>
	                <div>ประเภท : <?=user_login() -> user_type -> name ?> <?php
					if (user_login() -> user_type_id == 6) {
						echo user_login() -> area -> area_name;
					} elseif (user_login() -> user_type_id == 7) {
						echo user_login() -> province -> name;
					} elseif (user_login() -> user_type_id == 8) {
						echo user_login() -> amphur -> amphur_name;
					}
	                ?></div>
	                <div class="login-menu">
	                	<?php if(user_login()->m_status == 'active'):?>
	                		<?php if(user_login()->user_type_id == 1 || user_login()->user_type_id == 6 || user_login()->user_type_id == 7 || user_login()->user_type_id == 8):?>
	                			<b class="tabspace"><a href="nurseries/register">เมนูหลัก</a></b>
	                		<?php else: ?>
	                			<b class="tabspace"><a href="home/menu">เมนูหลัก</a></b>
	                		<?php endif; ?>
		                <?php else: ?>
		                	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
		                <?php endif; ?>
	                </div>
					<!-- <div class="Chick" style="padding-left:45px;"> -->
					<label style="padding-left:45px;">
						<a href="users/edit_profile"><div class="btn btn-mini">แก้ไขข้อมูล</div></a>
						<a href="users/logout"><div class="btn btn-mini btn-info">ล็อกเอ้า</div></a>
					</div>
				</div>
            <?php else: ?>
            	<style type="text/css">
					#loginfrm .controls {
						margin-left: 65px;
					}
					#loginfrm .control-label {
						width: 73px;
					}
					#loginfrm .control-group {
						margin-bottom: 0px;
					}
            	</style>
            	<h5 style="margin-left: 10px;"><u>เข้าสู่ระบบ</u></h5>
                <form id="loginfrm" action="users/login" method="post"  class="form-horizontal">
                	<div class="control-group">
					    <label class="control-label" for="inputEmail">อีเมล์:</label>
					    <div class="controls">
					      <input type="text" id="inputEmail" class="input_boxLogin input-medium" name="email">
					    </div>
					</div>
					<div class="control-group">
					    <label class="control-label" for="inputPassword">รหัสผ่าน:</label>
					    <div class="controls">
					      <input type="password" id="inputPassword" class="input_boxLogin input-medium" name="password">
					    </div>
					</div>
					<!-- <div class="control-group">
					    <label class="control-label" for="inputType">ประเภท:</label>
					    <div style="float:left; margin-left: 15px;">
					      <select class="span2" style="height:25px;" name="user_type_id">
					      	<option value="1">ผู้ดูแลระบบ</option>
					      	<option value="6">เจ้าหน้าที่ประจำเขต</option>
					      	<option value="7">เจ้าหน้าที่ประจำจังหวัด</option>
					      	<option value="8">เจ้าหน้าที่ประจำอำเภอ</option>
					      	<option value="9">เจ้าหน้าที่ศูนย์</option>
					      	<option value="10">ครู / ผู้ดูแลเด็ก</option>
					      </select>
					    </div>
					</div> -->
					<!-- <div>
						<input type="text" name="email" value="" class="input_boxLogin input-small" placeholder="E-mail">
					</div><br clear="all">
					<div>
						<input type="password" name="password" value=""  class="input_boxLogin input-small" placeholder="Password">
					</div> -->
		            <!-- <input type="submit" value="" class="btn_login" ><div class="clr"></div> -->
		            <input type="submit" class="btn btn-info btn-mini" value="ล็อกอิน" style="margin-left:88px;"> <a href="users/forget_pass"><div class="btn btn-mini">ลืมรหัสผ่าน</div></a>
					<!-- <label class="Chick" style="padding-left:35px;"> -->
					<!-- <label style="padding-left:60px;">
						<a href="users/register"><div class="btn btn-mini">ลงทะเบียน</div></a>
						<a href="users/forget_pass"><div class="btn btn-mini">ลืมรหัสผ่าน</div></a>
					</label> -->
				</form>
            <?php endif; ?>
            <hr>
		</div>
        
        </td>
      </tr>
       <tr>
        <td background="themes/hps/images/bg_col1.png">
        	<h5 style="margin:0 0 0 10px;" ><u>ลงทะเบียน</u></h5>
        	<div class="menuleft">
	         <ul>
	             <li><a href="users/register_person">บุคคลทั่วไป</a></li>
	            <li><a href="users/register">เจ้าหน้าที่สาธารณะสุข</a></li>
	            <li><a href="users/register_center">เจ้าหน้าที่ศูนย์เด็กเล็ก</a></li>	            
	            <li><a href="users/register_center_school">เจ้าหน้าที่ครูโรงเรียนอนุบาล</a></li>
	         </ul>
	         </div>
	         <hr>
        </td>
      </tr>
      </tr>
       <tr>
        <td background="themes/hps/images/bg_col1.png">
        	<h5 style="margin:0 0 0 10px;" ><u>E-Learning สำหรับผู้ดูแลเด็ก</u></h5>
        	<div class="menuleft">
	         <ul>
	            <li><a href="pages/view/1">คำแนะนำ</a></li>
	            <li><a href="elearnings/learns">บทเรียน</a></li>
	            <li><a href="elearnings/testing_index">แบบทดสอบ</a></li>
	         </ul>
	         </div>
	         <div style="width:230px!important;margin:0 auto!important;">
	             <a href="elearnings/cert" target="_blank">
	               <img src="media/images/btn_cert_menu.png" border="0" width="230">
	             </a>
	         </div>
	         <div style="width:230px!important;margin:0 auto!important;padding-top:8px;">
                 <a href="#" onclick="return false;" target="_blank">
                   <img src="media/images/btn_school_cert_menu.png" border="0" width="230">
                 </a>
             </div>
	         <div class="elearning menuleft" style="background: #fff2bf;width: 89%;margin: 0 auto;margin-top: 10px;border: 2px dashed #000000;">
	             <ul>
	                 <li><b>ข้อมูลสถิติ E-Learning</b></li>
	                 <li>จำนวนผู้ทำแบบทดสอบ : <?php echo number_format(get_elearning_count(),0);?> คน</li>
	                 <li>จำนวนผู้ผ่านแบบทดสอบ : <?php echo number_format(get_elearning_pass_count(),0);?> คน</li>
	             </ul>
	         </div>
	         <hr style="margin-bottom:-1px;">	        
        </td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png" >
        <div class="menuleft">
         <ul>
            <li><a href="contents/view/histories/25">ความเป็นมาศูนย์เด็กเล็กปลอดโรค</a></li>
            <!--<li><a href="nurseries/searchs">สมัครเข้าร่วมโครงการ</a></li>-->
            <!--<li><a href="elearnings/index">e-Learning สำหรับผู้ดูแลเด็ก</a></li>-->
            <li><a href="contents/more/newsletters">จดหมายข่าว</a></li>
            <li><a href="contents/more/articles">บทความที่น่าสนใจ</a></li>
            <li><a href="contents/more/downloads">เอกสารดาวน์โหลด</a></li>
            <li><a href="#">ผลการประเมินศูนย์เด็กเล็ก</a></li>
            <li><a href="nurseries/reports/index/basic_column">ผลการดำเนินงาน</a></li>
         </ul>
         </div>
        </td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png">&nbsp;</td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png">&nbsp;&nbsp;<img src="themes/hps/images/title_calendar.png" width="176" height="29" /><br>
			<?php echo modules::run('calendars/inc_home'); ?>
        </td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png">
        <div id="banner">
          <ul>
          	  <!-- <li><a href="nurseries/reports/index/basic_column"><img src="themes/hps/images/banner_Overall_result.jpg" width="226" height="118" /></a></li>
              <li><a href="http://thaigcd.ddc.moph.go.th/e-learning/wp-login.php?action=register" target="_blank"><img src="themes/hps/images/banner_e-learning.jpg" width="226" height="118" /></a></li>
              <li><img src="themes/hps/images/banner_evaluation.jpg" width="226" height="118" /></li> -->
              <!-- <li><a href="http://demo.favouritedesign.com/healthypreschool/nurseries/reports/index/basic_column" target="_blank"><?php echo thumb("uploads/hilight/54b5d9550d496.jpg",226,false,1)?></a></li> -->
              <!-- <li><a href="http://demo.favouritedesign.com/healthypreschool/reports/nursery_register" target="_blank"><?php echo thumb("uploads/hilight/54b5d9550d496.jpg",226,false,1)?></a></li> -->
              
              <!-- <li><a href="nurseries/reports/index/basic_column" target="_blank"><?php echo thumb("uploads/hilight/54b5d9550d496.jpg",226,false,1)?></a></li>
              <li><a href="diseases/newreport" target="_blank"><?php echo thumb("uploads/hilight/54b5d9ca1d50d.jpg",226,false,1)?></a></li> -->
              <!-- <li><a href="surveillances/index" target="_blank"><?php echo thumb("uploads/hilight/54fe9860bdc9e.jpg",226,false,1)?></a></li> -->
              <!-- <li><a href="reports/desease_watch_number" target="_blank"><img src="themes/hps/images/btn_report_event.png"></a></li> -->
          </ul>
         </div>
        </td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png">&nbsp;</td>
      </tr>
      <tr>
        <td><img src="themes/hps/images/bottom_col1.png" width="250" height="8" /></td>
      </tr>
    </table>
</div>