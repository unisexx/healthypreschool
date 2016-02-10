<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
/*.date_selector{top:150px !important;left:420px !important;}*/
</style>
<!-- <script type="text/javascript" src="media/js/jquery-1.4.2.min.js"></script>
<link rel="stylesheet" href="media/js/date_input/date_input.css" type="text/css" media="screen">
<script type="text/javascript" src="media/js/date_input/jquery.date_input.min.js"></script>
<script type="text/javascript" src="media/js/date_input/jquery.date_input.th_TH.js"></script>
<script type="text/javascript">
var jQuery_1_4_2 = $.noConflict(true);
$(document).ready(function(){
jQuery_1_4_2("input.datepicker").date_input(); 
});
</script> -->


<script>
$(document).ready(function(){
	$("#classroom_detail_form").validate({
	    rules: 
	    {
	    	year:{required: true},
	    },
	    messages:
	    {
	    	year:{required: "กรุณาระบุปีการศึกษา"},
	    }
    });
    
    $('.deleteTeacher').live('click',function(){
	    if (!confirm('ยืนยันการลบ?')) return false;
		    var $this = $(this);
		    $.post('classrooms/ajax_delete_teacher',{
				'id' : $this.closest('td').find('.teacher_detail_id').val()
			},function(data){
				$this.closest('tr').fadeOut(300, function() { $(this).remove(); });
			});
		    
		    return false;
	});
	
	$('.deleteChildren').live('click',function(){
	    if (!confirm('คำเตือน!!! หากทำการลบรายชื่อเด็ก จะทำให้ข้อมูลทุกอย่างที่เคยบันทึกของเด็กคนนี้ถูกลบไปด้วย ยืนยันการลบ?')) return false;
		    var $this = $(this);
		    $.post('classrooms/ajax_delete_children',{
				'id' : $this.closest('td').find('.children_detail_id').val()
			},function(data){
				$this.closest('tr').fadeOut(300, function() { $(this).remove(); });
			});
		    
		    return false;
	});
	
	$('.delButton').live('click',function(){
		$(this).closest('tr').fadeOut(300, function() { $(this).remove(); });
	    return false;
	});
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="classrooms?nursery_id=<?=$classroom->nursery_id?>">ห้องเรียน</a> <span class="divider">/</span></li>
  <li><a href="classrooms/view/<?=$classroom->id?>"><?=$classroom->room_name?></a> <span class="divider">/</span></li>
  <li class="active">ฟอร์ม</li>
</ul>

<h1>ห้องเรียน : <?=$classroom->room_name?></h1>
<br>
<div class="row">
	<div class="span12">
		<form id="classroom_detail_form" action="classrooms/form_detail_save" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ปีการศึกษา<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="number" name="year" value="<?=@$year?>" placeholder="">
		        </div>
		    </div>
		    
		    <div style="float:right; padding:10px 0;"><a href="#teacherModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มครูประจำชั้นในห้องเรียน</div></a></div>
		    <table id="teacherTable" class="table table-bordered table-striped">
		    	<tr>
			    	<th>ครูประจำชั้น</th>
			    	<th class="span1">จัดการ</th>
			    </tr>
			    <?if(isset($teachers)):?>
			    <?foreach($teachers as $row):?>
			    <tr>
			    	<td><?=$row->user->name?></td>
			    	<td>
			    		<input class="teacher_detail_id" type="hidden" name="classroom_teacher_detail_id[]" value="<?=$row->id?>">
			    		<input type="hidden" name="teacherID[]" value="<?=$row->user_id?>">
			    		<button class="btn btn-mini btn-danger deleteTeacher">ลบ</button>
			    	</td>
			    </tr>
			    <?endforeach;?>
			    <?endif;?>
		    </table>
		    
		    <div style="float:right; padding:10px 0;"><a href="#childrenModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มเด็กนักเรียนในห้องเรียน</div></a></div>
		    <table id="childrenTable"  class="table table-bordered table-striped">
		    	<tr>
			    	<th>เด็กนักเรียน</th>
			    	<th>วันเกิด</th>
			    	<th class="span1">จัดการ</th>
		    	</tr>
		    	<?if(isset($childrens)):?>
		    	<?foreach($childrens as $row):?>
			    <tr>
			    	<td><?=$row->children->title?> <?=$row->children->name?></td>
			    	<td><?=mysql_to_th($row->children->birth_date)?></td>
			    	<td>
			    		<input class="children_detail_id"  type="hidden" name="classroom_children_detail_id[]" value="<?=$row->id?>">
			    		<input type="hidden" name="childrenID[]" value="<?=$row->children_id?>">
			    		<button class="btn btn-mini btn-danger deleteChildren">ลบ</button>
			    	</td>
			    </tr>
			    <?endforeach;?>
			    <?endif;?>
		    </table>
		    
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="classroom_id" value="<?=$classroom->id?>">
                  <input type="hidden" name="nursery_id" value="<?=$v_nursery->id?>">
                  <input type="hidden" name="amphur_id" value="<?=$v_nursery->amphur_id?>">
                  <input type="hidden" name="district_id" value="<?=$v_nursery->district_id?>">
                  <input type="hidden" name="area_province_id" value="<?=$v_nursery->area_province_id?>">
                  <input type="submit" class="btn btn-primary" value="บันทึก">
                  <input type="button" class="btn btn-danger" value="ย้อนกลับ" onclick="history.back(-1)">
                </div>
            </div>
		</form>
	</div>
</div>


<!-- Modal -->
<style>
	.modal.large {
	    width: 80%; /* respsonsive width */
	    height:550px;
	    margin-left:-40%; /* width/2) */ 
	}
	.modal-body {max-height:500px!important;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	//------------------- Teacher ---------------------
	$('.searchTeacher').click(function(){
		$.get('home/ajax_get_teacher',{
			'name' : $(this).prev('input[name=search]').val()
		},function(data){
			$('#teacherData').html(data);
		});
	});
	
	$('.selectTeacher').live("click",function(){
		var teacherID = $(this).closest('td').find('input[name=teacherId]').val();
		var teacherName = $(this).closest('td').find('input[name=teacherName]').val();
		$('#teacherTable tr:last').after('<tr><td>'+teacherName+'</td><td><input type="hidden" name="teacherID[]" value="'+teacherID+'"><button class="btn btn-mini btn-danger delButton">ลบ</button></td></tr>');
	});
	
	//------------------- Children ---------------------
	$('.searchChildren').click(function(){
		$.get('home/ajax_get_children',{
			'name' : $(this).prev('input[name=search]').val()
		},function(data){
			$('#childrenData').html(data);
		});
	});
	
	$('.selectChildren').live("click",function(){
		var childrenId = $(this).closest('td').find('input[name=childrenId]').val();
		var childrenName = $(this).closest('td').find('input[name=childrenName]').val();
		var childrenBirth = $(this).closest('td').find('input[name=childrenBirth]').val();
		$('#childrenTable tr:last').after('<tr><td>'+childrenName+'</td><td>'+childrenBirth+'</td><td><input type="hidden" name="childrenID[]" value="'+childrenId+'"><button class="btn btn-mini btn-danger delButton">ลบ</button></td></tr>');
	});
	
	//------------------- Teacher Form ---------------------
	$('.addTeacherForm').click(function(){
		var TeacherForm = $("#teacherFormBlock").clone();
		$("#teacherData").html(TeacherForm);
	});
	
	//------------------- Children Form ---------------------
	$('.addChildrenForm').click(function(){
		var ChildrenForm = $("#childrenFormBlock").clone();
		$("#childrenData").html(ChildrenForm);
		// jQuery_1_4_2("input.datepicker").date_input();
	});
});
</script>

<div id="teacherModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อครูหรืออีเมล์">
	  <button type="button" class="btn btn-primary searchTeacher">ค้นหา</button>
	  <button type="button" class="btn btn-primary addTeacherForm">เพิ่มรายชื่อครูในระบบ</button>
	</form>
  	<div id="teacherData"></div>
  </div>
</div>



<div id="childrenModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อเด็ก">
	  <button type="button" class="btn btn-primary searchChildren">ค้นหา</button>
	  <button type="button" class="btn btn-primary addChildrenForm">เพิ่มรายชื่อเด็กในระบบ</button>
	</form>
  	<div id="childrenData"></div>
  </div>
</div>



<!-- Teacher Form -->
<div style="display: none;">
<div id="teacherFormBlock">
<script type="text/javascript">
$(function(){
    $("#teacherform").validate({
	    rules: 
	    {
	    	name: { required: true},
	    	sex: { required: true},
	    	phone: { required: true},
	        email: { required: true,email: true,remote: "users/check_email"},
	        password: {required: true,minlength: 4},
	        _password:{equalTo: "#inputPass"},
	        captcha:{required: true,remote: "users/check_captcha"}
	    },
	    messages:
	    {
	    	name: { required: "กรุณากรอกชื่อ - นามสกุล"},
	    	sex: { required: "กรุณาระบุเพศ"},
	    	phone: { required: "กรุณากรอกเบอร์โทรศัพท์"},
	        email: {  required: "กรุณากรอกอีเมล์",email: "กรุณากรอกอีเมล์ให้ถูกต้อง",remote: "อีเมล์นี้มีอยู่ในระบบแล้ว"},
	        password: {required: "กรุณากรอกรหัสผ่าน",minlength: "กรุณากรอกรหัสผ่านอย่างน้อย 4 ตัวอักษร" },
	        _password:{equalTo: "กรุณากรอกรหัสผ่านให้ตรงกันทั้ง 2 ช่อง" },
	        captcha:{required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพ",remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพ" }
	    },
         submitHandler: function (form) {
             // alert('valid form submission'); // for demo
             $.post('classrooms/ajax_teacher_save',$("#teacherform").serialize(),function(data){
				if(data != ""){
					alert("บันทึกข้อมูลสำเร็จ");
					$.get('home/ajax_get_teacher',{
						'name' : data
					},function(data){
						$('#teacherData').html(data);
					});
				}
				return false;
			});
         }
	});
});
</script>
	<div class="row">
		<div class="span12">
			<form id="teacherform" action="javascript:return(false);" method="post" class="form-horizontal">
				<div class="control-group">
			        <label class="control-label">ชื่อ - สกุล<span class="TxtRed">*</span></label>
			        <div class="controls">
			          <input class="input-xlarge" type="text" name="name" value="<?=@$teacher->name?>">
			        </div>
			    </div>
			    <div class="control-group">
			        <label class="control-label">เพศ<span class="TxtRed">*</span></label>
			        <div class="controls">
			          <input type="radio" name="sex" value="ชาย" <?=(@$teacher->sex == "ชาย")?'checked':'';?>> ชาย
			          <input type="radio" name="sex" value="หญิง" <?=(@$teacher->sex == "หญิง")?'checked':'';?>> หญิง
			        </div>
			    </div>
			    <div class="control-group">
			        <label class="control-label">ตำแหน่ง</label>
			        <div class="controls">
			          <input class="input-xlarge" type="text" name="position" value="<?=@$teacher->position?>">
			        </div>
			    </div>
			    <div class="control-group">
			        <label class="control-label">เบอร์ติดต่อ</label>
			        <div class="controls">
			          <input class="input-xlarge" type="text" name="phone" value="<?=@$teacher->phone?>">
			        </div>
			    </div>
			     <div class="control-group">
			        <label class="control-label">อีเมล์<span class="TxtRed">*</span></label>
			        <div class="controls">
			          <input class="input-xlarge" type="text" name="email" value="<?=@$teacher->email?>">
			        </div>
			    </div>
			    <div class="control-group">
	                <label class="control-label" for="inputPass">รหัสผ่าน <span class="TxtRed">*</span></label>
	                <div class="controls">
	                  <input class="input-xlarge" type="text" name="password" id="inputPass" value="<?=@$teacher->password?>">
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label" for="re-inputPass">ยืนยันรหัสผ่าน <span class="TxtRed">*</span></label>
	                <div class="controls">
	                  <input class="input-xlarge" type="password" name="_password" id="re-inputPass" value="<?=@$teacher->password?>" >
	                </div>
	            </div>
	            <div class="control-group">
	                <label class="control-label" for="inputCaptcha">captcha <span class="TxtRed">*</span></label>
	                <div class="controls">
	                  <img src="users/captcha" /><Br>
	                  <input class="input-small" type="text" name="captcha" id="inputCaptcha">
	                </div>
	            </div>
			    <div class="control-group">
	                <div class="controls">
	                  <!-- บัญชีครูคนนี้ถูกสร้างครั้งแรกที่ไหน -->
	                  <input type="hidden" name="area_province_id" value="<?=user_login()->area_province_id?>">
	                  <input type="hidden" name="nursery_id" value="<?=user_login()->nursery_id?>">
	                  <input type="hidden" name="create_by_user_id" value="<?=user_login()->id?>">
	                  <!-- บัญชีครูคนนี้ถูกสร้างครั้งแรกที่ไหน -->
	                  
	                  <input type="hidden" name="m_status" value="active">
	                  <input type="hidden" name="user_type_id" value="10">
	                  <input type="submit" class="btn btn-small btn-info btnTeacherSubmitButton" value="บันทึก">
	                  <img class="loading" src="media/images/ajax-loader.gif" style="display: none;">
	                </div>
	            </div>
			</form>
		</div>
	</div>
</div>
</div>



<!-- Children Form -->
<div style="display: none;">
<div id="childrenFormBlock">
<script type="text/javascript">
$(function(){
	 $.validator.addMethod("DateFormat", function(value,element) {
    	return value.match(/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/);
        },
            "กรุณาใส่วันที่ตามตัวอย่างที่กำหนด วว/ดด/ปปปป"
        );
        
    $("#childrenform").validate({
	    rules: 
	    {
	    	name: { required: true},
	    	birth_date: { required: true , DateFormat: true}
	    },
	    messages:
	    {
	    	name: { required: "กรุณากรอกชื่อ - นามสกุล"},
	    	birth_date: { required: "กรุณาระบุวันเกิด"}
	    },
         submitHandler: function (form) {
             // alert('valid form submission'); // for demo
             $.post('classrooms/ajax_children_save',$("#childrenform").serialize(),function(data){
				if(data != ""){
					alert("บันทึกข้อมูลสำเร็จ");
					$.get('home/ajax_get_children',{
						'name' : data
					},function(data){
						$('#childrenData').html(data);
					});
				}
				return false;
			});
         }
	});
});
</script>
<div class="row">
	<div class="span12" style="height: 400px;">
		<form id="childrenform" action="javascript:return(false);" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">คำนำหน้า<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <select name="title">
		          	<option value="ด.ช." <?=(@$child->title == 'ด.ช.')?'selected':'';?>>ด.ช.</option>
		          	<option value="ด.ญ." <?=(@$child->title == 'ด.ญ.')?'selected':'';?>>ด.ญ.</option>
		          </select>
		        </div>
		    </div>
		    <div class="control-group">
		        <label class="control-label">ชื่อ - นามสกุลเด็ก<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="name" value="<?=@$child->child_name?>">
		        </div>
		    </div>
		    <div class="control-group">
			    <label class="control-label">วันเกิด<span class="TxtRed">*</span></label>
			    <div class="controls">
			      <input type="text" name="birth_date" value="<?php echo @DB2Date($child->birth_date)?>" class="datepicker" placeholder="วว/ดด/ปปปป"/> (ตัวอย่าง : 01/09/2558)
			    </div>
			</div>
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="create_by_user_id" value="<?=user_login()->id?>">
                  <input type="submit" class="btn btn-small btn-info btnChildrenSubmitButton" value="บันทึก">
                </div>
            </div>
		</form>
	</div>
</div>
</div>
</div>