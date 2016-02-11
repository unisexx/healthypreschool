<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ตรวจสอบรายชื่อครู / เจ้าหน้าที่</li>
</ul>

<h1> ตรวจสอบรายชื่อครู / เจ้าหน้าที่</h1>

<form method="get" action="teachers">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('m_status',array('active'=>'เปิด','deactive'=>'ปิด'),@$_GET['m_status'],'class="span2"','--- สถานะ ---');?>
	<input type="text" name="name" value="<?=@$_GET['name']?>" placeholder="ค้นหาชื่อหรืออีเมล์" class="span4">
	<input type="hidden" name="nursery_id" value="<?=$_GET['nursery_id']?>">
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>

<!-- <div style="float:right; padding:10px 0;"><a href="teachers/form?nursery_id=<?=$_GET['nursery_id']?>"><div class="btn">เพิ่มรายการ</div></a></div> -->
<table class="table table-striped table-bordered">
	<tr>
		<th>ลำดับ</th>
		<th>สถานะ</th>
		<th>ชื่อ - สกุล</th>
		<th>อีเมล์</th>
		<th>โทรศัพท์</th>
		<th>ห้องเรียนที่รับผิดชอบ</th>
		<th>จัดการ</th>
	</tr>
	<?foreach($teachers as $key=>$row):?>
	<tr>
		<td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
		<td><?=($row->m_status == 'active')?'<div class="label label-info">เปิด</div>':'<div class="label">ปิด</div>';?></td>
		<td><?=$row->name?></td>
		<td><?=$row->email?></td>
		<td><?=$row->phone?></td>
		<td>
			<?
				$sql = "SELECT
							*, (
								SELECT
									GROUP_CONCAT(classroom_id)
								FROM
									classroom_teachers
								WHERE
									YEAR = current_year
								AND user_id = teacher_id		
							) class_room_id,
							(
								SELECT
									GROUP_CONCAT(room_name)
								FROM
									classroom_teachers
								LEFT JOIN classrooms ON classroom_teachers.classroom_id = classrooms.id
								WHERE
									YEAR = current_year
								AND classroom_teachers.user_id = teacher_id		
							) class_room_name
						FROM
							(
								SELECT
									users.id teacher_id,
									Max(classroom_teachers.`year`) current_year
								FROM
									classrooms
								INNER JOIN classroom_teachers ON classroom_teachers.classroom_id = classrooms.id
								INNER JOIN users ON users.id = classroom_teachers.user_id
								GROUP BY
									users.id
								ORDER BY
									users.`name` ASC
							) tmax
						WHERE
						teacher_id = ".$row->id."
						;";
				$rs = $this->db->query($sql)->result();
				// print_r($rs);
				echo @$rs[0]->class_room_name;
			?>
		</td>
		<td>
			<a href="teachers/form/<?=$row->id?>?nursery_id=<?=$_GET['nursery_id']?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <!-- <a href="teachers/delete/<?=$row->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a> -->
		</td>
	</tr>
	<?endforeach;?>
</table>
<?=$pagination;?>
