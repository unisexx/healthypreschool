<?
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename='ข้อมูลจำนวนและร้อยละรายงานแบบคัดกรองโรค.xls'");
?>
<style>
.num {
  mso-number-format:General;
}
.text{
  mso-number-format:"\@";/*force text*/
}
tr.subheader{font-weight:bold;background:#f1f1f1;}
</style>



<h3>รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค</h3>


<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>



<?
//-------------------------------------------- search condition --------------------------------
$condition = "";
if(@$_GET['classroom_id']!=""){
	@$condition.=" and d.classroom_id = ".$_GET['classroom_id'];
}elseif(@$_GET['nursery_id']!=""){
	@$condition.=" and d.nursery_id = ".$_GET['nursery_id'];
}elseif(@$_GET['district_id']!=""){
	@$condition.=" and n.district_id = ".$_GET['district_id'];
}elseif(@$_GET['amphur_id']!=""){
	@$condition.=" and n.amphur_id = ".$_GET['amphur_id'];
}elseif(@$_GET['province_id']!=""){
	@$condition.=" and area_provinces.province_id = ".$_GET['province_id'];
}elseif(@$_GET['area_id']!=""){
	@$condition.=" and area_provinces.area_id = ".$_GET['area_id'];
}

// วันที่เริ่ม - วันที่สิ้นสุด
if(@$_GET['start_date'] and @$_GET['end_date']){
	$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
	$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	$condition .= " and d.start_date between ".$start_date." and ".$end_date;
}
if(@$_GET['start_date'] and @empty($_GET['end_date'])){
	$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
	$condition .= " and d.start_date >= ".$start_date;
}
if(@$_GET['end_date'] and @empty($_GET['start_date'])){
	$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	$condition .= " and d.start_date >= ".$end_date;
}
// ปีที่คัดกรอง
if(@$_GET['year']){
	$condition .= " and d.year = ".$_GET['year'];
}
// เดือนที่คัดกรอง
if(@$_GET['month']){
	$condition .= " and d.month = ".$_GET['month'];
}

//-------------------------------------------- sql select join template --------------------------------
$sql_tempate = " SELECT
								Count(d.id)
								FROM
								diseases AS d
								INNER JOIN nurseries AS n ON d.nursery_id = n.id
								INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
								INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
								INNER JOIN area_provinces ON n.area_province_id = area_provinces.area_province_id";

//-------------------------------------------- เพศ --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		childrens.title = 'ด.ช.' ".@$condition."
	) male,
	(
		".$sql_tempate."
		WHERE
		childrens.title = 'ด.ญ.' ".@$condition."
	) female";

$sex = new Disease();
$sex->query($sql);
$sex_total = $sex->male + $sex->female;

//-------------------------------------------- อายุ --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 0 ".@$condition."
	) year_0,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 1 ".@$condition."
	) year_1,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 2 ".@$condition."
	) year_2,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 3 ".@$condition."
	) year_3,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 4 ".@$condition."
	) year_4,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 5 ".@$condition."
	) year_5,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 6 ".@$condition."
	) year_6,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 7 ".@$condition."
	) year_7";

$age = new Disease();
$age->query($sql);
$age_total = $age->year_0 + $age->year_1 + $age->year_2 + $age->year_3 + $age->year_4 + $age->year_5 + $age->year_6 + $age->year_7;

//-------------------------------------------- โรค --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'C' ".@$condition."
	) disease_1,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'H' ".@$condition."
	) disease_2,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'D' ".@$condition."
	) disease_3,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'F' ".@$condition."
	) disease_4,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'R' ".@$condition."
	) disease_5,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'O' ".@$condition."
	) disease_6";

	$disease = new Disease();
	$disease->query($sql);
	$disease_total = $disease->disease_1 + $disease->disease_2 + $disease->disease_3 + $disease->disease_4 + $disease->disease_5 + $disease->disease_6;

//-------------------------------------------- สถานะเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' ".@$condition."
	) sick_status_1,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' ".@$condition."
	) sick_status_2";

$sick_status = new Disease();
$sick_status->query($sql);
$sick_status_total = $sick_status->sick_status_1 + $sick_status->sick_status_2;

//-------------------------------------------- การแยกเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c2 = '0' ".@$condition."
	) separate_1,
	(
		".$sql_tempate."
		WHERE
		d.c2 = '1' ".@$condition."
	) separate_2,
	(
		".$sql_tempate."
		WHERE
		d.c2 = '2' ".@$condition."
	) separate_3";

$separate = new Disease();
$separate->query($sql);
$separate_total = $separate->separate_1 + $separate->separate_2 + $separate->separate_3;

//-------------------------------------------- กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c5 = '*' ".@$condition."
	) same_1,
	(
		".$sql_tempate."
		WHERE
		d.c5 = '' ".@$condition."
	) same_2";

