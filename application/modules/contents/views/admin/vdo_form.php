<h1><?=$type_name?></h1>
<form action="contents/admin/contents/save/<?=$type?>/<?php echo $content->id ?>" method="post" enctype="multipart/form-data" >
<table class="form">
	<?php if($content->vdo_script != ""):?>
	<tr>
		<th>รูปภาพ :</th>
		<td><?=YoutubeIframe2Thumb($content->vdo_script,180,120)?></td>
	</tr>
	<?php endif;?>
	<tr>
		<th>หัวข้อ :</th>
		<td>
			<input type="text" name="title" value="<?=$content->title?>" class="input-xxlarge" />
		</td>
	</tr>
	<tr><th>สคริปท์วิดีโอ<br>(youtube) :</th><td><textarea rows="5" name="vdo_script" class="input-xxlarge"><?=$content->vdo_script?></textarea></td></tr>
	<tr><th></th><td><input class="btn btn-primary" type="submit" value="บันทึก" /> <?=form_back()?></td></tr>
</table>
<?php echo form_referer() ?>
</form>