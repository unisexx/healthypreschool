<h1><?=$type_name?></h1>
<form action="contents/admin/contents/save/<?=$type?>/<?php echo $content->id ?>" method="post" enctype="multipart/form-data" >
<table class="form">
	<tr><th></th><td><?php if($content->image != ""):?><?php echo thumb("uploads/content/".$content->image,110,135,1);?><?php endif;?></td></tr>
	<tr><th>รูปภาพ :</th><td><input type="file" name="image" /></td></tr>
	<tr>
		<th>ชื่อ-นามสกุล :</th>
		<td>
			<input type="text" name="title" value="<?=$content->title?>" class="full" />
		</td>
	</tr>
	<tr>
		<th>ตำแหน่ง :</th>
		<td>
			<input type="text" name="position" value="<?=$content->position?>" class="full"/>
		</td>
	</tr>
	<tr>
		<th>อีเมล์ :</th>
		<td>
			<input type="text" name="email" value="<?=$content->email?>" class="full"/>
		</td>
	</tr>
	<tr>
		<th>โทรศัพท์ :</th>
		<td>
			<input type="text" name="tel" value="<?=$content->tel?>" class="full"/>
		</td>
	</tr>
	<tr>
		<th>มือถือ :</th>
		<td>
			<input type="text" name="mobile" value="<?=$content->mobile?>" class="full"/>
		</td>
	</tr>
	<tr>
		<th>แฟกซ์ :</th>
		<td>
			<input type="text" name="fax" value="<?=$content->fax?>" class="full"/>
		</td>
	</tr>
	<tr>
		<th>สถานที่ปฏิบัติงาน :</th>
		<td>
			<input type="text" name="location" value="<?=$content->location?>" class="full"/>
		</td>
	</tr>
	<?php if($type == 'seat'):?>
	<tr><th>หมวดหมู่ :</th><td><?php echo form_dropdown('category_id',$content->category->get_option(),$content->category_id,'');?></td></tr>
	<?php endif;?>
	<tr><th></th><td><input type="submit" value="บันทึก" /><?=form_back()?></td></tr>
</table>
<?php echo form_referer() ?>
</form>