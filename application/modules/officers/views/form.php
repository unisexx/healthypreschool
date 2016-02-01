<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
    $("#regisform").validate({
    ignore: ":hidden",
    rules: 
    {
    	name: 
        { 
            required: true
        },
        user_type_id:{
        	required: true
        },
        province_id:{
        	required: true
        },
        amphur_id:{
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
        user_type_id:
        {
        	required: "กรุณาเลือกตำแหน่ง"
        },
    	province_id: 
        { 
            required: "กรุณาเลือกจังหวัด"
        },
    	amphur_id: 
        { 
            required: "กรุณาเลือกอำเภอ"
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
    
    // $("select[name='area_id']").live("change",function(){
		// $.post('users/get_province_under_area',{
			// 'area_id' : $(this).val()
		// },function(data){
			// $(".underprovince").html(data);
		// });
	// });
	
	$("select[name='area_id']").live("change",function(){
		$.post('officers/show_province',{
			'area_id' : $(this).val()
		},function(data){
			$(".underprovince").html(data);
		});
	});
	
	$("select[name='province_id']").live("change",function(){
		$.post('users/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$(".amphur-frm").html(data);
			});
	});
	
	// $('.btnclickform').live("click",function(){
		// var user_type_id = $('select[name=user_type_id] option:selected').val();
		// var area_id = $('select[name=area_id] option:selected').val();
		// var province_id = $('#province_select option:selected').val();
		// var province_id2 = $('select[name=province_to_select_amphur] option:selected').val();
		// var amphur_id = $('select[name=amphur_id] option:selected').val();
// 		
		// if(user_type_id == 6){
			// if(area_id == ""){
				// alert('กรุณาเลือกพื้นที่');
				// return false;
			// }else{
				// $('#regisform').submit();
			// }
		// }else if(user_type_id == 7){
			// if(province_id == ""){
				// alert('กรุณาเลือกจังหวัด');
				// return false;
			// }else{
				// $('#regisform').submit();
			// }
		// }else if(user_type_id == 8){
			// if(province_id2 == ""){
				// alert('กรุณาเลือกจังหวัด');
				// return false;
			// }else if(amphur_id == ""){
				// alert('กรุณาเลือกตำบล');
				// return false;
			// }else{
				// $('#regisform').submit();
			// }
		// }else{
			// alert('กรุณาเลือกประเภท');
		// }
	// });
	
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="officers">เจ้าหน้าที่สาธารณะสุข</a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<h1>เจ้าหน้าที่สาธารณะสุข</h1>
<br>

<div class="row">
    <div class="span8">
        <form id="regisform" class="form-horizontal" method="post" action="officers/save/<?=$user->id?>">
            <div class="control-group">
                <label class="control-label" for="inputUsername">สถานะเจ้าหน้าที่</label>
                <div class="controls">
                  <?=form_dropdown('m_status',array('deactive'=>'ปิดการใช้งาน','active'=>'เปิดการใช้งาน'),$user->m_status,'class="input-xlarge"');?>
                </div>
            </div>
            <hr>
            <div class="control-group">
                <label class="control-label">ประเภท</label>
                <div class="controls">
                    <?php if(user_login()->user_type_id == 1): // admin เห็นเลือกได้ทุกตำแหน่ง?>
                    <?=form_dropdown('user_type_id',array('6'=>'เจ้าหน้าที่ประจำเขต','7'=>'เจ้าหน้าที่ประจำจังหวัด','8'=>'เจ้าหน้าที่ประจำอำเภอ'),$user->user_type_id,'class="input-xlarge"','--- เลือกตำแหน่ง ---');?>
                    <?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร. เพิ่มเจ้าหน้าที่จังหวัด?>
                        <input type="text" value="เจ้าหน้าที่ประจำจังหวัด" disabled>
                        <input type="hidden" name="user_type_id" value="7">
                    <?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่ประจำศูนย์ สคร. เพิ่มเจ้าหน้าที่จังหวัด?>
                        <input type="text" value="เจ้าหน้าที่ประจำอำเภอ" disabled>
                        <input type="hidden" name="user_type_id" value="8">
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group" id="area" <?=($user->user_type_id == 6)?'':'style="display:none;"';?>>
                <label class="control-label">เจ้าหน้าที่ประจำเขต</label>
                <div class="controls">
                    <?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12','13'=>'สคร.13'),$user->area_id,'class="input-xlarge"','--- เลือกสคร. ---');?>
                    <div class="underprovince"></div>
                </div>
            </div>
            <div class="control-group" id="province" <?=($user->user_type_id == 7 or user_login()->user_type_id == 6)?'':'style="display:none;"';?>>
                <label class="control-label">เจ้าหน้าที่ประจำจังหวัด</label>
                <div class="controls">
                    <?php if(user_login()->user_type_id == 1): // admin เห็นทุกจังหวัด?>
                    <?php echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),$user->province_id,'id="province_select" class="input-xlarge"','--- เลือกจังหวัด ---') ?>
                    <?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร. เห็นจังหวัดในเขตตัวเอง?>
                        <?php get_province_dropdown(@$_GET['area_id'],@$user->province_id);?>
                    <?php endif;?>
                </div>
            </div>
            <div class="control-group" id="amphur" <?=($user->user_type_id == 8 or user_login()->user_type_id == 7)?'':'style="display:none;"';?>>
                <label class="control-label">เจ้าหน้าที่ประจำอำเภอ</label>
                <div class="controls">
                    <?php if(user_login()->user_type_id == 1): // admin เห็นทุกจังหวัด?>
                    <div>
                
                		<?//=form_dropdown('province_to_select_amphur',get_option('id','name','provinces order by name asc'),@$user->amphur->province_id,'class="input-xlarge"','--- เลือกจังหวัด ---');?>
                		<?=form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$user->amphur->province_id,'class="input-xlarge"','--- เลือกจังหวัด ---');?>
                	</div>
                	<div class="amphur-frm">
                		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures'),@$user->amphur_id,'class="input-xlarge" style="margin-top:5px";','--- เลือกอำเภอ ---');?>
                	</div>
                    <?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่ประจำอำเภอ เห็นตำบลของตัวเอง?>
                        <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),$user->amphur_id,'','--- เลือกอำเภอ ---');?>
                    <?php endif;?>
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
                  <input class="input-xlarge" type="input" name="password" id="inputPass" value="<?=($user->password)?$user->password:randomPassword();?>">
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
                  <input type="submit" class="btn btn-small btn-info btnclickform" value="บันทึก">
                </div>
            </div>
        </form>
    </div>
</div>