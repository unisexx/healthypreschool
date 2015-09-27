<script type="text/javascript">
$(function() {
		<?php if(!is_login()): ?>
	$("#saturday").hide();
	<?php endif; ?>


});
</script>
<!--<div class="search">
	<form method="get">
	<label>แบบสอบถาม: </label><input type="text" name="search" size="30" value="<?php echo @$_GET['search'] ?>" />
	<label> กลุ่มงาน: </label><?php // echo form_dropdown('group_id',get_option('id','name','groups'),@$_GET['group_id'],'class="group_ddl"','ทุกกลุ่มงาน');?>
	<label> ตั้งแต่วันที่: </label><input class="datepicker" size="10" type="text" name="start" value="<?php echo @$_GET['start'] ?>" />
	<label> ถึง: </label><input class="datepicker" size="10" type="text" name="end" value="<?php echo @$_GET['end'] ?>" />
	<input type="submit" value="ค้นหา" />
	</form>
</div>-->

<table class="table">
	<tr>
		<th>แบบสอบถาม</th>
		<th>สร้างโดย</th>
		<!-- <th>กลุ่มงาน</th> -->
		<th>วันที่สร้าง</th>
		<th style="text-align:center;">คะแนน</th>
	</tr>
	<?php foreach($topics as $topic): ?>
	<tr <?php echo cycle() ?>>
		<td><a class="title" href="elearnings/questionaire/<?php echo $topic->id ?>" target="_blank" ><?php echo $topic->title ?></a></td>
		<td><?php echo @$topic->user->name?></a></td>
		<!--<td><?php //echo lang_decode($topic->user->group->name,'th') ?></a></td>-->
		<td><?php echo mysql_to_th($topic->created) ?></a></td>
		<td style="text-align:center;">
			<?php $ans = new answer; ?><?php echo round($ans->select('user_id,session')->distinct()->where_related('questionaire','topic_id',$topic->id)->get()->result_count()) ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<?php echo $topics->pagination() ?>