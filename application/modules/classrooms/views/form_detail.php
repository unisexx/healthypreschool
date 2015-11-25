<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
th{
    background-color: #0088CC !important;
    color: white !important;
}
</style>
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
  <li><a href="classrooms">ห้องเรียน</a> <span class="divider">/</span></li>
  <li class="active"><?=$classroom->room_name?></li>
</ul>

<h1>ห้องเรียน : <?=$classroom->room_name?></h1>
<br>
<div class="row">
	<div class="span12">
		<form id="classroom_detail_form" action="classrooms/form_detail_save" method="post" class="form-horizontal">
			<div class="control-group">
		        <label class="control-label">ปีการศึกษา<span class="TxtRed">*</span></label>
		        <div class="controls">
		          <input class="input-xlarge" type="number" name="year" value="<?=$year?>" placeholder="">
		        </div>
		    </div>
		    
		    <div style="float:right; padding:10px 0;"><a href="#teacherModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มครูประจำชั้น</div></a></div>
		    <table id="teacherTable" class="table table-bordered table-striped">
		    	<tr>
			    	<th>ครูประจำชั้น</th>
			    	<th class="span1">จัดการ</th>
			    </tr>
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
		    </table>
		    
		    <div style="float:right; padding:10px 0;"><a href="#childrenModal" role="button" data-toggle="modal"><div class="btn btn-info btn-small">เพิ่มเด็กนักเรียน</div></a></div>
		    <table id="childrenTable"  class="table table-bordered table-striped">
		    	<tr>
			    	<th>เด็กนักเรียน</th>
			    	<th>วันเกิด</th>
			    	<th class="span1">จัดการ</th>
		    	</tr>
		    	<?foreach($childrens as $row):?>
			    <tr>
			    	<td><?=$row->children->name?></td>
			    	<td><?=mysql_to_th($row->children->birth_date)?></td>
			    	<td>
			    		<input class="children_detail_id"  type="hidden" name="classroom_children_detail_id[]" value="<?=$row->id?>">
			    		<input type="hidden" name="childrenID[]" value="<?=$row->children_id?>">
			    		<button class="btn btn-mini btn-danger deleteChildren">ลบ</button>
			    	</td>
			    </tr>
			    <?endforeach;?>
		    </table>
		    
		    <div class="control-group">
                <div class="controls">
                  <input type="hidden" name="classroom_id" value="<?=$classroom->id?>">
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
});
</script>

<div id="teacherModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อครู">
	  <button type="button" class="btn btn-primary searchTeacher">ค้นหา</button>
	</form>
  	<div id="teacherData"></div>
  </div>
</div>

<div id="childrenModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body">
  	<form class="form-search">
	  <input type="text" class="input-medium search-query span4" name="search" placeholder="ค้นหาชื่อเด็ก">
	  <button type="button" class="btn btn-primary searchChildren">ค้นหา</button>
	</form>
  	<div id="childrenData"></div>
  </div>
</div>