<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ตรวจสอบรายชื่อครู / เจ้าหน้าที่</li>
</ul>

<h1> ตรวจสอบรายชื่อครู / เจ้าหน้าที่</h1>

<form method="get" action="teachers">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('m_status',array('active'=>'เปิด','deactive'=>'ปิด'),@$_GET['m_status'],'class="span2"','--- สถานะ ---');?>
	<input type="text" name="name" value="<?=@$_GET['name']?>" placeholder="ค้นหาชื่อ">
	<input type="text" name="email" value="<?=@$_GET['email']?>" placeholder="ค้นหาอีเมล์">
	
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>

<div style="float:right; padding:10px 0;"><a href="teachers/form"><div class="btn">เพิ่มรายการ</div></a></div>
<table class="table">
	<tr>
		<th>ลำดับ</th>
		<th>สถานะ</th>
		<th>ชื่อ - สกุล ครู / ผู้ดูแลเด็ก</th>
		<th>อีเมล์ / เบอร์ติดต่อ</th>
		<th>จัดการ</th>
	</tr>
	<?foreach($teachers as $key=>$row):?>
	<tr>
		<td><?=($key+1)+$teachers->paged->current_row?></td>
		<td><?=($row->m_status == 'active')?'<div class="label label-info">เปิด</div>':'<div class="label">ปิด</div>';?></td>
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
