<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ห้องเรียน / ชั้นเรียน และเด็ก</li>
</ul>

<h1>ห้องเรียน / ชั้นเรียน และเด็ก</h1>

<div style="float:right; padding:10px 0;"><a href="classrooms/form"><div class="btn">เพิ่มห้องเรียน</div></a></div>
<table class="table">
	<tr>
		<th>ลำดับ</td>
		<th>ชื่อห้องเรียน / ชั้นเรียน</th>
		<th>ครูประจำชั้น / ครูผู้ดูแลเด็ก</th>
		<th>จำนวนเด็ก (คน)</th>
		<th>จัดการ</th>
	</tr>
	<?foreach($classes as $key=>$class):?>
	<tr>
		<td><?=($key+1)+$classes->paged->current_row?></td>
		<td><a href="childrens?classroom_id=<?=$class->id?>"><?=$class->room_name?></a></td>
		<td><?=$class->user->name?></td>
		<td><?=$class->classroom_detail->count()?></td>
		<td>
			<a href="classrooms/form/<?=$class->id?>" class='btn btn-mini btn-info'>ตรวจสอบ</a>
	        <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td>
	</tr>
	<?endforeach;?>
</table>
<?=$classes->pagination();?>
