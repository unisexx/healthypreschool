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
  <li>ข้อมูลเด็ก</li>
</ul>

<h1><?=$child->title?> <?=$child->child_name?></h1>

<form action="childrens/save_profile" method="post" class="form-horizontal">
<!-- <div class="control-group">
    <label class="control-label">อายุ (ปี)<span class="TxtRed">*</span></label>
    <div class="controls">
      <?=form_dropdown('age',array('2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$bmi->age,'','--- เลือกอายุ ---');?>
    </div>
</div> -->
<div class="control-group">
    <label class="control-label">น้ำหนัก (กก) / ส่วนสูง (ซม)<span class="TxtRed">*</span></label>
    <div class="controls">
      <input class="span1" type="text" name="weight" value="<?=$bmi->weight?>"> / 
      <input class="span1" type="text" name="height" value="<?=$bmi->height?>">
    </div>
</div>
<div class="control-group">
    <label class="control-label">วันที่บันทึก<span class="TxtRed">*</span></label>
    <div class="controls">
      <input type="text" name="input_date" value="<?php echo DB2Date($bmi->input_date)?>" class="datepicker" />
    </div>
</div>
<div class="control-group">
    <div class="controls">
      <input type="hidden" name="classroom_detail_id" value="<?php echo $child->id ?>">
      <input type="hidden" name="birth_date" value="<?=@$child->birth_date?>">
      <input type="hidden" name="id" value="<?=@$bmi->id?>">
      <input type="submit" class="btn btn-small btn-info" value="บันทึก">
      <input type="button" class="btn btn-small btn-danger" value="ย้อนกลับ" OnClick="location.href='childrens';">
    </div>
</div>	
</form>


<br>
<h2>รายงานบันทึกการเจริญเติบโตในเด็ก <a href="childrens/growth/<?=$child->id?>" target="_blank"><i class="fa fa-area-chart"></i></a></h2>
<table class="table">
	<tr>
		<th>วันที่บันทึก</th>
		<th>อายุ</th>
		<th>น้ำหนัก</th>
		<th>ส่วนสูง</th>
		<th>จัดการ</th>
	</tr>
	<?foreach($bmis as $row):?>
	<tr>
		<td><?=mysql_to_th($row->input_date)?></td>
		<td><?=$row->child_age_year?> ปี <?=$row->child_age_month?> เดือน</td>
		<td><?=$row->weight?></td>
		<td><?=$row->height?></td>
		<td>
			<a href="<?=current_url()?>?id=<?=$row->id?>" class='btn btn-mini'>แก้ไข</a>
	        	<a href="childrens/delete_profile/<?=$row->id?>" class="btn btn-mini" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td>
	</tr>
	<?endforeach;?>
</table>
