<script type="text/javascript" src="themes/gcdnew/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
	$("form").validate({
	rules: 
	{
		email: 
		{ 
			required: true,
			email: true
			//remote: "newsletters_email_lists/check_email"
		}
	},
	messages:
	{
		email: 
		{ 
			required: "กรุณากรอกอีเมล์ค่ะ",
			email: "กรุณากรอกอีเมล์ให้ถูกต้องค่ะ"
			//remote: "อีเมล์นี้ไม่สามารถใช้งานได้"
		}
	}
	});
});
</script>

<h1 style="margin:0 0 15px;">อีเมล์ลงทะเบียนรับข่าวสาร</h1>
<form method="post" action="newsletters/admin/newsletters_email_lists/save/<?php echo $email->id?>" enctype="multipart/form-data">
	<table class="form">
		<tr>
			<th>อีเมล์ :</th>
			<td>
				<input id="email" type="text" name="email" rel="th" value="<?php echo $email->email ?>" />
			</td>
		</tr>
		<!-- <tr>
			<th>เลือกกลุ่มข่าวสาร :</th>
			<td>
				<?php $grouplist = explode(",", $email->newsletter); ?>

				<?php foreach($categories as $row):?>
				<input id="<?php echo lang_decode($row->name)?>" type="checkbox" name="newsletters[]" value="<?php echo $row->id?>"
					<?php 
					foreach($grouplist as $key=>$value){
						if($grouplist[$key] == $row->id){
							echo"checked";
						}
					}
					?>
				>
				<label for="<?php echo lang_decode($row->name)?>" style="cursor:pointer;"><?php echo lang_decode($row->name)?></label>
				<?php endforeach;?>
			</td>
		</tr> -->
		<tr>	
			<th></th>
			<td>
			<input type="submit" value="บันทึก" class="submit small" />
			<input type="button" value="ย้อนกลับ" class="submit small" onclick="window.location = 'newsletters/admin/newsletters_email_lists'" />
			</td>
		</tr>
	</table>
</form>