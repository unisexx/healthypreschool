<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="classrooms">ห้องเรียน / ชั้นเรียน และเด็ก</a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<h1>ห้องเรียน / ชั้นเรียน และเด็ก (เพิ่ม / แก้ไข)</h1>
<br>
<div class="row">
	<div class="span12">
		<form action="classrooms/save" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ชื่อห้องเรียน / ชั้นเรียน <span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="room_name" value="<?=$classroom->room_name?>" placeholder="ชื่อห้องเรียน">
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">ครูประจำชั้น / ครูผู้ดูแลเด็ก <span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="name" value="<?=$classroom->user_id == ''? user_login()->name : $classroom->user->name ;?>" placeholder="ชื่อ - นามสกุล" readonly> <!-- <button class="btn btn-small">ค้นหา</button> -->
		          <input type="hidden" name="user_id" value="<?=$classroom->user_id == ''? user_login()->id : $classroom->user_id ;?>">
		        </div>
		    </div>
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="id" value="<?=$classroom->id?>">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                  <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
		</form>
		
		<?if($classroom->id != ""):?>
		<div style="float:right; padding:10px 0;"><a href="classrooms/childform/<?=$classroom->id?>"><div class="btn btn-small">เพิ่มรายชื่อเด็ก</div></a></div>
		<table class="table table-striped">
			<tr>
				<th>ลำดับ</th>
				<th>ชื่อ - สกุล เด็ก</th>
				<th>อายุ (ปี)</th>
				<th>น้ำหนัก (กก) / ส่วนสูง (ซม)</th>
				<th>ดัชนีมวลกาย (BMI)</th>
				<th>จัดการ</th>
			</tr>
			<?foreach($childs as $key=>$row):?>
			<tr>
				<td><?=$key+1?></td>
				<td><?=$row->title?> <?=$row->child_name?></td>
				<td><?=$row->age?></td>
				<td><?=$row->weight?> / <?=$row->height?></td>
				<td>
					<?=number_format($row->weight/(($row->height/100)*($row->height/100)),2)?>
				</td>
				<td>
					<a href="classrooms/childform/<?=$classroom->id?>/<?=$row->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        		<a href="classrooms/childdelete/<?=$classroom->id?>/<?=$row->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
				</td>
			</tr>
			<?endforeach;?>
		</table>
		<?endif;?>
	</div>
</div>