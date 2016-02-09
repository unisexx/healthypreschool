<?
ini_set('memory_limit', '-1');
if($filetype == 'excel'){
	header("Content-type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=รายละเอียดศูนย์เด็กเล็ก".@$district.@$amphur.@$province.@$area.@$year.".xls");
}else{
	header("Content-type: application/vnd.ms-word");
	header("Content-Disposition: attachment; filename=รายละเอียดศูนย์เด็กเล็ก".@$district.@$amphur.@$province.@$area.@$year.".doc");
}
?>
<h3>รายละเอียดศูนย์เด็กเล็ก <?=@$district?> <?=@$amphur?> <?=@$province?> <?=@$area?> <?=@$year?></h3>
</div>
	<table class="table" border="1">
	<thead>
		<tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
	        <th colspan="3">ที่อยู่</th>
	        <th>ปีที่เข้าร่วม</th>
	        <th>หัวหน้าศูนย์</th>
	        <th>สถานะ</th>
        </tr>
	</thead>
	<tbody>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
		        <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
		        <td><?//=$nursery->nursery_category->title?><?=$nursery->name?></td>
		        <td>ต.<?=$nursery->district_name?></td>
		        <td>อ.<?=$nursery->amphur_name?></td>
		        <td>จ.<?=$nursery->province_name?></td>
		        <td><?=$nursery->year?></td>
		        <td><?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?></td>
		        <td><?=($nursery->status == 0)?"เข้าร่วมโครงการ":"ผ่านเกณฑ์";?></td>
	        </tr>
		<?php endforeach;?>
	</tbody>
</table>