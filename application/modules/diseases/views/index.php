<?
	$month_th = array( 1 =>'ม.ค.',2 => 'ก.พ.',3=>'มี.ค.',4=>'เม.ย',5=>'พ.ค.',6=>'มิ.ย',7=>'ก.ค.',8=>'ส.ค.',9=>'ก.ย.',10=>'ต.ค.',11=>'พ.ย.',12=>'ธ.ค.');
?>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">แบบคัดกรองโรค</li>
</ul>

<h1>แบบคัดกรองโรค</h1>

<div style="float:right; padding:10px 0;"><a href="diseases/form?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=date("m")?>&year=<?=date("Y")+543?>"><div class="btn">เพิ่มรายการ</div></a></div>
<table class="table">
	<tr>
		<th>ประจำเดือน / ปี	</th>
		<th>ห้องเรียน / ชั้นเรียน</th>
		<th>ครู / ผู้ดูแลเด็ก</th>
		<th>บันทึกล่าสุด</th>
		<th>ผู้บันทึก</th>
		<th>จัดการ</th>
	</tr>
	<? foreach($diseases as $row):?>
	<tr>
		<td><?=$month_th[$row->month]?> / <?=$row->year?></td>
		<td><?=$row->room_name?></td>
		<td><?=$row->teacher_name?></td>
		<td>
			<?
				$d = new Disease();
				$d->query("select max(created) created from diseases where year=".$row->year." and month = ".$row->month." and classroom_id = ".$row->classroom_id);
				echo mysql_to_th($d->created);
			?>
		</td>
		<td><?=get_user_name($row->user_id)?></td>
		<td>
			<a href="diseases/form?nursery_id=<?=$row->nursery_id?>&classroom_id=<?=$row->classroom_id?>&month=<?=$row->month?>&year=<?=$row->year?>" class="btn btn-mini">แก้ไข</a>
			<a href="diseases/delete?nursery_id=<?=$row->nursery_id?>&classroom_id=<?=$row->classroom_id?>&month=<?=$row->month?>&year=<?=$row->year?>" class="btn btn-mini" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td>
	</tr>
	<? endforeach;?>
</table>
