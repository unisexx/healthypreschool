<h1>เว็บไซต์ที่เกี่ยวข้อง</h1>
<?php echo $hilights->pagination()?>
<table class="list">
	<tr>
		<th>แสดง</th>
		<!-- <th>เริ่มวันที่</th> -->
		<!-- <th>รูปภาพ</th> -->
		<th>หัวข้อ</th>
		<th>ลิ้งค์ไปยัง</th>
		<th>โดย</th>
		<th width="90">
			<?php if(permission('weblinks', 'create')):?>
			<a class="btn" href="weblinks/admin/weblinks/form">เพิ่มรายการ</a>
			<?php endif;?>
		</th>
	</tr>
	<?php foreach($hilights as $hilight): ?>
	<tr <?php echo cycle()?>>
		<td><input type="checkbox" name="status" value="<?php echo $hilight->id ?>" <?php echo ($hilight->status=="approve")?'checked="checked"':'' ?> /></td>
		<!-- <td><?php echo DB2Date($hilight->start_date)?></td> -->
		<!-- <td><?php echo thumb("uploads/weblink/".$hilight->image,185,63,0)?></td> -->
		<td><?php echo lang_decode($hilight->title);?></td>
		<td><?=$hilight->url?></td>
		<td><?php echo $hilight->user->display?></td>
		<td>
			<?php if(permission('weblinks', 'update')):?>
			<a class="btn" href="weblinks/admin/weblinks/form/<?php echo $hilight->id?>" >แก้ไข</a> 
			<?php endif;?>
			<?php if(permission('weblinks', 'delete')):?>
			<a class="btn" href="weblinks/admin/weblinks/delete/<?php echo $hilight->id?>" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
			<?php endif;?>
		</td>
		</tr>
		<?php endforeach; ?>
		
	</table>
<?php echo $hilights->pagination()?>