$same = new Disease();
$same->query($sql);
$same_total = $same->same_1 + $same->same_2;
?>

<br>
<table class="table">
	<tr>
		<th>ข้อมูลจำนวนและร้อยละรายงานแบบคัดกรองโรค <i class="fa fa-file-excel-o"></i></th>
		<th>จำนวน (N=)</th>
		<th>ร้อยละ</th>
	</tr>
	<tr class="subheader">
		<td colspan="3">เพศ</td>
	</tr>
	<tr>
		<td>- ชาย</td>
		<td><?=$sex->male?></td>
		<td><?=convert_2_percent($sex->male,$sex_total)?></td>
	</tr>
	<tr>
		<td>- หญิง</td>
		<td><?=$sex->female?></td>
		<td><?=convert_2_percent($sex->female,$sex_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">กลุ่มอายุ</td>
	</tr>
	<tr>
		<td class="text">- ต่ำกว่า 1 ปี</td>
		<td><?=$age->year_0?></td>
		<td><?=convert_2_percent($age->year_0,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 1 ปี</td>
		<td><?=$age->year_1?></td>
		<td><?=convert_2_percent($age->year_1,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 2 ปี</td>
		<td><?=$age->year_2?></td>
		<td><?=convert_2_percent($age->year_2,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 3 ปี</td>
		<td><?=$age->year_3?></td>
		<td><?=convert_2_percent($age->year_3,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 4 ปี</td>
		<td><?=$age->year_4?></td>
		<td><?=convert_2_percent($age->year_4,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 5 ปี</td>
		<td><?=$age->year_5?></td>
		<td><?=convert_2_percent($age->year_5,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 6 ปี</td>
		<td><?=$age->year_6?></td>
		<td><?=convert_2_percent($age->year_6,$age_total)?></td>
	</tr>
	<tr>
		<td class="text">- 7 ปี</td>
		<td><?=$age->year_7?></td>
		<td><?=convert_2_percent($age->year_7,$age_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">แจกแจงตามโรค</td>
	</tr>
	<tr>
		<td>- หวัด</td>
		<td><?=$disease->disease_1?></td>
		<td><?=convert_2_percent($disease->disease_1,$disease_total)?></td>
	</tr>
	<tr>
		<td>- มือ เท้า ปาก</td>
		<td><?=$disease->disease_2?></td>
		<td><?=convert_2_percent($disease->disease_2,$disease_total)?></td>
	</tr>
	<tr>
		<td>- อุจจาระร่วง</td>
		<td><?=$disease->disease_3?></td>
		<td><?=convert_2_percent($disease->disease_3,$disease_total)?></td>
	</tr>
	<tr>
		<td>- ไข้</td>
		<td><?=$disease->disease_4?></td>
		<td><?=convert_2_percent($disease->disease_4,$disease_total)?></td>
	</tr>
	<tr>
		<td>- ไข้ออกผื่น</td>
		<td><?=$disease->disease_5?></td>
		<td><?=convert_2_percent($disease->disease_5,$disease_total)?></td>
	</tr>
	<tr>
		<td>- อื่นๆ</td>
		<td><?=$disease->disease_6?></td>
		<td><?=convert_2_percent($disease->disease_6,$disease_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">สถานะเด็กป่วย</td>
	</tr>
	<tr>
		<td>- มาเรียน</td>
		<td><?=$sick_status->sick_status_1?></td>
		<td><?=convert_2_percent($sick_status->sick_status_1,$sick_status_total)?></td>
	</tr>
	<tr>
		<td>- หยุดเรียน</td>
		<td><?=$sick_status->sick_status_2?></td>
		<td><?=convert_2_percent($sick_status->sick_status_2,$sick_status_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">การแยกเด็กป่วย</td>
	</tr>
	<tr>
		<td>- ไม่มีการแยกนอนแยกเล่น</td>
		<td><?=$separate->separate_1?></td>
		<td><?=convert_2_percent($separate->separate_1,$separate_total)?></td>
	</tr>
	<tr>
		<td>- แยกนอน</td>
		<td><?=$separate->separate_2?></td>
		<td><?=convert_2_percent($separate->separate_2,$separate_total)?></td>
	</tr>
	<tr>
		<td>- แยกเล่น</td>
		<td><?=$separate->separate_3?></td>
		<td><?=convert_2_percent($separate->separate_3,$separate_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน</td>
	</tr>
	<tr>
		<td>- มี</td>
		<td><?=$same->same_1?></td>
		<td><?=convert_2_percent($same->same_1,$same_total)?></td>
	</tr>
	<tr>
		<td>- ไม่มี</td>
		<td><?=$same->same_2?></td>
		<td><?=convert_2_percent($same->same_2,$same_total)?></td>
	</tr>
</table>



<?endif;?>
