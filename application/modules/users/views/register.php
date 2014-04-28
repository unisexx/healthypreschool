<script language="javascript">
$(function(){
    $("#regisform").validate({
    rules: 
    {
    	user_type_id: 
        { 
            required: true
        },
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
    	user_type_id: 
        { 
            required: "กรุณาเลือกประเภทผู้ใช้งาน"
        },
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
           case '6': // เจ้าหน้าที่เขต
            $("#area").show();
            $("#province,#amphur").hide();
            $('.underprovince,.province_frm').html("");
            $("select[name=province_id],select[name=amphur_id],select[name=province_to_select_amphur]").val("0");
           break;
           case '7': // เจ้าหน้าที่จังหวัด
            $("#province").show();
            $("#area,#amphur").hide();
            $('.underprovince').html("");
            $("select[name=area_id],select[name=amphur_id],select[name=province_to_select_amphur]").val("0");
            
            $.post('users/get_province','',function(data){
            	$(".province_frm").html(data);
            });
           break;
           case '8': // เจ้าหน้าที่อำเภอ
            $("#amphur").show();
            $("#province,#area").hide();
            $('.underprovince').html("");
            $("select[name=province_id],select[name=area_id]").val("0");
            $('select[name=amphur_id]').attr('disabled','disabled');
           break;
           default:
           	$("#province,#area,#amphur").hide();
           	$('.underprovince').html("");
           	$("select[name=province_id],select[name=area_id],select[name=amphur_id]").val("0");
           	$('select[name=amphur_id]').attr('disabled','disabled');
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
  <li class="active">สมัครสมาชิก</li>
</ul>

<h1>สมัครสมาชิก</h1>
<br>

<div class="row">
    <div class="span9">
    	
    	<ul class="nav nav-tabs home-nav-tabs estimate-tab">
		  <li class="active"><a href="users/register">เจ้าหน้าที่สาธารณสุข</a></li>
		  <li><a href="users/register_center">เจ้าหน้าที่ศูนย์</a></li>
		</ul>
	
    	<div class="alert alert-info" style="width:600px;">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>ประกาศ!!!</strong> หลังจากสมัครสมาชิกแล้ว ผู้สมัครจะต้องรอการตรวจสอบจากเจ้าหน้าที่ก่อนจึงจะเข้าใช้งานระบบได้
		</div>

        <form id="regisform" class="form-horizontal" method="post" action="users/signup">
        	<div class="control-group">
                <label class="control-label">ประเภท <span class="TxtRed">*</span></label>
                <div class="controls">
                    <?=form_dropdown('user_type_id',array('6'=>'เจ้าหน้าที่ประจำเขต','7'=>'เจ้าหน้าที่ประจำจังหวัด','8'=>'เจ้าหน้าที่ประจำอำเภอ'),'','class="input-xlarge"','--- เลือกประเภท ---');?>
                </div>
            </div>
            <div class="control-group" id="area" style="display:none;">
                <label class="control-label">เจ้าหน้าที่ประจำเขต</label>
                <div class="controls">
                    <?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'class="input-xlarge"','--- เลือกสคร. ---');?>
                    <div class="underprovince"></div>
                </div>
            </div>
            <div class="control-group" id="province" style="display:none;">
                <label class="control-label">เจ้าหน้าที่ประจำจังหวัด</label>
                <div class="controls province_frm">
                    
                </div>
            </div>
            <div class="control-group" id="amphur" style="display:none;">
                <label class="control-label">เจ้าหน้าที่ประจำอำเภอ</label>
                <div class="controls">
                	<div>
                		<?=form_dropdown('province_to_select_amphur',get_option('id','name','provinces order by name asc'),@$_GET['province_id'],'class="input-xlarge"','--- เลือกจังหวัด ---');?>
                	</div>
                	<div class="amphur-frm">
                		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures'),'','class="input-xlarge" style="margin-top:5px"; disabled','--- เลือกอำเภอ ---');?>
                	</div>
                </div>
            </div>
            <hr>
            <div class="control-group">
                <label class="control-label">ชื่อ - นามสกุล <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname" placeholder="ชื่อ - นามสกุล">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputsex">เพศ <span class="TxtRed">*</span></label>
                <div class="controls">
                    <?=form_dropdown('sex',array('ชาย'=>'ชาย','หญิง'=>'หญิง'),'','class="input-xlarge"','--- เลือกเพศ ---');?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">โทรศัพท์ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="phone" id="inputcode" placeholder="โทรศัพท์">
                </div>
            </div>
            <hr>
            <!-- <div class="control-group">
                <label class="control-label" for="inputUsername">ชื่อล็อกอิน</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="username" id="inputUsername" placeholder="ชื่อล็อกอิน">
                </div>
            </div> -->
            <div class="control-group">
                <label class="control-label" for="inputEmail">อีเมล์ล็อกอิน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="email" id="inputEmail" placeholder="อีเมล์">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputPass">รหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="password" id="inputPass" placeholder="รหัสผ่าน">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="re-inputPass">ยืนยันรหัสผ่าน <span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="password" name="_password" id="re-inputPass" placeholder="ยืนยันรหัสผ่าน">
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
                  <input type="submit" class="btn btn-small btn-info" value="สมัครสมาชิก">
                </div>
            </div>
        </form>
    </div>
</div>