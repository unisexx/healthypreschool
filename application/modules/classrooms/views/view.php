<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
</style>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="classrooms">ห้องเรียน</a> <span class="divider">/</span></li>
  <li class="active"><?=$rs->room_name?></li>
</ul>

<h1><?$rs->room_name?></h1>
<br>
<div class="row">
	<div class="span12">
		<div style="float:right; padding:10px 0;"><a href="classrooms/form_detail/<?=$rs->id?>"><div class="btn">เพิ่มปีการศึกษา</div></a></div>
		<table class="table table-bodered">
			<tr>
				<th>ปีการศึกษา</th>
				<th>ครูประจำชั้น</th>
				<th>เด็ก</th>
				<th>จัดการ</th>
			</tr>
			
		</table>
	</div>
</div>