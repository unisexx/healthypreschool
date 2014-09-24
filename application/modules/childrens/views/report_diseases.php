<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="childrens">ตรวจสอบรายชื่อ / เด็กนักเรียน</a> <span class="divider">/</span></li>
  <li>รายการแบบคัดกรองโรค</li>
</ul>

<h1><?=$classroom_detail->title.''.$classroom_detail->child_name?></h1>

<table class="table table-bordered table-striped">
	<tr>
		<th>วันที่</th>
		<th>หวัด</th>
		<th>มือ เท้า ปาก</th>
		<th>อุจจาระร่วงเฉียบพลัน</th>
		<th>ไข้</th>
		<th>ไข้ออกผื่น</th>
		<th>อื่นๆ</th>
	</tr>
	<?foreach($diseases as $row):?>
	<tr>
		<td><?=str_pad($row->day, 2, '0', STR_PAD_LEFT)?>/<?=str_pad($row->month, 2, '0', STR_PAD_LEFT)?>/<?=$row->year?></td>
		<td><?=($row->c1 == 'C')?'C':'';?></td>
		<td><?=($row->c1 == 'H')?'H':'';?></td>
		<td><?=($row->c1 == 'D')?'D':'';?></td>
		<td><?=($row->c1 == 'F')?'F':'';?></td>
		<td><?=($row->c1 == 'R')?'R':'';?></td>
		<td><?=($row->c1 == 'O')?$row->other:'';?></td>
	</tr>
	<?endforeach;?>
	<tr>
		<th>รวม</th>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
</table>