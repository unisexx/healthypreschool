<h1>ห้องเรียน / ชั้นเรียน และเด็ก (เพิ่ม / แก้ไข)</h1>
<br>
<div class="row">
	<div class="span9">
		<form action="classrooms/save" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ชื่อห้องเรียน / ชั้นเรียน <span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="room_name" id="inputname" placeholder="ชื่อห้องเรียน">
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">ครูประจำชั้น / ครูผู้ดูแลเด็ก <span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="name" id="inputname" placeholder="ชื่อ - นามสกุล">
		          <input type="hidden" name="user_id" value="">
		        </div>
		    </div>
		    <div class="control-group">
                <div class="controls">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                </div>
            </div>
		</form>
	</div>
</div>