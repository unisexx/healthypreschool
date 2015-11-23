<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="classrooms">ห้องเรียน</a> <span class="divider">/</span></li>
  <li class="active"><?=$classroom->room_name?></li>
</ul>

<h1><?=$classroom->room_name?></h1>
<br>
<div class="row">
	<div class="span12">
		<form action="classrooms/save" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ปีการศึกษา<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="text" name="room_name" value="" placeholder="">
		        </div>
		    </div>
		    
		    <div style="float:right; padding:10px 0;"><a href="#teacherModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มครูประจำชั้น</div></a></div>
		    <table id="teacherTable" class="table table-bordered">
		    	<tr>
			    	<th>ครูประจำชั้น</th>
			    	<th class="span1">จัดการ</th>
			    </tr>
		    </table>
		    
		    <div style="float:right; padding:10px 0;"><a href="#childrenModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มเด็กนักเรียน</div></a></div>
		    <table id="childrenTable"  class="table table-bordered">
		    	<tr>
			    	<th>เด็กนักเรียน</th>
			    	<th>วันเกิด</th>
			    	<th class="span1">จัดการ</th>
		    	</tr>
		    </table>
		    
		    <div class="control-group">
                <div class="controls">
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
	    height:700px;
	    margin-left:-40%; /* width/2) */ 
	}
	.modal-body {max-height:650px!important;}
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
});
</script>

<div id="teacherModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อครู">
	  <button type="button" class="btn searchTeacher">ค้นหา</button>
	</form>
  	<div id="teacherData"></div>
  </div>
</div>

<div id="childrenModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อเด็ก">
	  <button type="button" class="btn searchChildren">ค้นหา</button>
	</form>
  	<div id="childrenData"></div>
  </div>
</div>