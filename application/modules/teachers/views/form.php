<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<script type="text/javascript">
$(function(){
    $("#teacherform").validate({
    rules: 
    {
    	name: 
        { 
            required: true
        },
    	sex: 
        { 
            required: true
        },
    	phone: 
        { 
            required: true
        },
        email: 
        { 
            required: true,
            email: true
            // remote: "users/check_email"
        },
        password: 
        {
            required: true,
            minlength: 4
        },
        _password:
        {
            equalTo: "#inputPass"
        },
        captcha:
        {
            required: true,
            remote: "users/check_captcha"
        }
    },
    messages:
    {
    	name: 
        { 
            required: "กรุณากรอกชื่อ - นามสกุล"
        },
    	sex: 
        { 
            required: "กรุณาระบุเพศ"
        },
    	phone: 
        { 
            required: "กรุณากรอกเบอร์โทรศัพท์"
        },
        email: 
        { 
            required: "กรุณากรอกอีเมล์",
            email: "กรุณากรอกอีเมล์ให้ถูกต้อง"
            // remote: "อีเมล์นี้ไม่สามารถใช้งานได้"
        },
        password: 
        {
            required: "กรุณากรอกรหัสผ่าน",
            minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 4 ตัวอักษร"
        },
        _password:
        {
            equalTo: "กรุณากรอกรหัสผ่านให้ตรงกันทั้ง 2 ช่อง"
        },
        captcha:
        {
            required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพ",
            remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพ"
        }
    }
	});
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="teachers">ตรวจสอบรายชื่อครู / เจ้าหน้าที่</a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<h1> ตรวจสอบรายชื่อครู / เจ้าหน้าที่</h1>
<br>
<div class="row">
	<div class="span12">
		<form id="teacherform" action="teachers/save" method="post" class="form-horizontal">
			<div class="control-group">
                <label class="control-label" for="inputUsername">สถานะเจ้าหน้าที่</label>
                <div class="controls">
                  <?=form_dropdown('m_status',array('deactive'=>'ปิดการใช้งาน','active'=>'เปิดการใช้งาน'),$teacher->m_status,'class="input-xlarge"');?>
                </div>
            </div>
			<hr>
			<div class="control-group">
		        <label class="control-label">ชื่อ - สกุล<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="name" value="<?=$teacher->name?>">
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">เพศ<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input type="radio" name="sex" value="ชาย" <?=($teacher->sex == "ชาย")?'checked':'';?>> ชาย
		          <input type="radio" name="sex" value="หญิง" <?=($teacher->sex == "หญิง")?'checked':'';?>> หญิง
		        </div>
		    </div>
		    <!-- <div class="control-group">
		        <label class="control-label">วัน / เดือน / ปี เกิด</label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="name" value="<?=$teacher->room_name?>">
		        </div>
		    </div> -->
		    <div class="control-group">
		        <label class="control-label">ตำแหน่ง</label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="position" value="<?=$teacher->position?>">
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">เบอร์ติดต่อ</label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="phone" value="<?=$teacher->phone?>">
		        </div>
		    </div>
		     <div class="control-group">
		        <label class="control-label">อีเมล์</label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="email" value="<?=$teacher->email?>">
		        </div>
		    </div>
		    <div class="control-group">
                <label class="control-label" for="inputPass">รหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="password" id="inputPass" value="<?=$teacher->password?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="re-inputPass">ยืนยันรหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="_password" id="re-inputPass" value="<?=$teacher->password?>" >
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCaptcha">captcha <span class="TxtRed">*</span></label>
                <div class="controls">
                  <img src="users/captcha" /><Br>
                  <input class="input-small" type="text" name="captcha" id="inputCaptcha">
                </div>
            </div>
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="nursery_id" value="<?=user_login()->nursery_id?>">
                  <input type="hidden" name="user_type_id" value="10">
                  <input type="hidden" name="id" value="<?=$teacher->id?>">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                  <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
		</form>
	</div>
</div>