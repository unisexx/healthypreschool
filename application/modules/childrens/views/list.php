<style type="text/css">
.form-horizontal .control-label {width:170px !important;}
.table th,.table td{vertical-align: middle !important;}
</style>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li>ตรวจสอบรายชื่อ / เด็กนักเรียน</li>
</ul>

<h1>ตรวจสอบรายชื่อ / เด็กนักเรียน</h1>

<form method="get" action="childrens">
<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('sex',array('ด.ช.'=>'ชาย','ด.ญ.'=>'หญิง'),@$_GET['sex'],'class="span2"','--- เพศ ---');?>
	<input type="text" name="child_name" value="<?=@$_GET['child_name']?>" placeholder="ชื่อ - นามสกุล">
	
	ช่วงอายุ <input class="span1" type="text" name="lowage" value="<?=(@$_GET['lowage']) ? $_GET['lowage'] : '0' ;?>"> ถึง <input class="span1" type="text" name="hiage" value="<?=(@$_GET['hiage']) ? $_GET['hiage'] : 7 ;?>"><br>
	
	<?if(user_login()->user_type_id == 9):?>
		<?php echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.user_login()->nursery_id.' order by room_name asc'),@$_GET['classroom_id'],'','--- เลือกห้องเรียน ---')?> 
	<?elseif(user_login()->user_type_id == 10):?>
		<?php echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where user_id = '.user_login()->id.' order by room_name asc'),@$_GET['classroom_id'],'','--- เลือกห้องเรียน ---')?> 
	<?endif;?>
	
	<?php echo @form_dropdown('year',get_option('year','year','classroom_childrens','GROUP BY year order by year asc'),@$_GET['year'],'','--- เลือกปีการศึกษา ---')?> 
	
	<!-- <br> 
	<?=form_dropdown('bmi',array(
		'1'=>'20-25 ดีที่สุด',
		'2'=>'25-30 น้ำหนักเกิน',
		'3'=>'30-34 อ้วน',
		'4'=>'35-44 อ้วนจนต้องระวังสุขภาพ',
		'5'=>'45-49 อ้วนจนเป็นอันตรายต่อสุขภาพ',
		'6'=>'มากกว่า 50 ซุปเปอร์อ้วน (อันตรายมาก)'
	),@$_GET['bmi'],'class="input-xlarge"','--- การประเมินค่าดัชนีมวลกาย ---');?> -->
	<input type="hidden" name="nursery_id" value="<?=$_GET['nursery_id']?>">
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>
</form>

<!-- <div style="float:right; padding:10px 0;"><a href="childrens/form?nursery_id=<?=$_GET['nursery_id']?>"><div class="btn btn-small">เพิ่มรายชื่อเด็ก</div></a></div> -->
<table class="table table-striped table-bordered">
	<tr>
		<th>ลำดับ</th>
		<th>ชื่อ - สกุล เด็ก</th>
		<th>อายุ (ปี)</th>
		<th>น้ำหนัก (กก) / ส่วนสูง (ซม)<br>(วันที่บันทึกล่าสุด)</th>
		<!-- <th>ดัชนีมวลกาย (BMI)</th> -->
		<!-- <th>เกณฑ์การเจริญเติบโต</th>
		<th>ประวัติการป่วย</th> -->
		<th>ห้องเรียน</th>
		<th>ปีการศึกษา</th>
		<!-- <th>ปีการศึกษา</th> -->
		<!-- <th>จัดการ</th> -->
		<th class="span1"></th>
	</tr>
	<?foreach($childs as $key=>$row):?>
	<tr>
		<td><?=$key+1?></td>
		<td><a href="childrens/profile/<?=$row->children_id?>?nursery_id=<?=$_GET['nursery_id']?>"><?=$row->children->title?> <?=$row->children->name?></a></td>
		<td><?//=@calAge($row->birth_date)?><?=newDatediff(date("Y-m-d H:i:s"),$row->children->birth_date)?></td>
		<td>
			<?
				$rs = new Bmi();
				$rs->where('classroom_children_id = '.$row->children_id)->order_by('input_date','desc')->get(1);
				echo $rs->weight.' / '.$rs->height.' ('.mysql_to_th($rs->input_date).')';
			?>
		</td>
		<!-- <td><?=number_format($row->weight/(($row->height/100)*($row->height/100)),2)?></td> -->
		<!-- <td><a href="childrens/growth/<?=$row->id?>?nursery_id=<?=$_GET['nursery_id']?>" target="_blank"><i class="fa fa-area-chart"></i></a></td>
		<td><a href="childrens/sick_history/<?=$row->id?>?nursery_id=<?=$_GET['nursery_id']?>"><i class="fa fa-file-text-o"></i></a></td> -->
		<td><?=$row->classroom->room_name?></td>
		<td><?=$row->year?></td>
		<!-- <td><?=$row->year?></td> -->
		<!-- <td>
			<a href="childrens/form/<?=$row->id?>?nursery_id=<?=$_GET['nursery_id']?>" class='btn btn-mini btn-info'>แก้ไข</a>
    		<a href="childrens/delete/<?=$row->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
		</td> -->
		<td>
			<a href="childrens/growth/<?=$row->children->id?>?nursery_id=<?=$_GET['nursery_id']?>" target="_blank" title="เกณฑ์การเจริญเติบโต"><i class="fa fa-area-chart"></i></a> | 
			<a href="childrens/sick_history/<?=$row->children->id?>?nursery_id=<?=$_GET['nursery_id']?>" target="_blank" title="ประวัติการป่วย"><i class="fa fa-file-text-o"></i></a>
		</td>
	</tr>
	<?endforeach;?>
</table>

<!-- <u>การแปลผล BMI ที่คำนวณได้</u><br>
<ul>
  <li>20-25 ดีที่สุด</li>
  <li>25-30 น้ำหนักเกิน</li>
  <li>30-34 อ้วน</li>
  <li>35-44 อ้วนจนต้องระวังสุขภาพ</li>
  <li>45-49 อ้วนจนเป็นอันตรายต่อสุขภาพ</li>
  <li>มากกว่า 50 ซุปเปอร์อ้วน (อันตรายมาก)</li>
</ul>
<i>*** วิธีการคิดค่า BMI = น้ำหนักตัว (หน่วยเป็นกิโลกรัม) / ความสูง (หน่วยเป็นเมตร) ยกกำลังสอง</i> -->