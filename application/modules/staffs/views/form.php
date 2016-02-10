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
            remote: "officers/check_email/<?=@$user->id?>"
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
    
    $("select[name='area_id']").live("change",function(){
		$.post('users/get_province_under_area',{
				'area_id' : $(this).val()
			},function(data){
				$(".underprovince").html(data);
			});
	});
	
	$("select[name='province_to_select_amphur']").live("change",function(){
		$.post('users/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$(".amphur-frm").html(data);
			});
	});
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="staffs">เจ้าหน้าที่ศูนย์เด็กเล็ก</a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<h1>เจ้าหน้าที่ครู / ผู้ดูแลเด็ก</h1>
<br>

<div class="row">
    <div class="span8">
        <form id="regisform" class="form-horizontal" method="post" action="staffs/save/<?=$user->id?>">
            <div class="control-group">
                <label class="control-label" for="inputUsername">สถานะเจ้าหน้าที่</label>
                <div class="controls">
                  <?=form_dropdown('m_status',array('active'=>'เปิดการใช้งาน','deactive'=>'ปิดการใช้งาน'),$user->m_status,'class="input-xlarge"');?>
                </div>
            </div>
            <hr>
            <div class="control-group">
                <label class="control-label">เจ้าหน้าที่ประจำศูนย์</label>
                <div class="controls">
                    <input type="text" value="<?=$nursery->nursery_category->title?><?=$nursery->name?>" readonly>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">ชื่อ - นามสกุล <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname" value="<?=$user->name?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputsex">เพศ <span class="TxtRed">*</span></label>
                <div class="controls">
                    <?=form_dropdown('sex',array('ชาย'=>'ชาย','หญิง'=>'หญิง'),$user->sex,'class="input-xlarge"','--- เลือกเพศ ---');?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">โทรศัพท์ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="phone" id="inputcode" value="<?=$user->phone?>">
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
                <label class="control-label" for="inputEmail">อีเมล์ล็อกอิน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="email" id="inputEmail" value="<?=$user->email?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPass">รหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <!-- <input class="input-xlarge" type="input" name="password" id="inputPass" value="<?=($user->password)?$user->password:randomPassword();?>"> -->
                  <input class="input-xlarge" type="text" name="password" id="inputPass" value="<?=$user->password?>">
                </div>
            </div>
            <!-- <div class="control-group">
                <label class="control-label" for="inputPass">รหัสผ่าน</label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="password" id="inputPass" value="<?=$user->password?>">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="re-inputPass">ยืนยันรหัสผ่าน</label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="_password" id="re-inputPass" value="<?=$user->password?>">
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-label" for="inputCaptcha">รหัสลับ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <img src="users/captcha" /><Br>
                  <input class="input-small" type="text" name="captcha" id="inputCaptcha">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
				  <input type="hidden" name="nursery_id" value="<?=@$nursery->id?>">
				  <input type="hidden" name="user_type_id" value="10">
                  <input type="hidden" name="area_id" value="<?=@$nursery->area_id?>">
                  <input type="hidden" name="province_id" value="<?=@$nursery->province_id?>">
                  <input type="hidden" name="amphur_id" value="<?=@$nursery->amphur_id?>">
                  <input type="hidden" name="district_id" value="<?=@$nursery->district_id?>">
                  <input type="hidden" name="id" value="<?=@$user->id?>">
                  <input type="hidden" name="create_by_user_id" value="<?=user_login()->id?>">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                  <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
        </form>
    </div>
</div>
