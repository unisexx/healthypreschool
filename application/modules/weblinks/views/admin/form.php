<script type="text/javascript">
$(document).ready(function(){
	$("[rel=en]").hide();
	$(".lang a").click(function(){
		$("[rel=" + $(this).attr("href") + "]").show().siblings().hide();
		$(this).addClass('active').siblings().removeClass('active');
		return false;
	})
});
</script>
<h1>เว็บไซต์ที่เกี่ยวข้อง</h1>
<form action="weblinks/admin/weblinks/save/<?php echo $hilight->id ?>" method="post" enctype="multipart/form-data" >
<table class="form">
	<!-- <tr class="trlang"><th></th><td class="lang"><a href="th" class="active flag th">ไทย</a><a href="en" class="flag en">อังกฤษ</a></td></tr> -->
	<!-- <tr><th></th><td><img class="img" style="width:185px; height:63px;" src="<?php echo (is_file('uploads/weblink/'.$hilight->image))? 'uploads/weblink/'.$hilight->image : 'media/images/dummy/656x253.gif' ?>"  /></td></tr> -->
	<!-- <tr><th>รูปภาพ :</th><td><input type="file" name="image" /></td></tr> -->
	<tr>
		<th>หัวข้อ :</th>
		<td>
			<input type="text" name="title[th]" rel="th" value="<?php echo lang_decode($hilight->title,'th')?>" class="full" />
			<input type="text" name="title[en]" rel="en" value="<?php echo lang_decode($hilight->title,'en')?>" class="full" />
		</td>
	</tr>
	<tr><th>ลิ้งไปเว็บไซต์ :</th><td><input class="full" type="text" name="url" value="<?php echo $hilight->url?>"/></td></tr>
	<!-- <tr><th>เริ่ม :</th><td><input type="text" name="start_date" value="<?php echo DB2Date(($hilight->start_date)?$hilight->start_date:date("Y-m-d"))?>" class="datepicker" /></td></tr>
	<tr><th>สิ้นสุด :</th><td><input type="text" name="end_date" value="<?php echo DB2Date($hilight->end_date)?>" class="datepicker" /></td></tr> -->
	<tr><th></th><td><input type="submit" value="บันทึก" /><input type="button" name="back" value="ย้อนกลับ" onclick="window.location = 'hilights/admin/hilights'" /></td></tr>
</table>
</form>