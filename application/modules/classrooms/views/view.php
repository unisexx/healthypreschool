<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="classrooms?nursery_id=<?=$rs->nursery_id?>">ห้องเรียน</a> <span class="divider">/</span></li>
  <li class="active"><?=$rs->room_name?></li>
</ul>

<h1>ห้องเรียน : <?=$rs->room_name?></h1>
<br>
<div class="row">
	<div class="span12">
		<div style="float:right; padding:10px 0;"><a href="classrooms/form_detail/<?=$rs->id?>"><div class="btn btn-primary">เพิ่มปีการศึกษา</div></a></div>
		<table class="table table-bordered table-striped">
			<tr>
				<th>ปีการศึกษา</th>
				<th>ครูประจำชั้น</th>
				<th>เด็ก</th>
				<th>จัดการ</th>
			</tr>
			<?foreach($years as $row):?>
			<tr>
				<td><?=$row->year?></td>
				<td><?=$this->db->query("SELECT id FROM classroom_teachers where classroom_id = ".$rs->id." and year = ".$row->year)->num_rows();?></td>
				<td><?=$this->db->query("SELECT id FROM classroom_childrens where classroom_id = ".$rs->id." and year = ".$row->year)->num_rows();?></td>
				<td>
					<a href="classrooms/form_detail/<?=$rs->id?>/<?=$row->year?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        		<!-- <a href="classrooms/delete/<?=$class->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a> -->
				</td>
			</tr>
			<?endforeach;?>
		</table>
	</div>
</div>