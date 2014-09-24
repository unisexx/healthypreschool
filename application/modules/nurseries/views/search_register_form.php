<script type="text/javascript">
$(document).ready(function(){
	$("select[name=province_id]").live("change",function(){
		$.post('nurseries/searchs/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$("#amphur").html(data);
			});
	});
	
	$("select[name=amphur_id]").live("change",function(){
		$.post('nurseries/searchs/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$("#district").html(data);
			});
	});
	
	$("#frmnursery").validate({
	rules: 
	{
		name: 
		{ 
			required: true
			//remote: "nurseries/check_name"
		},
		area_id: 
		{ 
			required: true
		},
		nursery_category_id: 
		{ 
			required: true
		},
		number: 
		{ 
			required: true
		},
		moo:
		{
			required: true
		},
		province_id:
		{
			required: true
		},
		amphur_id:
		{
			required: true
		},
		district_id:
		{
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
			required: "กรุณากรอกชื่อชื่อศูนย์เด็กเล็กค่ะ"
			//remote: "ชื่อศูนย์เด็กเล็กนี้มีแล้วค่ะ"
		},
		area_id:
		{
			required: "กรุณาเลือกสคร.ค่ะ"
		},
		nursery_category_id:
		{
			required: "กรุณาเลือกคำนำหน้าค่ะ"
		},
		number:
		{
			required: "กรุณากรอกเลขที่"
		},
		moo:
		{
			required: "กรุณากรอกหมู่"
		},
		province_id:
		{
			required: "กรุณากรอกจังหวัดค่ะ"
		},
		amphur_id:
		{
			required: "กรุณากรอกอำเภอค่ะ"
		},
		district_id:
		{
			required: "กรุณากรอกตำบลค่ะ"
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
        captcha:
        {
            required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพ",
            remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพ"
        }
	}
	});
	
	$(".btn").click(function(){
		var name = $('input[name=name]').val();
		var province_name = $('select[name="province_id"] option:selected').text();
		var amphur_name = $('select[name="province_id"] option:selected').text();
		var district_name = $('select[name="district_id"] option:selected').text();
		
		$.get('nurseries/check_name',{
			'name' : $('input[name=name]').val(),
			'district_id' : $('select[name=district_id]').val()
		},function(data){
			if(data == "false"){
				alert("มีชื่อศูนย์เด็กเล็ก"+name+"\nจังหวัด"+province_name+"\nอำเภอ"+amphur_name+"\nตำบล"+district_name+"\nอยู่ในระบบแล้ว");
			}else{
				$("#frmnursery").submit();
			}
		});
	});
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries/searchs">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<form id="frmnursery" method="post" action="nurseries/searchs/register_save/<?=$nursery->id?>">

        <div id="data">
        	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</div>
    <!--search-->
    	<fieldset style="border:1px dashed #ccc; padding:10px; margin-bottom:10px;">
        <legend style="padding:0 5px; font-size:14px; font-weight:700; color:#666;">ข้อมูลศูนย์เด็กเล็ก</legend>
        	<table class="table">
				<tr>
                   <th>ปีที่เข้าร่วมโครงการ<strong> <span class="TxtRed">*</span></strong></th>
                   <td><?=date("Y")+543?>
                   	<input type="hidden" name="year" value="<?=date("Y")+543?>"></td>
                 </tr>
                 <tr>
                 	<th>คำนำหน้า<strong> <span class="TxtRed">*</span></strong></th>
                 	<td><?php echo  form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),$nursery->nursery_category_id,'','--- เลือกประเภท ---')?></td>
                 </tr>
        	    <tr>
        	      <th>ชื่อศูนย์เด็กเล็ก<strong> <span class="TxtRed">*</span></strong></th>
        	      <td><input type="text" name="name" value="<?=$nursery->name?>" id="textfield"  style="width:350px;"/></td>
        	 	</tr>
                 <tr>
        	      <th>เลขที่<strong> <span class="TxtRed">*</span></strong></th>
        	      <td><input type="text" name="number" value="<?=$nursery->number?>" id="textfield2" style="width:50px;" /></td>
        	 	</tr>
                 <tr>
                   <th>หมู่<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input type="text" name="moo" value="<?=$nursery->moo?>" id="textfield3" /></td>
                 </tr>
                 <tr>
                   <th>จังหวัด<strong> <span class="TxtRed">*</span></strong></th>
                   <td>
					<?php echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),$nursery->province_id,'','--- เลือกจังหวัด ---') ?>
					
					</td>
                 </tr>
                 <tr>
                   <th>อำเภอ<strong> <span class="TxtRed">*</span></strong></th>
                   <td id="amphur">
                   	<?php if($nursery->amphur_id or user_login()->user_type_id == 7 or  user_login()->user_type_id == 8):?>
	                   	<?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
	                        <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$nursery->province_id.' order by id asc'),$nursery->amphur_id,'','--- เลือกอำเภอ ---');?>
	                   	<?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
	                        <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by id asc'),$nursery->amphur_id,'','--- เลือกอำเภอ ---');?>
	                    <?php elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่อำเภอ?>
	                        <input type="text" value="<?=user_login()->amphur->amphur_name?>" disabled>
	                        <input type="hidden" name="amphur_id" value="<?=user_login()->amphur_id?>">
	                   	<?php endif;?></td>
	                <?php endif;?>
                 </tr>
                 <tr>
                   <th>ตำบล<strong> <span class="TxtRed">*</span></strong></th>
                   <td id="district">
                    <?php if($nursery->district_id or user_login()->user_type_id == 8):?>
                        <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7):?>
                            <?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$nursery->amphur_id.' order by id asc'),$nursery->district_id,'','--- เลือกตำบล ---');?>
                       	<?php elseif(user_login()->user_type_id == 8):?><?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.user_login()->amphur_id.' order by id asc'),$nursery->district_id,'','--- เลือกตำบล ---');?>
                       	<?php endif;?>
                    <?php endif;?>
                   	</td>
                 </tr>
                 <tr>
                   <th>รหัสไปรษณีย์<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input name="code" type="text" value="<?=$nursery->code?>" id="textfield4" size="10" /></td>
                 </tr>
                 <tr>
                 	<th>สังกัด</th>
                 	<td>
                 		<input type="radio" name="under" value="อบต." <?=($nursery->under == 'อบต.')?"checked=checked":""?>> อบต.
                 		<input type="radio" name="under" value="เทศบาล" <?=($nursery->under == 'เทศบาล')?"checked=checked":""?>> เทศบาล
                 		<input type="radio" name="under" value="เอกชน" <?=($nursery->under == 'เอกชน')?"checked=checked":""?>> เอกชน
                 		<input type="radio" name="under" value="อื่นๆ" <?=($nursery->under == 'อื่นๆ')?"checked=checked":""?>> อื่นๆ
                 		<input type="input" name="under_other" value="<?=$nursery->under_other?>">
                 	</td>
                 </tr>
      	    </table>
          </fieldset>
            
            
            <fieldset style="border:1px dashed #ccc; padding:10px;">
        <legend style="padding:0 5px; font-size:14px; font-weight:700; color:#666;">หัวหน้าศูนย์เด็กเล็ก</legend>
        <table class="table">
   	    <tr>
        	      <th>คำนำหน้า<strong> <span class="TxtRed">*</span></strong></th>
        	      <td>
        	      	<?php echo form_dropdown('p_title',array('นาย'=>'นาย','นาง'=>'นาง','นางสาว'=>'นางสาว'),$nursery->p_title,'','--- เลือกคำนำหน้า ---');?>
        	      	<input type="text" name="p_other" value="<?=$nursery->p_other?>" placeholder="อื่นๆ">
        	      </td>
       	 	  </tr>
                 <tr>
        	      <th>ชื่อ<strong> <span class="TxtRed">*</span></strong></th>
        	      <td><input type="text" name="p_name" value="<?=$nursery->p_name?>" id="textfield9"  style="width:250px;"/></td>
        	 	</tr>
                 <tr>
                   <th>นามสกุล<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input type="text" name="p_surname" value="<?=$nursery->p_surname?>" id="textfield6"  style="width:250px;"/></td>
                 </tr>
                 <tr>
                   <th>โทรศัพท์<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input type="text" name="p_tel" value="<?=$nursery->p_tel?>" id="textfield7" /></td>
                 </tr>
                 <tr>
                   <th>อีเมล์<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input type="text" name="p_email" value="<?=$nursery->p_email?>" id="textfield8" style="width:200px;" /></td>
                 </tr>
                 <tr>
                 	<th>รหัสลับ <span class="TxtRed">*</span></th>
                 	<td>
                 		<img src="users/captcha" /><Br>
						<input class="input-small" type="text" name="captcha" id="inputCaptcha" placeholder="รหัสลับ">
                 	</td>
                 </tr>
      	    </table>
          </fieldset>
          
          <div style="margin-left:25%; padding-top:10px;"><input class="btn" type="button" value=" ลงทะเบียน " /></div>
    </div>
</form>