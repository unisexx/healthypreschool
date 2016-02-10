<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ห้องเรียน</li>
</ul>

<h1>ห้องเรียนทั้งหมด</h1>

<form id="search_report" method="get" action="classrooms/classroom_teacher">
	<div>
		<span>ปีการศึกษา</span>
			<?
				$sql = "select DISTINCT(`year`) FROM classroom_teachers where user_id = ".user_login()->id;
				$years = $this->db->query($sql)->result();
			?>
			<select name="year" class="span2">
				<option value="">--- เลือกปี ---</option>
				<?foreach($years as $item):?>
				<option value="<?=$item->year?>" <?if(@$_GET['year'] == $item->year){echo "selected";}?>><?=$item->year?></option>
				<?endforeach;?>
			</select>
	</div>
	<div>
		<span>ชื่อห้องเรียน</span>
		<input type="text" name="room_name" value="<?=@$_GET['room_name']?>" class="span4">
	</div>
	<input type="hidden" value="1" name='search'>
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</form>

<!-- <div style="float:right; padding:10px 0;"><a href="classrooms/form?nursery_id=<?=$_GET['nursery_id']?>"><div class="btn btn-primary">เพิ่มห้องเรียน</div></a></div> -->
  
<table class="table table-striped table-bordered">
	<tr>
		<th class="span1">ลำดับ</td>
		<th>ปีการศึกษา</th>
		<th>ชื่อห้องเรียน</th>
		<th>จำนวนเด็ก</th>
		<!-- <th class="span2">จัดการ</th> -->
	</tr>
	<?foreach($classes as $key=>$class):?>
	<tr>
		<td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
		<td><?=$class->year?></td>
		<td><?=$class->room_name?></td>
		<!-- <td><a href="classrooms/view/<?=$class->id?>"><?=$class->room_name?></a></td> -->
		<td><?=$class->children_count?></td>
		<!-- <td>
			<a href="classrooms/form/<?=$class->id?>?nursery_id=<?=$_GET['nursery_id']?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td> -->
	</tr>
	<?endforeach;?>
</table>
<?=$pagination;?>