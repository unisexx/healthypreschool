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
    	/*nursery_category_id:{required: true},*/
    	p_name:{required: true},
    	p_surname:{required: true},
    	province_id:{
        	required: true
        },
        amphur_id:{
        	required: true
        },
        district_id:{
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
    	p_name:{required: "กรุณากรอกชื่อ"},
    	p_surname:{required: "กรุณากรอกนามสกุล"},
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
// 	
	// $('input[name=name]').keyup(function() {
	    // delay(function(){
// 	      
			// $.get('users/check_nursery',{
	    		// nursery_name : $('input[name=name]').val()
	    	// },function(data){
	    		// $('.nursery_alert').html(data);
	    	// });
// 	      
	    // }, 2500 );
	// });
	
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ลงทะเบียนบุคคลทั่วไป<span class="divider">/</span></li>  
</ul>


<div id="data">
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">ลงทะเบียนบุคคลทั่วไป</div>
		<span class='nursery_alert' style="color:#CC181E;"></span>

        <form id="regisform" class="form-horizontal" method="post" action="users/signup_person">
        	
            <div class="control-group">
                <label class="control-label">ชื่อ - นามสกุล</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="name" value="<?=@$user->p_name?>">
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label" for="inputsex">เพศ <span class="TxtRed">*</span></label>
                <div class="controls">
                    <?=form_dropdown('sex',array('ชาย'=>'ชาย','หญิง'=>'หญิง'),'','class="input-xlarge"','--- เลือกเพศ ---');?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">จังหวัด/อำเภอ/ตำบล<span class="TxtRed">*</span></label>
                <div class="controls">
                  <?php echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$user->province_id,'','--- เลือกจังหวัด ---') ?>                
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">อำเภอ<span class="TxtRed">*</span></label>
                <div id="amphur" class="controls">                                                     
                        <?php if(@$user->amphur_id){?>
                            <?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.@$user->province_id),@$user->amphur_id,'','--- เลือกอำเภอ ---') ?>
                        <?php }else{ ?>
                            <?php echo '<select name="amphur_id"><option value=""></option></select>';?>
                        <?php }?>                                       
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">ตำบล<span class="TxtRed">*</span></label>
                <div id="district" class="controls">                                                     
                        <?php if(@$user->district_id){?>
                            <?php echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$user->amphur_id),@$user->district_id,'','--- เลือกตำบล ---') ?>
                        <?php }else{ ?>
                            <?php echo '<select name="district_id"><option value=""></option></select>';?>
                        <?php }?>                                       
                </div>
            </div>
                                   
            <div class="control-group">
                <label class="control-label">เบอร์ติดต่อ</label>
                <div class="controls">
                  <input class="input-xlarge" type="text" name="p_tel" value="<?=@$user->p_tel?>">
                </div>
            </div>
            <hr>
            
            <div class="control-group">
                <label class="control-label" for="inputEmail">อีเมล์ สำหรับล็อกอิน <span class="TxtRed">*</span></label>
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
                  <input type="hidden" name="area_id" value="<?=@$user->area_id?>">
                  <input type="hidden" name="year" value="<?=(date("Y")+543)?>">
                  <input type="hidden" name="m_status" value="active">
                  <input type="hidden" name="user_type_id" value="11">
                  <input type="hidden" name="nursery_type" value="2">
                  <input type="submit" class="btn btn-small btn-info" value="สมัครสมาชิก">
                </div>
            </div>
        </form>
</div>