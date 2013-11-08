<h1><?=$type_name?></h1>
<div class="search">
	<form class="form-inline" method="get">
		<table class="form">
			<tr>
				<th>หัวข้อ</th><td><input type="text" name="search" value="<?php echo (isset($_GET['search']))?$_GET['search']:'' ?>" /></td>
				<!-- <th>หมวดหมู่</th><td><?php echo form_dropdown('category_id',$contents->category->get_option(),@$_GET['category_id'],'','ทั้งหมด') ?></td> -->
				<td><input class="btn" type="submit" value="ค้นหา" /></td>
			</tr>
		</table>
	</form>
</div>
<?php echo $contents->pagination()?>
<form id="order" action="contents/admin/contents/save_orderlist/<?=$type?>" method="post">
<table class="table">
	<tr>
		<th width="70">แสดง</th>
		<?php if($type == 'seat' or $type == 'house'):?>
			<th>ลำดับ</th>
		<?php endif;?>
		<th>หัวข้อ</th>
		<th>โดย</th>
		<!-- <?php if($type == 'informations' or $type == 'articles'):?>
		<th><a rel="lightbox" class="btn" href="categories/admin/categories/<?=$type?>?iframe=true&width=90%&height=90%">หมวดหมู่</a></th>
		<?php endif;?> -->
		<th width="90">
			<?php if(permission($type, 'create')):?>
			<a class="btn btn-mini btn-primary" href="contents/admin/contents/form/<?=$type?>">เพิ่มรายการ</a>
			<?php endif;?>
		</th>
	</tr>
	<?php foreach($contents as $row): ?>
	<tr <?php echo cycle()?>>
		<td><input type="checkbox" name="status" value="<?php echo $row->id ?>" <?php echo ($row->status=="approve")?'checked="checked"':'' ?> /></td>
		<?php if($type == 'seat' or $type == 'house'):?>
			<td><input type="text" name="orderlist[]" size="1" value="<?php echo $row->orderlist?>"><input type="hidden" name="orderid[]" value="<?php echo $row->id ?>"></td>
		<?php endif;?>
		<td><?php echo lang_decode($row->title)?></td>
		<td><?php echo $row->user->display?></td>
		<!-- <?php if($type == 'informations' or $type == 'articles'):?>
		<td><?php echo anchor('contents/admin/contents/index/'.$type.'?category_id='.$row->category_id,$row->category->name) ?></td>
		<?php endif;?> -->
		<td>
			<?php if(permission($type, 'update')):?>
			<a class="btn btn-mini" href="contents/admin/contents/form/<?=$type?>/<?php echo $row->id?>" >แก้ไข</a> 
			<?php endif;?>
			<?php if(permission($type, 'delete')):?>
			<a class="btn btn-mini" href="contents/admin/contents/delete/<?=$type?>/<?php echo $row->id?>" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
			<?php endif;?>
		</td>
		</tr>
		<?php endforeach; ?>
	</table>
<?php echo $contents->pagination()?>
<input type="hidden" name="type" value="<?=$type?>">
<?php if($type == 'seat' or $type == 'house'):?>
<input type="submit" value="บันทึก">
<?php endif;?>
</form>
