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
                <div class="controls">
                  <?php echo form_referer() ?>
                  <input type="hidden" name="nursery_id" value="<?=$classroom->nursery_id == ''? $_GET['nursery_id'] : $classroom->nursery_id ;?>">
                  <input type="hidden" name="id" value="<?=$classroom->id?>">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                  <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
		</form>
		
	</div>
</div>