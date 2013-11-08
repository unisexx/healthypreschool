<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
    $("#regisform").validate({
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
            email: true,
            remote: "users/check_email"
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
            email: "กรุณากรอกอีเมล์ให้ถูกต้อง",
            remote: "อีเมล์นี้ไม่สามารถใช้งานได้"
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
    
    $("select[name=user_type_id]").change(function(){
        //alert( this.value );
        switch(this.value)
        {
           case '6':
            $("#area").show();
            $("#province,#amphur,#district").hide();
            $("select[name=province_id],select[name=amphur_id],select[name=district_id]").val("0");
           break;
           case '7':
            $("#province").show();
            $("#area,#amphur,#district").hide();
            $("select[name=area_id],select[name=amphur_id],select[name=district_id]").val("0");
           break;
           case '8':
            $("#amphur").show();
            $("#province,#area,#district").hide();
            $("select[name=province_id],select[name=area_id],select[name=district_id]").val("0");
           break;
        }
    });
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">แก้ไขข้อมูลส่วนตัว</li>
</ul>

<h1>แก้ไขข้อมูลส่วนตัว</h1>
<br>

<div class="row">
    <div class="span8">
        <form id="regisform" class="form-horizontal" method="post" action="users/edit_profile_save">
            <div class="control-group">
                <label class="control-label" for="inputsex">ประเภท</label>
                <div class="controls">
                	<input type="text" value="<?=user_login()->user_type->name?>" disabled>
                    <input type="hidden" name="user_type_id" value="<?=user_login()->user_type_id?>">
                </div>
            </div>
            <div class="control-group" id="area" <?=($user->user_type_id == 6)?'':'style="display:none;"';?>>
                <label class="control-label" for="inputsex">เจ้าหน้าที่ประจำเขต</label>
                <div class="controls">
                    <input type="text" value="<?=user_login()->area->area_name?>" disabled>
                    <input type="hidden" name="area_id" value="<?=user_login()->area_id?>">
                </div>
            </div>
            <div class="control-group" id="province" <?=($user->user_type_id == 7)?'':'style="display:none;"';?>>
                <label class="control-label" for="inputsex">เจ้าหน้าที่ประจำจังหวัด</label>
                <div class="controls">
                    <input type="text" value="<?=user_login()->province->name?>" disabled>
                    <input type="hidden" name="province_id" value="<?=user_login()->province_id?>">
                </div>
            </div>
            <div class="control-group" id="amphur" <?=($user->user_type_id == 8)?'':'style="display:none;"';?>>
                <label class="control-label" for="inputsex">เจ้าหน้าที่ประจำอำเภอ</label>
                <div class="controls">
                    <input type="text" value="<?=user_login()->amphur->amphur_name?>" disabled>
                    <input type="hidden" name="amphur_id" value="<?=user_login()->amphur_id?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputUsername">ชื่อ - นามสกุล <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname" value="<?=user_login()->name?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputsex">เพศ <span class="TxtRed">*</span></label>
                <div class="controls">
                    <?=form_dropdown('sex',array('ชาย'=>'ชาย','หญิง'=>'หญิง'),user_login()->sex,'class="input-xlarge"','--- เลือกเพศ ---');?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputUsername">โทรศัพท์ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="phone" id="inputcode" value="<?=user_login()->phone?>">
                </div>
            </div>
            <hr>
            <!-- <div class="control-group">
                <label class="control-label" for="inputUsername">ชื่อล็อกอิน</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="username" id="inputUsername" value="<?=$user->username?>">
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-label" for="inputEmail">อีเมล์ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="email" id="inputEmail" value="<?=user_login()->email?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPass">รหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="password" id="inputPass" value="<?=user_login()->password?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="re-inputPass">ยืนยันรหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="_password" id="re-inputPass" value="<?=user_login()->password?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCaptcha">รหัสลับ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <img src="users/captcha" /><Br>
                  <input class="input-small" type="text" name="captcha" id="inputCaptcha">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                </div>
            </div>
        </form>
    </div>
</div>
