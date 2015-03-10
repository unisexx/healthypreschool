<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="childrens">ตรวจสอบรายชื่อ / เด็กนักเรียน</a> <span class="divider">/</span></li>
  <li>ประวัติการป่วย</li>
</ul>

<h1><?=$classroom_detail->title.''.$classroom_detail->child_name?></h1>

<table class="table table-bordered table-striped">
	<tr>
		<th>วันที่ป่วย</th>
		<th>โรคที่ป่วย</th>
		<!-- <th>ห้องเรียน</th> -->
	</tr>
	<?foreach($diseases as $row):?>
	<tr>
		<td><?=mysql_to_th($row->start_date,'s',FALSE)?> - <?=mysql_to_th($row->end_date,'s',FALSE)?></td>
		<td><?=get_diseases_name($row->c1);?></td>
		<!-- <td><?=$row->classroom->room_name?></td> -->
	</tr>
	<?endforeach;?>
</table>