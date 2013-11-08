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
					if($_GET['year'] == ""){
						$all = $province->nurseries->get()->result_count();
						$pass = $province->nurseries->where("status = 1")->get()->result_count();
						$not = $province->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $province->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $province->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $province->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$province->name?></th>
				<td><?=$all?></td>
				<td><?=$pass?></td>
				<td><?=$not?></td>
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
					if($_GET['year'] == ""){
						$all = $amphur->nurseries->get()->result_count();
						$pass = $amphur->nurseries->where("status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $amphur->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $amphur->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$amphur->amphur_name?></th>
				<td><?=$all?></td>
				<td><?=$pass?></td>
				<td><?=$not?></td>
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
					if($_GET['year'] == ""){
						$all = $district->nurseries->get()->result_count();
						$pass = $district->nurseries->where("status = 1")->get()->result_count();
						$not = $district->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $district->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $district->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $district->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$district->district_name?></th>
				<td><?=$all?></td>
				<td><?=$pass?></td>
				<td><?=$not?></td>
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
					if(@$_GET['year']){
						$all = $area->nurseries->where("year = ".@$_GET['year'])->get()->result_count();
						$pass = $area->nurseries->where("year = ".@$_GET['year']." and status = 1")->get()->result_count();
						$not = $area->nurseries->where("year = ".@$_GET['year']." and status = 0")->get()->result_count();
					}else{
						$all = $area->nurseries->get()->result_count();
						$pass = $area->nurseries->where("status = 1")->get()->result_count();
						$not = $area->nurseries->where("status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$area->area_name?></th>
				<td><?=$all?></td>
				<td><?=$pass?></td>
				<td><?=$not?></td>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>