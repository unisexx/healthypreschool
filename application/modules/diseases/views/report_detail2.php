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
	
	// ----- หัวข้อกราฟ -----
	@$_GET['year'] ? @$text .= "ปี".$_GET['year'] : '';
	//@$_GET['c1'] ? @$text .= "โรค".$diseasesArray[$_GET['c1']] : '';
	@$_GET['area_id'] ? @$text .= " (สคร.".$_GET['area_id'].")" : '';
	@$_GET['province_id'] ? @$text .= " (จังหวัด".get_province_name($_GET['province_id']).")" : '';
	@$_GET['amphur_id'] ? @$text .= " (อำเภอ".get_amphur_name($_GET['amphur_id']).")" : '';
	@$_GET['district_id'] ? @$text .= " (ตำบล".get_district_name($_GET['district_id']).")" : '';
	@$_GET['nursery_id'] ? @$text .= " (".get_nursery_name($_GET['nursery_id']).")" : '';
	//@$_GET['month'] ? @$text .= "เดือน".$_GET['month'] : '';
	//@$_GET['lowage'] != "" && $_GET['hiage'] != "" ? @$text .= "อายุระหว่าง ".$_GET['lowage']." ปี ถึง ".$_GET['hiage']." ปี" : '';
	
?>

<h1>รายงานแบบคัดกรองโรค <?=@$text?></h1>

<table class="table table-bordered table-striped">
	<thead>
		<tr>
			<th>ลำดับ</th>
			<th>ศูนย์เด็กเล็ก</th>
			<th>โรค</th>
			<th>จำนวนครั้งที่ป่วย</th>
			<th>ชาย</th>
			<th>หญิง</th>
		</tr>
	</thead>
	<tbody>
		<?
			$page = (isset($_GET['page']))? $_GET['page']:1;
  			$i=(isset($_GET['page']))? (($_GET['page'] -1)* 20)+1:1;
		?>
		<?foreach($diseases as $key=>$row):?>
		<tr>
			<td><?=$i?></td>
			<td><?=get_nursery_name($row->nursery_id)?></td>
			<td><?=$diseasesArray[$_GET['c1']]?></td>
			<td><?=$row->disease_total?></td>
			<td><?=$row->boy?></td>
			<td><?=$row->girl?></td>
		</tr>
		<?$i++;?>
		<?endforeach;?>
	</tbody>
</table>