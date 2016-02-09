<?
if($filetype == 'excel'){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$text.".xls");
}else{
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment; filename=".$text.".doc");
}
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<?
	// search condition
	$condition = "";
	if(@$_GET['year']!=""){
		@$condition.=" and v_nurseries.year = ".$_GET['year'];
	}
?>

<?=$text?>
<?php if(@$_GET['type'] == 1):?>
	<table class="table">
		<thead>
			<tr>
				<th></th>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($provinces as $province):?>
				<?php
						$sql = "SELECT
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.id = ".$province->id." ".@$condition."
										) nursery_all,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.id = ".$province->id." ".@$condition."
											AND v_nurseries.`status` = 1
										) nursery_pass,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.id = ".$province->id." ".@$condition."
											AND v_nurseries.`status` = 0
										) nursery_not
									";
						$nursery = new V_nursery();
						$nursery->query($sql);
						$all = $nursery->nursery_all;
						$pass = $nursery->nursery_pass;
						$not = $nursery->nursery_not;
				?>
			<tr>
				<th><?=$province->name?></th>
				<td><?=$all?></td>
				<td><?=$not?></td>
				<td><?=$pass?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 2):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($amphurs as $amphur):?>
				<?php
						$sql = "SELECT
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.amphur_id= ".$amphur->id." ".@$condition."
										) nursery_all,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.amphur_id = ".$amphur->id." ".@$condition."
											AND v_nurseries.`status` = 1
										) nursery_pass,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.amphur_id = ".$amphur->id." ".@$condition."
											AND v_nurseries.`status` = 0
										) nursery_not
									";
						$nursery = new V_nursery();
						$nursery->query($sql);
						$all = $nursery->nursery_all;
						$pass = $nursery->nursery_pass;
						$not = $nursery->nursery_not;
				?>
			<tr>
				<th><?=$amphur->amphur_name?></th>
				<td><?=$all?></td>
				<td><?=$not?></td>
				<td><?=$pass?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 3):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($districts as $district):?>
				<?php
						$sql = "SELECT
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.district_id= ".$district->id." ".@$condition."
										) nursery_all,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.district_id = ".$district->id." ".@$condition."
											AND v_nurseries.`status` = 1
										) nursery_pass,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_nurseries.district_id = ".$district->id." ".@$condition."
											AND v_nurseries.`status` = 0
										) nursery_not
									";
						$nursery = new V_nursery();
						$nursery->query($sql);
						$all = $nursery->nursery_all;
						$pass = $nursery->nursery_pass;
						$not = $nursery->nursery_not;
				?>
			<tr>
				<th><?=$district->district_name?></th>
				<td><?=$all?></td>
				<td><?=$not?></td>
				<td><?=$pass?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 4):?>
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2"><?=$text?></div>
	<table class="table">
		<thead>
			<tr>
		        <th>ลำดับ</th>
		        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
		        <th>ที่อยู่</th>
		        <th>ปีที่เข้าร่วม</th>
		        <th>หัวหน้าศูนย์</th>
		        <th>สถานะ</th>
	        </tr>
		</thead>
		<tbody>
			<?php $i=(@$_GET['page'] > 1)? (((@$_GET['page'])* 20)-20)+1:1;?>
	        <?php foreach($nurseries as $key=>$nursery):?>
	        	<tr>
			        <td><?=$i?></td>
			        <td><?=$nursery->nursery_category->title?><?=$nursery->name?></td>
			        <td>ต.<?=$nursery->district->district_name?><br>อ.<?=$nursery->amphur->amphur_name?><br>จ.<?=$nursery->province->name?></td>
			        <td><?=$nursery->year?></td>
			        <td><?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?></td>
			        <td><?=($nursery->status == 0)?"เข้าร่วมโครงการ":"ผ่านเกณฑ์";?></td>
		        </tr>
		        <?php $i++;?>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else:?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
			</tr>
		</thead>
		<tbody>
			<?php foreach($areas as $area):?>
				<?php
						$sql = "SELECT
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.area_id = ".$area->id." ".@$condition."
										) nursery_all,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.area_id = ".$area->id." ".@$condition."
											AND v_nurseries.`status` = 1
										) nursery_pass,
										(
											SELECT
												count(v_nurseries.id)
											FROM
												v_nurseries
											INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
											WHERE
												v_provinces.area_id = ".$area->id." ".@$condition."
											AND v_nurseries.`status` = 0
										) nursery_not
									";
						$nursery = new V_nursery();
						$nursery->query($sql);
						$all = $nursery->nursery_all;
						$pass = $nursery->nursery_pass;
						$not = $nursery->nursery_not;
				?>
			<tr>
				<th><?=$area->area_name?></th>
				<td><?=$all?></td>
				<td><?=$not?></td>
				<td><?=$pass?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>