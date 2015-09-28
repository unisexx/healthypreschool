<h1>E-learning</h1>
<?php echo $topics->pagination()?>
<form id="order" action="elearnings/admin/elearnings/save_orderlist" method="post">
<table class="table table-striped">
	<tr>
		<th width="60">สถานะ</th>
		<th>ลำดับที่</th>
		<th>แบบสอบถาม</th>
		<th>โดย</th>
		<th>วันที่สร้าง</th>
		<!-- <th>รายงาน</th> -->
		<th width="90">
			<?php // if(permission('galleries', 'create')):?>
			<a class="btn btn-mini btn-primary" href="elearnings/admin/elearnings/form" class="tiny">เพิ่มรายการ</a>
			<?php // endif;?>
		</th>
	</tr>
	<?php foreach($topics as $topic): ?>
	<tr>
		<td><input type="checkbox" name="status" value="<?php echo $topic->id ?>" <?php echo ($topic->status=="approve")?'checked="checked"':'' ?> /></td>
		<td>
            <input type="number" name="orderlist[]" size="3" value="<?php echo $topic->orderlist?>" style="width:40px;">
            <input type="hidden" name="orderid[]" value="<?php echo $topic->id ?>">
        </td>
		<td class="span8">
			<?php echo $topic->title ?><br>
			<?if($topic->set_final == 1):?>
				<span class="label label-important" style="font-size: 8px;">แบบทดสอบสุดท้าย</span>
			<?else:?>
				<a href="elearnings/admin/elearnings/set_final/<?=$topic->id?>" style="font-size: 8px;">ตั้งค่าเป็นแบบทดสอบสุดท้าย</a>
			<?endif;?>
		</td>
		<td><?php echo @$topic->user->name?></a></td>
		<td><?php echo mysql_to_th($topic->created) ?></a></td>
		<!-- <td><a href="elearnings/admin/elearnings/report/<?php echo $topic->id ?>" ><i class="fa fa-pie-chart"></i> รายงาน</a></td> -->
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
<input type="submit" class="btn btn-mini btn-primary" value="บันทึกลำดับ">
</form>
<?php echo $topics->pagination()?>