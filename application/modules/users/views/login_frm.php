<script type="text/javascript" src="themes/zulex/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
	$("#form").validate({
	rules: 
	{
		username: 
		{ 
			required: true
		},
		password: 
		{
			required: true,
			minlength: 8
		}
	},
	messages:
	{
		username: 
		{ 
			required: "กรุณากรอกชื่อล็อกอิน"
		},
		password: 
		{
			required: "กรุณากรอกรหัสผ่าน",
			minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 8 ตัวอักษร"
		}
	}
	});
});
</script>
<div id="register">
	<div class="breadcrumb">
		<a href="home"><?php echo lang('home')?></a> > <?php echo lang('login')?>
	</div>
	
	<div id="bodywrap-content" class="corner">
		
		<div class="header-bar">
			<h1><?php echo lang('login')?></h1>
		</div>
	
		<h2>กรุณากรอกข้อมูลใน (*) ให้ครบถ้วน</h2>
		<form id="form" method="post" action="users/login" enctype="multipart/form-data">
			<p>
			<label for="username">ชื่อในการล็อกอิน :</label>
			<input id="username" name="username" type="text" value=""> *
			</p>
			<p>
			<label for="password">รหัสผ่าน :</label>
			<input id="password" name="password" type="password" value=""> *
			</p>
			<p>
			<label for="submit"></label>
			<input id="submit" type="submit" value="เข้าสู่ระบบ">
			</p>
		</form>
	</div>
</div>