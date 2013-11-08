<script type="text/javascript" src="themes/zulex/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
	$("#frm").validate({
	rules: 
	{
		username: 
		{ 
			required: true
		},
		email: 
		{ 
			required: true,
			email: true
			//remote: "users/check_email"
		},
		password: 
		{
			required: true,
			minlength: 4
		},
		password_2:
		{
			equalTo: "#password"
		}
	},
	messages:
	{
		username: 
		{ 
			required: "กรุณากรอกชื่อล็อกอิน"
		},
		email: 
		{ 
			required: "กรุณากรอกอีเมล์",
			email: "กรุณากรอกอีเมล์ให้ถูกต้อง"
			//remote: "อีเมล์นี้ไม่สามารถใช้งานได้"
		},
		password: 
		{
			required: "กรุณากรอกรหัสผ่าน",
			minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 4 ตัวอักษร"
		},
		password_2:
		{
			equalTo: "กรุณากรอกรหัสผ่านให้ตรงกันทั้ง 2 ช่อง"
		}
	}
	});
});
</script>

<h1>Users</h1>
<form method="post" action="users/admin/users/save/<?php echo $user->id?>" id="frm">
<table class="form tab">
	<tr>
		<th>อีเมล์ :</th>
		<td><?php echo form_input('email',$user->email,'size="30" id="email"')?></td>
	</tr>
	<tr>
		<th>ชื่อในการล้อกอิน :</th>
		<td><?php echo form_input('username',$user->username,'size="30" id="username"')?></td>
	</tr>
	<tr>
		<th>รหัสผ่าน :</th>
		<td><?php echo form_password('password','','size="30" id="password"')?></td>
	</tr>
	<tr>
		<th>ยืนยันรหัสผ่าน :</th>
		<td><?php echo form_password('password_2','','size="30" id="password_2"')?></td>
	</tr>
    <tr>
		<td colspan="2"><hr /></td>
	</tr>
    <tr>
		<th>ชื่อ :</th>
		<td><input id="name" name="name" type="text" value="<?php echo $user->name?>"></td>
	</tr>
    <tr>
		<th>ยี่ห้อรถที่ใช้ :</th>
		<td><input id="car" name="car" type="text" value="<?php echo $user->car?>"></td>
	</tr>
     <tr>
		<th>ชื้อสินค้า zulex ประเภท/รุ่น :</th>
		<td><textarea id="zulex" name="zulex"><?php echo $user->zulex?></textarea></td>
	</tr>
     <tr>
		<th>รุ่นรถที่ใช้ :</th>
		<td><input id="carvertion" name="carvertion" type="text" value="<?php echo $user->carvertion ?>"></td>
	</tr>
     <tr>
		<th>ภายในครอบครัวมีรถจำนวน :</th>
		<td><input id="count" name="count" type="text" value="<?php echo $user->count?>"></td>
	</tr>
     <tr>
		<th>ท่านมีแนวโน้มในการเปลี่ยนรถยนต์ :</th>
		<td>
        	<INPUT type="radio" name="carchange" value="ไม่มี" <?php echo (($user->carchange == "ไม่มี") ? 'checked=checked' : '')?>> ไม่มี
    		<INPUT type="radio" name="carchange" value="มี" <?php echo (($user->carchange == "มี") ? 'checked=checked' : '')?>> มี
            <br />
            กี่ปี <input type="text" name="car_year" value="<?php echo $user->car_year?>" style="width:40px;">
			ยี่ห้อ <input type="text" name="car_brand" value="<?php echo $user->car_brand?>" style="width:87px;">
			รุ่น <input type="text" name="car_version" value="<?php echo $user->car_vertion?>" style="width:88px;">
		</td>
	</tr>
     <tr>
		<th>รายได้บุคคล :</th>
		<td>
        	<INPUT type="radio" name="income" value="ต่ำกว่า 5,000" <?php echo (($user->income == "ต่ำกว่า 5,000") ? 'checked=checked' : '')?>> ต่ำกว่า 5,000
    		<INPUT type="radio" name="income" value="5001 - 10000" <?php echo (($user->income == "5001 - 10000") ? 'checked=checked' : '')?>> 5001 - 10000
			<INPUT type="radio" name="income" value="10001 - 15000" <?php echo (($user->income == "10001 - 15000") ? 'checked=checked' : '')?>> 10001 - 15000<br>
			<INPUT type="radio" name="income" value="15001 - 20000" <?php echo (($user->income == "15001 - 20000") ? 'checked=checked' : '')?>> 15001 - 20000
			<INPUT type="radio" name="income" value="20001 - 25000" <?php echo (($user->income == "20001 - 25000") ? 'checked=checked' : '')?>> 20001 - 25000
			<INPUT type="radio" name="income" value="25000 ขึ้นไป" <?php echo (($user->income == "25000 ขึ้นไป") ? 'checked=checked' : '')?>> 25000 ขึ้นไป
        </td>
	</tr>
     <tr>
		<th>รายได้ต่อครอบครัว :</th>
		<td><input id="incomefamily" name="incomefamily" type="text" value="<?php echo $user->incomefamily?>"></td>
	</tr>
     <tr>
		<th>รู้จัก zulex จาก :</th>
		<td>
        	<?php $knows = explode(",", $user->know);?>
             <?php foreach ($register_categories as $register_category):?>
                	<?php echo lang_decode($register_category->name)?><br />
                    		<?php foreach ($register_category->register->order_by('id','desc')->get() as $register):?>
								&nbsp;&nbsp;&nbsp;<input type="checkbox" name="know[]" value="<?php echo $register->id?>" 
                                <?php 
									foreach ($knows as $know){
										if($know == $register->id){
											echo "checked=checked";
										}
									}
								?>
                                /> <?php echo $register->title?><br />
							<?php endforeach;?>
                <?php endforeach;?>
		</td>
	</tr>
     <tr>
		<th>แนวโน้มการเลือกซื้อสินค้าในอนาคต :</th>
		<td>
        		<?php $buyproduct_selects = explode(",", $user->buyproduct);?>
				<?php foreach ($buyproducts as $buyproduct):?>
                    &nbsp;&nbsp;&nbsp;<input type="checkbox" name="buyproduct[]" value="<?php echo $buyproduct->id?>" 
                    <?php 
						foreach ($buyproduct_selects as $buyproduct_select){
							if($buyproduct_select == $buyproduct->id){
								echo "checked=checked";
							}
						}
					?>
                    /> <?php echo lang_decode($buyproduct->title)?><br />
                <?php endforeach;?>
		</td>
	</tr>
     <tr>
		<th>กิจกรรมที่อยากให้ zulex จัด :</th>
		<td><input id="activity" name="activity" type="text" value="<?php echo $user->activity?>"></td>
	</tr>
    <tr>
		<th></th>
		<td><?php echo form_submit('',lang('btn_submit'))?></td>
	</tr>
</table>
</form>