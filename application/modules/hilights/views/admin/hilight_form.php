<h1>ไฮไลท์</h1>
<form action="hilights/admin/hilights/save/<?php echo $hilight->id ?>" method="post" enctype="multipart/form-data" >
<table class="">
	<tr><th></th><td>
		<?=is_file('uploads/hilight/'.$hilight->image)?thumb('uploads/hilight/'.$hilight->image,600,false,1):"";?>
	</td></tr>
	<tr><th>รูปภาพ :</th><td><input type="file" name="image" /> ขนาด 710x211 พิกเซล</td></tr>
	<tr>
		<th>หัวข้อ :</th>
		<td>
			<input type="text" name="title" value="<?php echo $hilight->title?>" class="input-xxlarge" />
		</td>
	</tr>
	<!-- <tr>
		<th>รายละเอียดอย่างย่อ :</th>
		<td><textarea name="detail" class="full"><?=$hilight->detail?></textarea></td>
	</tr> -->
	<tr><th>ลิ้งไปเว็บไซต์ :</th><td><input class="input-xxlarge" type="text" name="url" value="<?php echo $hilight->url?>"/></td></tr>
	<tr><th></th><td><input class="btn btn-primary" type="submit" value="บันทึก" /> <input class="btn" type="button" name="back" value="ย้อนกลับ" onclick="window.location = 'hilights/admin/hilights'" /></td></tr>
</table>
</form>