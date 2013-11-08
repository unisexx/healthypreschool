<style>
ul.list-icon li{float:left;}
</style>
<script type="text/javascript">
	$(function(){
		$('select[name=album_category_id]').attr('disabled','');
		$('input[name=image_add]').click(function(){
			$('.table tr:last').before('<tr><th>รูปภาพ </th><td><input type="file" name="image[]" /></td></tr>');
		})
		
		$('input[name=cat_add]').click(function(){
			
			if($('input[name=cat_name]').val()!="")
			{
				$.post('albums/admin/albums/category_save',{'name':$('input[name=cat_name]').val()},function(data){
					$('.album_category_id').html(data);
					$('input[name=cat_name]').val('')
					$('.add_option').hide();
					$('.cat_add').text('เพิ่ม').siblings().show();;
				})
			}
			
		})
		
		$('input[name=cat_edit]').click(function(){
			
			if($('input[name=cat_edit_name]').val()!="")
			{
				$.post('albums/admin/albums/category_save/'+ $('input[name=cat_edit_name]').attr('rel'),{'name':$('input[name=cat_edit_name]').val()},function(data){
					$('.album_category_id').html(data);
					$('input[name=cat_edit_name]').val('')
					$('.edit_option').hide();
					$('.cat_edit').text('แก้ไข').siblings().show();
				})
			}
			
		})

		$('.cat_add').toggle(function(){
			$('.cat_add').text('ยกเลิก');
			$(this).siblings().hide();
			$('.add_option').show();
			return false;
		},function(){
			$('.cat_add').text('เพิ่ม');
			$('.add_option').hide();
			$(this).siblings().show();
			return false;
		});
		
		$('.cat_edit').toggle(function(){
			$(this).siblings().hide();
			$('select[name=album_category_id]').attr('disabled','disabled');
			$('.cat_edit').text('ยกเลิก');
			$('input[name=cat_edit_name]').val($('select[name=album_category_id] option:selected').text()).attr('rel',$('select[name=album_category_id] option:selected').val());
			$('.edit_option').show();
			return false;
		},function(){
			$('.cat_edit').text('แก้ไข');
			$(this).siblings().show();
			$('.edit_option').hide();
			$('select[name=album_category_id]').attr('disabled','');
			return false;
		});
		
		$('.cat_delete').click(function(){
			if(confirm('ยืนยันการลบหมวดหมู่ "' + $('select[name=album_category_id] option:selected').text() + '"'))
			{
				$.post('albums/admin/albums/category_delete/' + $('select[name=album_category_id] option:selected').val(),
				function(data){
					$('.album_category_id').html(data);
				})
			}
			return false
		});
		
		$('input[name=picture_delete]').click(function(){
			if(confirm('ยืนยันการลบ'))
			{
				var me = $(this);
				$.post('albums/admin/albums/delete_picture/' + $(this).attr('rel'),function(data){
					me.parent().parent().remove();
				})
			}
		})

	})
</script>
<h1 style="margin:0 0 15px;">อัลบั้ม</h1>
<form method="post" action="albums/admin/albums/save/<?php echo $album->id?>" enctype="multipart/form-data">
	<table class="table">
		<!--
		<tr>
			
			<th>หมวดหมู่</th>
			<td>
				<span class="album_category_id"><?php echo form_dropdown('album_category_id',get_option('id','name','album_categories'),$album->album_category_id) ?></span> 
				<span>
					<a class="cat_add" href="#">เพิ่ม</a> 
					<a class="cat_delete" href="#">ลบ</a> 
					<a class="cat_edit" href="#">แก้ไข</a>
				</span>
				<div class="add_option"><input type="text" name="cat_name" value="" /> <input type="button" name="cat_add" value="เพิ่มหมวดหมู่" /></div>
				<div class="edit_option"><input type="text" name="cat_edit_name" value="" /> <input type="button" name="cat_edit" value="แก้ไขหมวดหมู่" /></div>
			</td>
		</tr>
		-->
		<tr>
			<th>อัลบั้ม</th>
			<td>
				<div class="form-inline">
				<input class="span6" type="text" name="name" value="<?php echo $album->name ?>" class="full" /> <input class="btn btn-primary" type="button" name="image_add" value="เพิ่มรูปภาพ" /></div>
			</td>
		</tr>
		<!-- <tr>
			<th>ลายน้ำ</th>
			<td><?php echo form_icon('watermark', 'watermark'); ?></td>
		</tr>
		<tr>
			<th>ตำแหน่งลายน้ำ</th>
			<td>
				<?php echo form_radio('position', 'TL').'บนซ้าย'; ?>
				<?php echo form_radio('position', 'TR').'บนขวา'; ?>
				<?php echo form_radio('position', 'BL').'ล่างซ้าย'; ?>
				<?php echo form_radio('position', 'BR', 'BR').'ล่างขวา'; ?>
			</td>
		</tr> -->
		<?php foreach($album->picture as $picture): ?>
		<tr>
			<th>รูปภาพ </th>
			<td>
				<a href="uploads/albums/<?php echo $album->id ?>/<?php echo $picture->image ?>" rel="lightbox">
				<img style="width:50px; vertical-align:middle;" src="uploads/albums/<?php echo $album->id ?>/thumbnail/<?php echo $picture->image ?>" />
				</a>
				<!-- <input type="text" name="title[]" placeholder="ชื่อรูป"> -->
				<input type="file" name="image[]" />
				<input type="hidden" name="picture_id[]" value="<?php echo $picture->id ?>" />
				<input class="btn btn-mini" type="button" name="picture_delete" value="ลบ" rel="<?php echo $picture->id ?>" />
			</td>
		</tr>
		<?php endforeach; ?>
		<tr>
			<th>รูปภาพ </th>
			<td><input type="file" name="image[]" /></td>
		</tr>
		<tr>	
			<th></th>
			<td>
				<input type="hidden" name="agency_id" value="<?php //echo $_GET['agency_id'] ?>" />
				<?php echo form_submit('','บันทึก','class="btn btn-primary"')?>
				<?php echo form_button('','ย้อนกลับ','class="btn" onclick="window.location = \'albums/admin/albums\'"')?>
			</td>
		</tr>
	</table>
</form>
