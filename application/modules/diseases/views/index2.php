<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">แบบคัดกรองโรค</li>
</ul>

<h1>แบบคัดกรองโรค</h1><br>

<?foreach($rs as $row):?>
<h2>ปีการศึกษา <?=$row->year?></h2>
<table class="table table-bordered table-striped">
	<tr>
		<th>ห้องเรียน</th>
		<th class="span2">จัดการ</th>
	</tr>
	<?php
		$classroom = new Classroom_children_detail();
		$classroom->distinct();
		$classroom->select('classroom_id,room_name');
		$classroom->where('year = '.$row->year);
		$classroom->where_related('classrooms', 'nursery_id', user_login()->nursery_id)->get();
		// $classroom->check_last_query();
		
		foreach($classroom as $item):
	?>
	<tr>
		<td><?=$item->room_name?></td>
		<td><a href="diseases/form3?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=$item->classroom_id?>&school_year=<?=$row->year?>" class="btn btn-small">แบบคัดกรองโรค</a></td>
	</tr>
	<?endforeach;?>
</table>
<?endforeach;?>