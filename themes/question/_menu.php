<div class="bghead">
	<a href="home" ><img src="themes/gcdnew/images/logo.png" style="float:left; margin:0 10px 0 0;" /></a>
	<h1 class="cufon">ระบบสร้างแบบสอบถามสำนักโรคติดต่อทั่วไป</h1><small class="cufon">กรมควบคุมโรค  กระทรวงสาธารณสุข</small>
	<div class="clear"></div>
	<div class="user-data">
		<h2>ยินดีต้อนรับเข้าสู่ระบบค่ะ</h2>
		<!-- <?php if(is_login()): ?>
		<span class="icon icon-user-5"></span> คุณ  <?php echo user()->profile->first_name ?> <?php echo user()->profile->last_name ?>
		<?php endif; ?> -->
		<br />
		<a href="home">กลับสู่หน้าหลัก</a>
	</div>
</div>

<div style="clear:both;"></div>
<ul id="saturday">
	<?php // if(is_authen('questionaire','add')): ?>
	<li <?php echo menu_active('questions')?>><a href="docs/form" >สร้างแบบสอบถาม</a></li>
	<?php // endif; ?>
    <li <?php echo menu_active('officer')?>><a href="docs/index" >รายการแบบสอบถาม</a></li>
	<li <?php echo menu_active('officer')?>><a href="docs/publics" >คลังแบบสอบถาม</a></li>
	<li <?php echo menu_active('officer')?>><a href="users/signout" onclick="return confirm('ยืนยันการออกจากระบบ')" >ออกจากระบบ</a></li>
</ul>
        
        
         