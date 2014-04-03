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
	
    	<!-- <div class="alert alert-info" style="width:600px;">
		  <button type="button" class="close" data-dismiss="alert">&times;</button>
		  <strong>ประกาศ!!!</strong> หลังจากสมัครสมาชิกแล้ว ผู้สมัครจะต้องรอการตรวจสอบจากเจ้าหน้าที่ก่อนจึงจะเข้าใช้งานระบบได้
		</div> -->

        <form id="regisform" class="form-horizontal" method="post" action="users/signup">
        	
        	<div class="control-group">
                <label class="control-label">คำนำหน้า</label>
                <div class="controls">
                  <?php echo  form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),'','','--- เลือกประเภท ---')?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">ชื่อศูนย์<span class="TxtRed">*</span></label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname">
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
                <label class="control-label">ที่อยู่</label>
                <div class="controls">
                  <textarea name="address" class="input-xlarge"></textarea>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เบอร์ศูนย์</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">หัวหน้าศูนย์</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เจ้าหน้าที่ประสานงาน</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">เบอร์ติดต่อ</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" id="inputname">
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
                <label class="control-label" for="inputCaptcha">รหัสลับ <span class="TxtRed">*</span></label>
                <div class="controls">
                  <img src="users/captcha" /><Br>
                  <input class="input-small" type="text" name="captcha" id="inputCaptcha" placeholder="รหัสลับ">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="user_type_id" value="9">
                  <input type="submit" class="btn btn-small btn-info" value="สมัครสมาชิก">
                </div>
            </div>
        </form>
    </div>
</div>