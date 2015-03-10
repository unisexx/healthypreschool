<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><?=get_nursery_name($nursery_id)?> / ห้องเรียน / ชั้นเรียน และเด็ก</li>
</ul>

<h1>ห้องเรียน / ชั้นเรียน และเด็ก</h1>

<!-- <div style="float:right; padding:10px 0;"><a href="classrooms/form"><div class="btn">เพิ่มรายการ</div></a></div> -->
<table class="table table-striped table-bordered">
	<tr>
		<th>ลำดับ</td>
		<th>ชื่อห้องเรียน / ชั้นเรียน</th>
		<th>ครูประจำชั้น / ครูผู้ดูแลเด็ก</th>
		<th>จำนวนเด็ก (คน)</th>
		<!-- <td>จัดการ</td> -->
	</tr>
	<?foreach($classes as $key=>$class):?>
	<tr>
		<td><?=($key+1)+$classes->paged->current_row?></td>
		<td><?=$class->room_name?></td>
		<td><?=$class->user->name?></td>
		<td><?=$class->classroom_detail->count()?></td>
		<!-- <td>
			<a href="classrooms/form/<?=$class->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td> -->
	</tr>
	<?endforeach;?>
</table>
<?=$classes->pagination();?>
