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
	
	$("#regisform").validate({
    rules: 
    {
    	nursery_category_id:{required: true},
    	name:{required: true},
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
    	nursery_category_id:{required: "กรุณาเลือกคำนำหน้าชื่อ"},
    	name:{required: "กรุณากรอกชื่อศูนย์เด็กเล็ก"},
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
    
    // เช็คชื่อศูนย์เด็กเล็กซ้ำ
    $( "input[name=name]").keyup(function() {
    	$.post('users/check_nursery',{
    		nursery_name : $('input[name=name]').val()
    	},function(data){
    		$('.nursery_alert').html(data);
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
		  <li><a href="users/register">เจ้าหน้าที่สาธารณสุข</a></li>
		  <li class="active"><a href="users/register_center">เจ้าหน้าที่ศูนย์</a></li>
		</ul>
		
		<span class='nursery_alert' style="color:#CC181E;"></span>

        <form id="regisform" class="form-horizontal" method="post" action="users/signup_center">
        	
        	<div class="control-group">
                <label class="control-label">คำนำหน้า</label>
                <div class="controls">
                  <?php echo  form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),'','','--- เลือกประเภท ---')?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">ชื่อศูนย์เด็กเล็ก<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เลขที่</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="number" style="width:50px;">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">หมู่</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="moo" style="width:50px;">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">จังหวัด/อำเภอ/ตำบล</label>
                <div class="controls">
                  <?php echo form_dropdown('province_id',get_option('id','name','provinces'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	           	
					<span id="amphur">
						<?php if(@$_GET['amphur_id']):?>
							<?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_GET['province_id']),@$_GET['amphur_id'],'','--- เลือกจังหวัด ---') ?>
						<?php endif;?>
					</span>
					
					<span id="district">
						<?php if(@$_GET['district_id']):?>
							<?php echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_GET['amphur_id']),@$_GET['district_id'],'','--- เลือกจังหวัด ---') ?>
						<?php endif;?>
					</span>
					
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">รหัสไปรษณีย์</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="code">
                </div>
            </div>
            <hr>
            
             <div class="control-group">
                <label class="control-label">คำนำหน้า</label>
                <div class="controls">
                  <?php echo form_dropdown('p_title',array('นาย'=>'นาย','นาง'=>'นาง','นางสาว'=>'นางสาว'),'','','--- เลือกคำนำหน้า ---');?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">ชื่อหัวหน้าศูนย์</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_name">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">นามสกุล</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_surname">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">อีเมล์</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_email">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เบอร์ติดต่อ</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_tel">
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
                  <input type="hidden" name="m_status" value="active">
                  <input type="hidden" name="user_type_id" value="9">
                  <input type="submit" class="btn btn-small btn-info" value="สมัครสมาชิก">
                </div>
            </div>
        </form>
    </div>
</div>