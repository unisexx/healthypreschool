<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$("select[name='province_id']").live("change",function(){
		$("#district").html("");
		$.post('nurseries/searchs/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$("#amphur").html(data);
			});
	});
	
	$("select[name='amphur_id']").live("change",function(){
		$.post('nurseries/searchs/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$("#district").html(data);
			});
	});
	
	jQuery.validator.addMethod("chknursery", function(value, element) {
	    
	    var name = $('input[name=name]').val();
		var province_name = $('select[name="province_id"] option:selected').text();
		var amphur_name = $('select[name="province_id"] option:selected').text();
		var district_name = $('select[name="district_id"] option:selected').text();
		var check_result;
		$.get('nurseries/check_name',{
			'name' : $('input[name=name]').val(),
			'district_id' : value
		},function(data){
			check_result = data;
		});
		
	    return check_result;
	    console.log(check_result);
	}, "มีชื่อศูนย์เด็กเล็กนี้อยู่ในระบบแล้ว");
	
	$("#regisform").validate({
    rules: 
    {
    	/*nursery_category_id:{required: true},*/
    	name:{required: true},
    	number: 
		{ 
			required: true
		},
		moo:
		{
			required: true
		},
    	province_id:{
        	required: true
        },
        amphur_id:{
        	required: true
        },
        district_id:{
        	// chknursery: true,
        	required: true
        },
        code:
		{
			required: true
		},
		p_title:
		{
			required: true
		},
		p_name:
		{
			required: true
		},
		p_surname:
		{
			required: true
		},
		p_tel:
		{
			required: true
		},
		p_email:
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
    	/*nursery_category_id:{required: "กรุณาเลือกคำนำหน้าชื่อ"},*/
    	name:{required: "กรุณากรอกชื่อศูนย์เด็กเล็ก"},
    	number:
		{
			required: "กรุณากรอกเลขที่ค่ะ"
		},
		moo:
		{
			required: "กรุณากรอกหมู่ค่ะ"
		},
    	province_id: 
        { 
            required: "กรุณาเลือกจังหวัด"
        },
    	amphur_id: 
        { 
            required: "กรุณาเลือกอำเภอ"
        },
    	district_id: 
        { 
            required: "กรุณาเลือกตำบล"
        },
        code:
		{
			required: "กรุณากรอกรหัสไปรษณีย์ค่ะ"
		},
		p_title:
		{
			required: "กรุณากรอกคำนำหน้าค่ะ"
		},
		p_name:
		{
			required: "กรุณากรอกชื่อค่ะ"
		},
		p_surname:
		{
			required: "กรุณากรอกนามสกุลค่ะ"
		},
		p_tel:
		{
			required: "กรุณากรอกโทรศัพท์ค่ะ"
		},
		p_email:
		{
			required: "กรุณากรอกอีเมล์ค่ะ"
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
    
    
    // เช็คชื่อศูนย์เด็กเล็กซ้ำ (delay keyup)
    // var delay = (function(){
	  // var timer = 0;
	  // return function(callback, ms){
	    // clearTimeout (timer);
	    // timer = setTimeout(callback, ms);
	  // };
	// })();
	
	$('input[name=name]').blur(function() {
	    $.get('users/check_nursery',{
    		nursery_name : $('input[name=name]').val()
    	},function(data){
    		$('.nursery_alert').html(data);
    	});
	});
	
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="users/register_center">ลงทะเบียนเจ้าหน้าที่ศูนย์</a> <span class="divider">/</span></li>
  <li class="active"><?=$nursery->nursery_category->title?><?=$nursery->name?></li>
</ul>


<div id="data">
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">ลงทะเบียนเจ้าหน้าที่ศูนย์</div>
    	
    	<!-- <ul class="nav nav-tabs home-nav-tabs estimate-tab">
		  <li><a href="users/register">เจ้าหน้าที่สาธารณสุข</a></li>
		  <li class="active"><a href="users/register_center">เจ้าหน้าที่ศูนย์</a></li>
		</ul> -->
		
		<span class='nursery_alert' style="color:#444;"></span>

        <form id="regisform" class="form-horizontal" method="post" action="users/signup_center/<?=$nursery->id?>">
        	
        	<!-- <div class="control-group">
                <label class="control-label">คำนำหน้า</label>
                <div class="controls">
                  <?php echo  form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$nursery->nursery_category_id,'','--- เลือกประเภท ---')?>
                </div>
            </div> -->
            
            <div class="control-group">
                <label class="control-label">ชื่อศูนย์เด็กเล็ก<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" value="<?=$nursery->name?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เลขที่<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="number" value="<?=$nursery->number?>" style="width:50px;">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">หมู่<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="moo" value="<?=$nursery->moo?>" style="width:50px;">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">จังหวัด/อำเภอ/ตำบล<span class="TxtRed">*</span></label>
                <div class="controls">
                  <?php echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$nursery->province_id,'','--- เลือกจังหวัด ---') ?>
	           	
					<div id="amphur" style="margin-top:10px;">
						<?php if(@$nursery->amphur_id):?>
							<?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$nursery->province_id),@$nursery->amphur_id,'','--- เลือกอำเภอ ---') ?>
						<?php endif;?>
					</div>
					
					<div id="district" style="margin-top:10px;">
						<?php if(@$nursery->district_id):?>
							<?php echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$nursery->amphur_id),@$nursery->district_id,'','--- เลือกตำบล ---') ?>
						<?php endif;?>
					</div>
					
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">รหัสไปรษณีย์<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="code" value="<?=$nursery->code?>">
                </div>
            </div>
            <hr>
            
             <div class="control-group">
                <label class="control-label">คำนำหน้า<span class="TxtRed">*</span></label>
                <div class="controls">
                  <?php echo form_dropdown('p_title',array('นาย'=>'นาย','นาง'=>'นาง','นางสาว'=>'นางสาว'),@$nursery->p_title,'','--- เลือกคำนำหน้า ---');?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">ชื่อหัวหน้าศูนย์<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_name" value="<?=$nursery->p_name?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">นามสกุล<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_surname" value="<?=$nursery->p_surname?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">อีเมล์<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_email" value="<?=$nursery->p_email?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เบอร์ติดต่อ<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_tel" value="<?=$nursery->p_tel?>">
                </div>
            </div>
            <hr>
            
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
                  <input type="hidden" name="area_id" value="<?=$nursery->area_id?>">
                  <input type="hidden" name="year" value="<?=(date("Y")+543)?>">
                  <input type="hidden" name="m_status" value="active">
                  <input type="hidden" name="user_type_id" value="9">
                  <input type="hidden" name="nursery_type" value="1">
                  <input type="submit" class="btn btn-small btn-info" value="สมัครสมาชิก">
                </div>
            </div>
        </form>
</div>