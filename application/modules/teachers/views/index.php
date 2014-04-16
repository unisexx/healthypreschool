<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ครู / ผู้ดูแลเด็ก</li>
</ul>

<h1><?=user_login()->nursery->nursery_category->title?><?=user_login()->nursery->name?> (ครู / ผู้ดูแลเด็ก)</h1>

<div style="float:right; padding:10px 0;"><a href="teachers/form"><div class="btn">เพิ่มรายการ</div></a></div>
<table class="table">
	<tr>
		<td>ลำดับ</td>
		<td>ชื่อ - สกุล ครู / ผู้ดูแลเด็ก</td>
		<td>อีเมล์ / เบอร์ติดต่อ</td>
		<td>จัดการ</td>
	</tr>
	<?foreach($teachers as $key=>$row):?>
	<tr>
		<td><?=($key+1)+$teachers->paged->current_row?></td>
		<td><?=$row->name?></td>
		<td><?=$row->email?> / <?=$row->phone?></td>
		<td>
			<a href="teachers/form/<?=$row->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <a href="teachers/delete/<?=$row->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td>
	</tr>
	<?endforeach;?>
</table>
<?=$teachers->pagination();?>
