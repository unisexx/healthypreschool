<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
	$(function(){
			$("#frmMain").validate({
				rules: 
				{
					"name": 
					{ 
							required: true
					}
				},
				messages:
				{
					"name": 
					{ 
							required: "กรุณากรอกหัวข้อค่ะ"
					}
				}
			});		
	})
</script>
<h1 style="margin:0 0 15px;">อัลบั้ม</h1>
<form id="frmMain" method="post" action="galleries/admin/categories/save/<?php echo $category->id?>" enctype="multipart/form-data">
	<table class="form">
		<tr>
			<th>ชื่ออัลบั้ม :</th>
			<td>
				<input type="text" name="name" rel="th" value="<?php echo $category->name?>" />
			</td>
		</tr>
		<tr>	
			<th></th>
			<td>
			<input type="hidden" name="parents" value="<?php echo $parent->id ?>"  />
			<input type="hidden" name="module" value="<?php echo $parent->module ?>"  />
			<tr><td><input type="submit" value="บันทึก" class="submit small" /></td></tr>
		</tr>
	</table>
</form>
