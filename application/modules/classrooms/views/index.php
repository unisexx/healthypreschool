<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ห้องเรียน</li>
</ul>

<h1>ห้องเรียนทั้งหมด</h1>

<div style="float:right; padding:10px 0;"><a href="classrooms/form?nursery_id=<?=$_GET['nursery_id']?>"><div class="btn btn-primary">เพิ่มห้องเรียน</div></a></div>
  
<table class="table table-striped table-bordered">
	<tr>
		<th class="span1">ลำดับ</td>
		<th>ชื่อห้องเรียน</th>
		<th>รายละเอียด</th>
		<th class="span2">จัดการ</th>
	</tr>
	<?foreach($classes as $key=>$class):?>
	<tr>
		<td><?=($key+1)+$classes->paged->current_row?></td>
		<td><a href="classrooms/view/<?=$class->id?>"><?=$class->room_name?></a></td>
		<td>
			<?
				$sql = "SELECT
									year
								FROM
									classroom_teachers
								WHERE
									classroom_id = ".$class->id."
								UNION
									SELECT
										YEAR
									FROM
										classroom_childrens
									WHERE
										classroom_id = ".$class->id."
									ORDER BY
										YEAR DESC ";
				$years = $this->db->query($sql)->result_array();
			?>
			<?foreach($years as $row):?>
				<div>
				- ปีการศึกษา <?=$row['year']?>, 
				  ครู <?=$this->db->query("SELECT id FROM classroom_teachers where classroom_id = ".$class->id." and year = ".$row['year'])->num_rows();?> คน, 
				  นักเรียน <?=$this->db->query("SELECT id FROM classroom_childrens where classroom_id = ".$class->id." and year = ".$row['year'])->num_rows();?> คน
				</div> 
			<?endforeach;?>
		</td>
		<td>
			<a href="classrooms/form/<?=$class->id?>?nursery_id=<?=$_GET['nursery_id']?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        <!-- <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a> -->
		</td>
	</tr>
	<?endforeach;?>
</table>
<?=$classes->pagination();?>
