<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<!-- load jQuery 1.4.2 -->
<script type="text/javascript" src="media/js/jquery-1.4.2.min.js"></script>

<link rel="stylesheet" href="media/js/date_input/date_input.css" type="text/css" media="screen">
<script type="text/javascript" src="media/js/date_input/jquery.date_input.min.js"></script>
<script type="text/javascript" src="media/js/date_input/jquery.date_input.th_TH.js"></script>
<script type="text/javascript">
var jQuery_1_4_2 = $.noConflict(true);
$(document).ready(function(){
jQuery_1_4_2("input.datepicker").date_input(); 
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="childrens">ตรวจสอบรายชื่อเด็ก / นักเรียน</a> <span class="divider">/</span></li>
  <li>ฟอร์มเด็ก</li>
</ul>

<h1>รายชื่อเด็ก (เพิ่ม / แก้ไข)</h1>
<br>
<div class="row">
	<div class="span12">
		<form action="childrens/save" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ห้องเรียน<span class="TxtRed">*</span></label>
		        <div class="controls">
		        	
		          <?if(user_login()->user_type_id == 1 || user_login()->user_type_id == 6 || user_login()->user_type_id == 7 || user_login()->user_type_id == 8):?>
		          	<?php echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.$_GET['nursery_id'].' order by room_name asc'),@$child->classroom_id,'','--- เลือกห้องเรียน ---')?>
		          <?elseif(user_login()->user_type_id == 9):?>
		          	<?php echo  form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.user_login()->nursery_id.' order by room_name asc'),@$child->classroom_id,'','--- เลือกห้องเรียน ---')?>
		          <?elseif(user_login()->user_type_id == 10):?>
		          	<?php echo  form_dropdown('classroom_id',get_option('id','room_name','classrooms','where user_id = '.user_login()->id.' order by room_name asc'),@$child->classroom_id,'','--- เลือกห้องเรียน ---')?>
		          <?endif;?>
		        </div>
		    </div>
			<div class="control-group">
		        <label class="control-label">คำนำหน้า<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <select name="title">
		          	<option value="ด.ช." <?=($child->title == 'ด.ช.')?'selected':'';?>>ด.ช.</option>
		          	<option value="ด.ญ." <?=($child->title == 'ด.ญ.')?'selected':'';?>>ด.ญ.</option>
		          </select>
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">ชื่อ - นามสกุลเด็ก<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="child_name" value="<?=$child->child_name?>">
		        </div>
		    </div>
		    <!-- <div class="control-group">
		        <label class="control-label">อายุ (ปี)<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="span1" type="text" name="age" value="<?=$child->age?>">
		        </div>
		    </div> -->
		    <div class="control-group">
			    <label class="control-label">วันเกิด<span class="TxtRed">*</span></label>
			    <div class="controls">
			      <input type="text" name="birth_date" value="<?php echo DB2Date($child->birth_date)?>" class="datepicker" />
			    </div>
			</div>
		    <!-- <div class="control-group">
		        <label class="control-label">น้ำหนัก (กก) / ส่วนสูง (ซม)<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="span1" type="text" name="weight" value="<?=$child->weight?>"> / 
		          <input class="span1" type="text" name="height" value="<?=$child->height?>">
		        </div>
		    </div> -->
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="id" value="<?=$child->id?>">
                  <input type="hidden" name="nursery_id" value="<?php echo user_login()->nursery_id ?>">
                  <input type="submit" class="btn btn-small btn-info" value="บันทึก">
                  <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
		</form>
	</div>
</div>