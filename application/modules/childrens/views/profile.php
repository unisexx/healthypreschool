<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="childrens">ตรวจสอบรายชื่อเด็ก / นักเรียน</a> <span class="divider">/</span></li>
  <li>ข้อมูลเด็ก</li>
</ul>

<h1><?=$child->title?> <?=$child->child_name?></h1>
<br>
<h2>BMI</h2>
<table class="table">
	<tr>
		<th>วันที่</th>
		<th>อายุ</th>
		<th>น้ำหนัก</th>
		<th>ส่วนสูง</th>
		<th>BMI</th>
	</tr>
	<?foreach($bmis as $row):?>
	<tr>
		<td><?=mysql_to_th($row->created)?></td>
		<td><?=$row->age?></td>
		<td><?=$row->weight?></td>
		<td><?=$row->height?></td>
		<td><?=number_format($row->weight/(($row->height/100)*($row->height/100)),2)?></td>
	</tr>
	<?endforeach;?>
</table>
