<?
if($filetype == 'excel'){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=".$text.".xls");
}else{
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment; filename=".$text.".doc");
}
?>

<?php 
	$diseasesArray = array(
	'หวัด' => 'C', 
	'มือ เท้า ปาก' => 'H', 
	'อุจจาระร่วง' => 'D',
	'ไข้' => 'F',
	'ไข้ออกผื่น' => 'R',
	'อื่นๆ' => 'O'
	);
	
	
	if(@$_GET['sex'] == "ด.ช."){
		$sex = 'จำแนกตามเพศชาย';
	}elseif(@$_GET['sex'] == "ด.ญ."){
		$sex = 'จำแนกตามเพศหญิง';
	}
	
	$arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?=$text?>
<?php if(@$_GET['type'] == 1):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($provinces as $province):?>
			<tr>
				<th>
					<?=$province->name?>
				</th>
				
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$province->id){ @$condition.=" and n.province_id = ".$province->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 2):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($amphurs as $amphur):?>
			<tr>
				<th>
					<?=$amphur->amphur_name?>
				</th>
				
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$amphur->id){ @$condition.=" and n.amphur_id = ".$amphur->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
				
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 3):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($districts as $district):?>
			<tr>
				<th>
					<?=$district->district_name?>
				</th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$district->id){ @$condition.=" and n.district_id = ".$district->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<!-- <th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 4):?>
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2"><?=$text?></div>
	<table id="datatable" class="table">
		<thead>
			<tr>
		        <th>ศูนย์เด็กเล็กปลอดโรค</th>
		        <? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
	        </tr>
		</thead>
		<tbody>
			<?php foreach($nurseries as $nursery):?>
			<tr>
				<th>
					<?=$nursery->name?>
				</th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$nursery->id){ @$condition.=" and n.id = ".$nursery->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<!-- <th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php else:?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($areas as $area):?>
			<tr>
				<th><?=$area->area_name?></th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$area->id){ @$condition.=" and n.area_id = ".$area->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php endif;?>