<?
	$diseasesArray = array(
	'C' => 'หวัด', 
	'H' => 'มือ เท้า ปาก', 
	'D' => 'อุจจาระร่วง',
	'F' => 'ไข้',
	'R' => 'ไข้ออกผื่น',
	'O' => 'อื่นๆ'
	);
	
	$divideArray = array(
	'0' => 'ไม่มีการแยกนอนแยกเล่น', 
	'1' => 'แยกนอน', 
	'2' => 'แยกเล่น'
	);
	
	$learnArray = array(
	'/' => 'มาเรียน', 
	'x' => 'หยุดเรียน'
	);
	
	$drugArray = array(
	'O' => 'ได้ยารักษามาจากบ้าน'
	);
	
	$homeArray = array(
	'*' => 'คนที่บ้านป่วยเป็นโรคเดียวกัน'
	);
	
?>

<h1>รายงานแบบคัดกรองโรค</h1>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>ชื่อ - นามสกุล</th>
			<!-- <th>ที่อยู่</th> -->
			<th>ห้องเรียน</th>
			<th>โรค</th>
			<!-- <th>การแยกเด็กป่วย</th>
			<th>มาเรียน</th>
			<th>ได้ยารักษามาจากบ้าน</th>
			<th>คนที่บ้านป่วยเป็นโรคเดียวกัน</th> -->
			<th>วันที่ป่วย</th>
	</thead>
	<tbody>
		<?
			$page = (isset($_GET['page']))? $_GET['page']:1;
  			$i=(isset($_GET['page']))? (($_GET['page'] -1)* 20)+1:1;
		?>
		<?foreach($diseases as $key=>$row):?>
		<tr>
			<td><?=$i?></td>
			<td><?=$row->title?> <?=$row->child_name?> (<?=$row->child_age_year?> ปี <?=$row->child_age_month?> เดือน)</td>
			<td><?=$row->room_name?></td>
			<td><?=@$diseasesArray[$row->c1] == "อื่นๆ" ? $row->other : @$diseasesArray[$row->c1] ;?></td>
			<!-- <td><?=@$divideArray[$row->c2]?></td>
			<td><?=@$learnArray[$row->c3]?></td>
			<td><?=@$drugArray[$row->c4]?></td>
			<td><?=@$homeArray[$row->c5]?></td> -->
			<!-- <td>
				<?=get_nursery_name($row->nursery_id)?><br>
				<?=($row->number != "")? $row->number.' ' : '' ;?>
				<?=($row->moo != "")? 'หมู่ '.$row->moo.' ' : '' ;?>
				<?=($row->district_name != "")? 'ตำบล '.$row->district_name.' ' : '' ;?>
				<?=($row->amphur_name != "")? 'อำเภอ '.$row->amphur_name.' ' : '' ;?><br>
				<?=($row->province_name != "")? $row->province_name.' ' : '' ;?>
				<?=($row->code != "")? $row->code.' ' : '' ;?>
			</td> -->
			<td><?=mysql_to_th($row->start_date)?> - <?=mysql_to_th($row->end_date)?></td>
		</tr>
		<?$i++;?>
		<?endforeach;?>
	</tbody>
</table>