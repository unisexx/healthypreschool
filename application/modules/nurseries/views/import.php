<form enctype="muultipart/form-data"  action="nurseries/doimport" method="get">
<div>
	<? echo form_dropdown('province_id',get_option('id','name','provinces'),'','','--select--');?>
	<!--<input type="file" name="filename">--><input type="submit" name="submit" value="import">
	<?
	if(@$import != ''){
		print_r($import);
	}
	?>
</div>
</form>