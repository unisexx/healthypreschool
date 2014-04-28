<div class="col1">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="250" height="250" class="bg_login2">
        <div id="login">
			<?php if(is_login()):?>
                <div>สวัสดี : <?php echo user_login()->email ?></div>
                <div>ประเภท : <?=user_login()->user_type->name?> <?php 
                    if(user_login()->user_type_id == 6){
                        echo user_login()->area->area_name;
                    }elseif(user_login()->user_type_id == 7){
                        echo user_login()->province->name;
                    }elseif(user_login()->user_type_id == 8){
                        echo user_login()->amphur->amphur_name;
                    }
                ?></div>
                <div class="login-menu">
                	<?php if(user_login()->m_status == 'active'):?>
	                	<b> 
	                	<?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7 or user_login()->user_type_id == 8):?>
	                	<a href="nurseries">ศูนย์เด็กเล็ก</a>
	                	<?php endif;?>
	                	
	                    <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7):?>
	                        <span class="divider">/</span> <a href="officers">ตรวจสอบรายชื่อ</a>
	                    <?php endif;?>
	                    
	                    <?php if(user_login()->user_type_id == 9): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก ?>
	                    	<a href="teachers">จัดการครู / ผู้ดูแลเด็ก</a>
	                    <?php endif;?>
	                    
	                    <?php if(user_login()->user_type_id == 10): //เจ้าหน้าที่ครู / ผู้ดูแลเด็ก ?>
	                    	<a href="classrooms">ห้องเรียน ชั้นเรียน และเด็ก</a> <span class="divider">/</span> <a href="diseases/form?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=date("m")?>&year=<?=date("Y")+543?>" target="_blank">แบบคัดกรองโรค</a>
	                    <?php endif;?>
	                    </b>
	                <?php else:?>
	                	สถานะ : <span style="color:orangered;">รอการตรวจสอบ</span>
	                <?php endif;?>
                </div>
                <hr class="lineRegis" style="margin-top:5px;">
					<div class="Chick" style="padding-left:45px;">
						<a href="users/edit_profile"><div class="btn btn-mini">แก้ไขข้อมูล</div></a>
						<a href="users/logout"><div class="btn btn-mini btn-info">logout</div></a>
					</div>
            <?php else:?>
                <form action="users/login" method="post">
					<div>
						<input type="text" name="email" value="" class="input_boxLogin input-small" placeholder="E-mail">
					</div><br clear="all">
					<div>
						<input type="password" name="password" value=""  class="input_boxLogin input-small" placeholder="Password">
					</div>
		            <!-- <input type="submit" value="" class="btn_login" ><div class="clr"></div> -->
		            <input type="submit" class="btn btn-info btn_login" value="login">
		            <hr class="lineRegis" style="margin-top:5px;">
					<label class="Chick" style="padding-left:35px;">
						<a href="users/register"><div class="btn btn-mini">ลงทะเบียน</div></a>
						<a href="users/forget_pass"><div class="btn btn-mini">ลืมรหัสผ่าน</div></a>
					</label>
				</form>
            <?php endif;?>
		</div>
        
        </td>
      </tr>
      <tr>
        <td background="themes/hps/images/bg_col1.png">
        <div class="menuleft">
         <ul>
            <li><a href="contents/view/histories/25">ความเป็นมาศูนย์เด็กเล็กปลอดโรค</a></li>
            <li><a href="nurseries/searchs">สมัครเข้าร่วมโครงการ</a></li>
            <li><a href="http://thaigcd.ddc.moph.go.th/e-learning" target="_blank">e-Learning สำหรับผู้ดูแลเด็ก</a></li>
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
          	  <li><a href="nurseries/reports/index/basic_column"><img src="themes/hps/images/banner_Overall_result.jpg" width="226" height="118" /></a></li>
              <li><a href="http://thaigcd.ddc.moph.go.th/e-learning/wp-login.php?action=register" target="_blank"><img src="themes/hps/images/banner_e-learning.jpg" width="226" height="118" /></a></li>
              <li><img src="themes/hps/images/banner_evaluation.jpg" width="226" height="118" /></li>
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