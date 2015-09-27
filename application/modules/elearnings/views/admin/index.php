<h1>E-learning</h1>
<?php echo $topics->pagination()?>
<table class="table">
	<tr>
		<th width="60">สถานะ</th>
		<th>แบบสอบถาม</th>
		<th>โดย</th>
		<th>วันที่สร้าง</th>
		<th>รายงาน</th>
		<th width="90">
			<?php // if(permission('galleries', 'create')):?>
			<a class="btn btn-mini btn-primary" href="elearnings/admin/elearnings/form" class="tiny">เพิ่มรายการ</a>
			<?php // endif;?>
		</th>
	</tr>
	<?php foreach($topics as $topic): ?>
	<tr <?php echo cycle()?>>
		<td><input type="checkbox" name="status" value="<?php echo $topic->id ?>" <?php echo ($topic->status=="approve")?'checked="checked"':'' ?> /></td>
		<td class="span8"><a href="elearnings/questionaire/<?php echo $topic->id ?>" target="_blank"><?php echo $topic->title ?></a></td>
		<td><?php echo @$topic->user->name?></a></td>
		<td><?php echo mysql_to_th($topic->created) ?></a></td>
		<td><a href="elearnings/admin/elearnings/report/<?php echo $topic->id ?>" ><i class="fa fa-pie-chart"></i> รายงาน</a></td>
		<td>
			<?php // if(permission('galleries', 'update')):?>
			<a class="btn btn-mini" href="elearnings/admin/elearnings/form/<?php echo $topic->id ?>" >แก้ไข</a>
			<?php // endif;?>
			<?php // if(permission('galleries', 'delete')):?>
			<a class="btn btn-mini" href="elearnings/admin/elearnings/delete/<?php echo $topic->id ?>" onclick="return confirm('คุณต้องการลบแบบสอบถาม ?')">ลบ</a>
			<?php // endif;?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo $topics->pagination()?>