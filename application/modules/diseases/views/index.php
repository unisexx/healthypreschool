<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">แบบคัดกรองโรค</li>
</ul>

<h1>แบบคัดกรองโรค</h1>

<div style="float:right; padding:10px 0;"><a href="diseases/form?nursery_id=<?=user_login()->nursery_id?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=date("m")?>&year=<?=date("Y")+543?>"><div class="btn">เพิ่มรายการ</div></a></div>
<table class="table">
	<tr>
		<th>ลำดับ</th>
		<th>ประจำเดือน / ปี	</th>
		<th>ห้องเรียน / ชั้นเรียน</th>
		<th>ชื่อศูนย์</th>
		<th>จัดการ</th>
	</tr>
	<?foreach($classes as $key=>$class):?>
	<tr>
		<td><?=($key+1)+$classes->paged->current_row?></td>
		<td><?=$class->room_name?></td>
		<td><?=$class->user->name?></td>
		<td><?=$class->classroom_detail->count()?></td>
		<td>
			<a href="classrooms/form/<?=$class->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td>
	</tr>
	<?endforeach;?>
</table>
<?=$classes->pagination();?>
