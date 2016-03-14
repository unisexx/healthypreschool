<?php if(@$_GET['export_type']!=''):?>
	<base href="<?php echo base_url(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="media/js/bootstrap/css/bootstrap.min.css" type="text/css">
	<link rel="stylesheet" type="text/css" href="media/css/font-awesome-4.2.0/css/font-awesome.min.css">
	<link href="themes/hps/style.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" src="media/js/jquery-1.8.2.min.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
	<script src="https://code.highcharts.com/modules/exporting.js"></script>
    <style>
    	@media print {
			  a[href]:after {
			    content: " (" attr(href) ")";
			  }
			}
			@media print {
			  a[href]:after {
			    content: none !important;
			  }
			}
			#container1,#container2,#container3,#container4,#container5,#container6,#container7{width:800px; height: 400px; margin: 0 auto;}
			ul.breadcrumb,form,.btn,.add-on,.input-prepend,.hdtitle,h1{display: none !important;}
			.table{width:800px!important; margin:0 auto;}
			body{background:none !important;}
    </style>
<?endif;?>



<style media="screen">
input[type="radio"], input[type="checkbox"]{margin:-1px 0 0 0;}
.checkbox-inline, .radio-inline {
	position: relative;
	display: inline-block;
	padding-left: 5px;
	margin-bottom: 0;
	font-weight: 400;
	vertical-align: middle;
	cursor: pointer;
}
#search_report>div {
    padding-top: 10px;
    padding-bottom: 10px;
}
</style>

<script>
$(document).ready(function() {
		$("select[name='area_id']").live("change",function(){
  		$.post('ajax/get_province',{
  				'area_id' : $(this).val()
  			},function(data){
  				$("#province").html(data);
  			});

  		$.post('ajax/get_amphur',{
  				'province_id' : ''
  			},function(data){
  				$("#amphur").html(data);
  			});

  		$.post('ajax/get_district',{
  				'amphur_id' : ''
  			},function(data){
  				$("#district").html(data);
  			});

				// disabled low level
				$('select[name=nursery_id] option:first-child,select[name=classroom_id] option:first-child').attr("selected", "selected");
				$('select[name=nursery_id],select[name=classroom_id]').attr("disabled", "disabled");
  	});

  	$("select[name='province_id']").live("change",function(){
  		$.post('ajax/get_amphur',{
  				'province_id' : $(this).val()
  			},function(data){
  				$("#amphur").html(data);
  			});

				// disabled low level
				$('select[name=district_id] option:first-child,select[name=nursery_id] option:first-child,select[name=classroom_id] option:first-child').attr("selected", "selected");
				$('select[name=district_id],select[name=nursery_id],select[name=classroom_id]').attr("disabled", "disabled");
  	});

  	$("select[name='amphur_id']").live("change",function(){
  		$.post('ajax/get_district',{
  				'amphur_id' : $(this).val()
  			},function(data){
  				$("#district").html(data);
  			});

				// disabled low level
				$('select[name=nursery_id] option:first-child,select[name=classroom_id] option:first-child').attr("selected", "selected");
				$('select[name=nursery_id],select[name=classroom_id]').attr("disabled", "disabled");
  	});

		$("select[name='district_id']").live("change",function(){
  		$.get('ajax/get_nursery',{
  				'district_id' : $(this).val()
  			},function(data){
  				$("#nursery").html(data);
  			});

				// disabled low level
				$('select[name=classroom_id] option:first-child').attr("selected", "selected");
				$('select[name=classroom_id]').attr("disabled", "disabled");
  	});

		$("select[name='nursery_id']").live("change",function(){
  		$.get('ajax/get_classroom',{
  				'nursery_id' : $(this).val()
  			},function(data){
  				$("#classroom").html(data);
  			});
  	});
});
</script>

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

<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>

<?php if(@$_GET['export_type']!='excel'):?>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><a href="reports/desease_factor">รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค วิเคราะห์ตามปัจจัยต่างๆ</a></li>
</ul>
<?php endif;?>

<h1>รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค วิเคราะห์ตามปัจจัยต่างๆ</h1>

<?php if(@$_GET['export_type']!='excel'):?>
<form id="search_report" method="get" action="reports/desease_factor" style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">

	<div>
		<span>ปัจจัยหลัก</span>
		<?
			$main_factor_array = Array('age'=>'อายุในศูนย์เด็กเล็ก','disease'=>'โรคที่พบบ่อย');
			echo form_dropdown('main_factor',$main_factor_array,@$_GET['main_factor'],'id="main_factor" class="span3"');
		?>

		<span>ปัจจัยรอง</span>
		<?php
			$second_factor_array_1 = Array('sex'=>'เพศ','c1'=>'โรคที่พบบ่อย','c3'=>'สถานะเด็กป่วย');
			$second_factor_array_2 = Array('sex'=>'เพศ','c3'=>'สถานะเด็กป่วย','c2'=>'การแยกเด็กป่วย','c5'=>'กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน');
			echo form_dropdown('second_factor',$second_factor_array_1,@$_GET['second_factor'],'id="second_factor_1" class="span3"');
			echo form_dropdown('second_factor',$second_factor_array_2,@$_GET['second_factor'],'id="second_factor_2" class="span3"');
		?>

		<script type="text/javascript">
			$(document).ready(function(){
				if($('select[name=main_factor]').val() == 'age'){
					$('#second_factor_1').show().removeAttr("disabled", 'disabled');
					$('#second_factor_2').hide().attr("disabled", 'disabled');
				}else if($('select[name=main_factor]').val() == 'disease'){
					$('#second_factor_1').hide().attr("disabled", 'disabled');
					$('#second_factor_2').show().removeAttr("disabled", 'disabled');
				}

				$('#main_factor').on('change', function() {
				  // alert( this.value );
					if( this.value == 'age'){
						$('#second_factor_1').show().removeAttr("disabled", 'disabled');
						$('#second_factor_2').hide().attr("disabled", 'disabled');
					}else if ( this.value == 'disease' ) {
						$('#second_factor_1').hide().attr("disabled", 'disabled');
						$('#second_factor_2').show().removeAttr("disabled", 'disabled');
					}
				});
			});
		</script>
	</div>

	<hr>

	<div>
		<span>ช่วงเวลาที่เกิดโรค</span>
		วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
		วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
	</div>
	
	<div>
		<span>ปีที่สัมผัสโรค</span>
		<?
			$sql = "select DISTINCT(`year`) FROM diseases";
			$years = $this->db->query($sql)->result();
		?>
		<select name="year" class="span2">
			<option value="">--- เลือกปี ---</option>
			<?foreach($years as $item):?>
			<option value="<?=$item->year?>" <?if(@$_GET['year'] == $item->year){echo "selected";}?>><?=$item->year?></option>
			<?endforeach;?>
		</select>
		
		<span>เดือนที่สัมผัสโรค</span>
		<?=form_dropdown('month',$arrayMonth,@$_GET['month'],'class="span2"','--- เลือกเดือน ---');?>
	</div>

	<div>
		<span>สคร.</span>
		<?php echo form_dropdown('area_id',get_option('id','area_name','areas',' order by id '),@$_GET['area_id'],'id="area" class="span2"','--แสดงทั้งหมด--');?>
	</div>

	<div>
		<span>จังหวัด</span>
		<span id="province">
		<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
		</span>
		<span>อำเภอ</span>
    <span id="amphur">
    <?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
    </span>
    <span>ตำบล</span>
    <span id="district">
    <?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
    </span>
	</div>

	<div>
		<span>ศูนย์เด็กเล็ก</span>
		<span id="nursery">
		<?php
			if(isset($_GET['district_id']) && ($_GET['district_id']!="")){
				echo @form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.@$_GET['district_id'].' order by name asc'),@$_GET['nursery_id'],'id="nursery"','--- เลือกศูนย์เด็กเล็ก ---');
			}else{
				echo form_dropdown('nursery_id',array(''=>'--- เลือกศูนย์เด็กเล็ก ---'),'','id="nursery" class="span4" disabled');
			}
		?>
		</span>
	</div>

	<div>
		<span>ห้องเรียน</span>
		<span id="classroom">
		<?php
			if(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
				echo @form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.@$_GET['nursery_id'].' order by room_name asc'),@$_GET['classroom_id'],'id="classroom"','--- เลือกห้องเรียน ---');
			}else{
				echo form_dropdown('id',array(''=>'--- เลือกห้องเรียน ---'),'','id="classroom" class="span4" disabled');
			}
		?>
		</span>
	</div>


	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</form>
<?endif;?>







<?if(!empty($_GET)): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>

<?
	$filter = "";
	
	// วันที่เริ่ม - วันที่สิ้นสุด
	if(@$_GET['start_date'] and @$_GET['end_date']){
		$filter .= ", ช่วงเวลาที่เกิดโรค วันที่ ".$_GET['start_date']." ถึงวันที่ ".$_GET['end_date'];
	}
	if(@$_GET['start_date'] and @empty($_GET['end_date'])){
		$filter .= ", ตั้งแต่วันที่ ".$_GET['start_date'];
	}
	if(@$_GET['end_date'] and @empty($_GET['start_date'])){
		$filter .= ", จนถึงวันที่ ".$_GET['end_date'];
	}
	
	// ปีที่คัดกรอง
	if(@$_GET['year']){
		$filter .= ", ปีที่สัมผัสโรค พ.ศ. ".$_GET['year'];
	}
	
	// เดือนที่คัดกรอง
	if(@$_GET['month']){
		$filter .= ", เดือนที่สัมผัสโรค ".$arrayMonth[$_GET['month']];
	}

	if(@$_GET['area_id']!=""){
		@$filter.=", พื้นที่เขต สคร.".$_GET['area_id'];
	}
	
	if(@$_GET['province_id']!=""){
		@$filter.=", จังหวัด ".get_province_name($_GET['province_id']);
	}
	
	if(@$_GET['amphur_id']!=""){
		@$filter.=", อำเภอ ".get_amphur_name($_GET['amphur_id']);
	}
	
	if(@$_GET['district_id']!=""){
		@$filter.=", ตำบล ".get_district_name($_GET['district_id']);
	}
	
	if(@$_GET['nursery_id']!=""){
		@$filter.=", ".get_nursery_name($_GET['nursery_id']);
	}
	
	if(@$_GET['classroom_id']!=""){
		@$filter.=", ห้องเรียน".get_student_room_name($_GET['classroom_id']);
	}
	
	if(@$filter != ""){
		@$filter = "<br>( ".substr($filter,2)." )";
	}
	
?>

<style>
	tr.subheader{font-weight:bold;background:#f1f1f1;}
</style>
<?
//-------------------------------------------- search condition --------------------------------
$condition = "";
if(@$_GET['classroom_id']!=""){
	@$condition.=" and d.classroom_id = ".$_GET['classroom_id'];
}elseif(@$_GET['nursery_id']!=""){
	@$condition.=" and d.nursery_id = ".$_GET['nursery_id'];
}elseif(@$_GET['district_id']!=""){
	@$condition.=" and n.district_id = ".$_GET['district_id'];
}elseif(@$_GET['amphur_id']!=""){
	@$condition.=" and n.amphur_id = ".$_GET['amphur_id'];
}elseif(@$_GET['province_id']!=""){
	@$condition.=" and area_provinces.province_id = ".$_GET['province_id'];
}elseif(@$_GET['area_id']!=""){
	@$condition.=" and area_provinces.area_id = ".$_GET['area_id'];
}

// วันที่เริ่ม - วันที่สิ้นสุด
if(@$_GET['start_date'] and @$_GET['end_date']){
	$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
	$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	$condition .= " and d.start_date between ".$start_date." and ".$end_date;
}
if(@$_GET['start_date'] and @empty($_GET['end_date'])){
	$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
	$condition .= " and d.start_date >= ".$start_date;
}
if(@$_GET['end_date'] and @empty($_GET['start_date'])){
	$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
	$condition .= " and d.start_date >= ".$end_date;
}
// ปีที่สัมผัสโรค
if(@$_GET['year']){
	$condition .= " and d.year = ".$_GET['year'];
}
// เดือนที่สัมผัสโรค
if(@$_GET['month']){
	$condition .= " and d.month = ".$_GET['month'];
}

//-------------------------------------------- sql select join template --------------------------------
$sql_tempate = " SELECT
								Count(d.id) AS male
								FROM
								diseases AS d
								INNER JOIN nurseries AS n ON d.nursery_id = n.id
								INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
								INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
								INNER JOIN area_provinces ON n.area_province_id = area_provinces.area_province_id";


//------------------------------------ [หลัก : อายุ] [รอง : เพศ] -----------------------------------------ุ
$sql = "SELECT
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 0 ".@$condition."
				) male_year_0,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 1 ".@$condition."
				) male_year_1,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 2 ".@$condition."
				) male_year_2,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 3 ".@$condition."
				) male_year_3,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 4 ".@$condition."
				) male_year_4,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 5 ".@$condition."
				) male_year_5,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 6 ".@$condition."
				) male_year_6,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ช.' and
					d.child_age_year = 7 ".@$condition."
				) male_year_7,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 0 ".@$condition."
				) female_year_0,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 1 ".@$condition."
				) female_year_1,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 2 ".@$condition."
				) female_year_2,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 3 ".@$condition."
				) female_year_3,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 4 ".@$condition."
				) female_year_4,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 5 ".@$condition."
				) female_year_5,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 6 ".@$condition."
				) female_year_6,
				(
					".$sql_tempate."
					WHERE
					childrens.title = 'ด.ญ.' and
					d.child_age_year = 7 ".@$condition."
				) female_year_7";

$age = new Children();
$age->query($sql);

//------------------------------------ [หลัก : อายุ] [รอง : โรคที่พบบ่อย] -----------------------------------------ุ
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_c,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_h,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_d,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_f,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_r,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 0 ".@$condition."
	) year_0_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 1 ".@$condition."
	) year_1_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 2 ".@$condition."
	) year_2_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 3 ".@$condition."
	) year_3_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 4 ".@$condition."
	) year_4_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 5 ".@$condition."
	) year_5_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 6 ".@$condition."
	) year_6_o,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.child_age_year = 7 ".@$condition."
	) year_7_o";

$ageDisease = new Disease();
$ageDisease->query($sql);

//------------------------------------ [หลัก : อายุ] [รอง : สถานะเด็กป่วย] -----------------------------------------ุ
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 0 ".@$condition."
	) status_come_0,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 1 ".@$condition."
	) status_come_1,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 2 ".@$condition."
	) status_come_2,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 3 ".@$condition."
	) status_come_3,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 4 ".@$condition."
	) status_come_4,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 5 ".@$condition."
	) status_come_5,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 6 ".@$condition."
	) status_come_6,
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' AND
		d.child_age_year = 7 ".@$condition."
	) status_come_7,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 0 ".@$condition."
	) status_absent_0,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 1 ".@$condition."
	) status_absent_1,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 2 ".@$condition."
	) status_absent_2,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 3 ".@$condition."
	) status_absent_3,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 4 ".@$condition."
	) status_absent_4,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 5 ".@$condition."
	) status_absent_5,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 6 ".@$condition."
	) status_absent_6,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' AND
		d.child_age_year = 7 ".@$condition."
	) status_absent_7";

	$ageStatus = new Disease();
	$ageStatus->query($sql);

	//------------------------------------ [หลัก : โรคที่พบบ่อย] [รอง : เพศ] -----------------------------------------
	$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_c_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_c_female,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_h_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_h_female,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_d_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_d_female,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_f_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_f_female,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_r_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_r_female,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		childrens.title = 'ด.ช.' ".@$condition."
	) disease_o_male,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		childrens.title = 'ด.ญ.' ".@$condition."
	) disease_o_female
	";

	$diseaseSex = new Disease();
	$diseaseSex->query($sql);

	//------------------------------------ [หลัก : โรคที่พบบ่อย] [รอง : สถานะเด็กป่วย] -----------------------------------------
	$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c3 = '/' ".@$condition."
	) disease_c_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c3 = 'x' ".@$condition."
	) disease_c_absent,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c3 = '/' ".@$condition."
	) disease_h_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c3 = 'x' ".@$condition."
	) disease_h_absent,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c3 = '/' ".@$condition."
	) disease_d_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c3 = 'x' ".@$condition."
	) disease_d_absent,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c3 = '/' ".@$condition."
	) disease_f_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c3 = 'x' ".@$condition."
	) disease_f_absent,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c3 = '/' ".@$condition."
	) disease_r_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c3 = 'x' ".@$condition."
	) disease_r_absent,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c3 = '/' ".@$condition."
	) disease_o_come,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c3 = 'x' ".@$condition."
	) disease_o_absent
	";

	$diseaseStatus = new Disease();
	$diseaseStatus->query($sql);

	//------------------------------------ [หลัก : โรคที่พบบ่อย] [รอง : การแยกเด็กป่วย] -----------------------------------------
	$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c2 = '0' ".@$condition."
	) disease_c_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c2 = '1' ".@$condition."
	) disease_c_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c2 = '2' ".@$condition."
	) disease_c_2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c2 = '0' ".@$condition."
	) disease_h_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c2 = '1' ".@$condition."
	) disease_h_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c2 = '2' ".@$condition."
	) disease_h_2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c2 = '0' ".@$condition."
	) disease_d_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c2 = '1' ".@$condition."
	) disease_d_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c2 = '2' ".@$condition."
	) disease_d_2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c2 = '0' ".@$condition."
	) disease_f_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c2 = '1' ".@$condition."
	) disease_f_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c2 = '2' ".@$condition."
	) disease_f_2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c2 = '0' ".@$condition."
	) disease_r_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c2 = '1' ".@$condition."
	) disease_r_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c2 = '2' ".@$condition."
	) disease_r_2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c2 = '0' ".@$condition."
	) disease_o_0,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c2 = '1' ".@$condition."
	) disease_o_1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c2 = '2' ".@$condition."
	) disease_o_2
	";

	$diseaseSep = new Disease();
	$diseaseSep->query($sql);

	//------------------------------------ [หลัก : โรคที่พบบ่อย] [รอง : กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน] -----------------------------------------
	$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c5 = '*' ".@$condition."
	) disease_c_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'C' AND
		d.c5 = '' ".@$condition."
	) disease_c_s2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c5 = '*' ".@$condition."
	) disease_h_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'H' AND
		d.c5 = '' ".@$condition."
	) disease_h_s2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c5 = '*' ".@$condition."
	) disease_d_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'D' AND
		d.c5 = '' ".@$condition."
	) disease_d_s2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c5 = '*' ".@$condition."
	) disease_f_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'F' AND
		d.c5 = '' ".@$condition."
	) disease_f_s2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c5 = '*' ".@$condition."
	) disease_r_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'R' AND
		d.c5 = '' ".@$condition."
	) disease_r_s2,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c5 = '*' ".@$condition."
	) disease_o_s1,
	(
		".$sql_tempate."
		WHERE
		d.c1 = 'O' AND
		d.c5 = '' ".@$condition."
	) disease_o_s2
	";

	$diseaseSame = new Disease();
	$diseaseSame->query($sql);
?>



<style media="screen">
	table > tbody > tr:nth-child(1) > th:nth-child(1),table > tbody > tr:nth-child(1) > th:nth-child(2){text-align: center;}
</style>

<?if(@$_GET['main_factor'] == 'age' && @$_GET['second_factor'] == 'sex'):?>
<script>
$(function () {
    $('#container1').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามอายุ และเพศ<?=@$filter?>'
        },
        xAxis: {
            categories: ['ต่ำกว่า 1 ปี', '1 ปี', '2 ปี', '3 ปี', '4 ปี','5 ปี', '6 ปี', '7 ปี']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'เพศ'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'ชาย',
            data: [<?=$age->male_year_0?>, <?=$age->male_year_1?>, <?=$age->male_year_2?>, <?=$age->male_year_3?>, <?=$age->male_year_4?>, <?=$age->male_year_5?>, <?=$age->male_year_6?>, <?=$age->male_year_7?>]
        }, {
            name: 'หญิง',
            data: [<?=$age->female_year_0?>, <?=$age->female_year_1?>, <?=$age->female_year_2?>, <?=$age->female_year_3?>, <?=$age->female_year_4?>, <?=$age->female_year_5?>, <?=$age->female_year_6?>, <?=$age->female_year_7?>]
        }]
    });
});
</script>

<div id="container1"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>

<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			อายุเด็ก
		</th>
		<th colspan="3">
			เพศ
		</th>
	</tr>
	<tr>
		<th>
			ชาย
		</th>
		<th>
			หญิง
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- ต่ำกว่า 1 ปี
		</td>
		<td>
			<?=$age->male_year_0?>
		</td>
		<td>
			<?=$age->female_year_0?>
		</td>
		<td>
			<?=$age->male_year_0 + $age->female_year_0?>
		</td>
	</tr>
	<tr>
		<td>
			- 1 ปี
		</td>
		<td>
			<?=$age->male_year_1?>
		</td>
		<td>
			<?=$age->female_year_1?>
		</td>
		<td>
			<?=$age->male_year_1 + $age->female_year_1?>
		</td>
	</tr>
	<tr>
		<td>
			- 2 ปี
		</td>
		<td>
			<?=$age->male_year_2?>
		</td>
		<td>
			<?=$age->female_year_2?>
		</td>
		<td>
			<?=$age->male_year_2 + $age->female_year_2?>
		</td>
	</tr>
	<tr>
		<td>
			- 3 ปี
		</td>
		<td>
			<?=$age->male_year_3?>
		</td>
		<td>
			<?=$age->female_year_3?>
		</td>
		<td>
			<?=$age->male_year_3 + $age->female_year_3?>
		</td>
	</tr>
	<tr>
		<td>
			- 4 ปี
		</td>
		<td>
			<?=$age->male_year_4?>
		</td>
		<td>
			<?=$age->female_year_4?>
		</td>
		<td>
			<?=$age->male_year_4 + $age->female_year_4?>
		</td>
	</tr>
	<tr>
		<td>
			- 5 ปี
		</td>
		<td>
			<?=$age->male_year_5?>
		</td>
		<td>
			<?=$age->female_year_5?>
		</td>
		<td>
			<?=$age->male_year_5 + $age->female_year_5?>
		</td>
	</tr>
	<tr>
		<td>
			- 6 ปี
		</td>
		<td>
			<?=$age->male_year_6?>
		</td>
		<td>
			<?=$age->female_year_6?>
		</td>
		<td>
			<?=$age->male_year_6 + $age->female_year_6?>
		</td>
	</tr>
	<tr>
		<td>
			- 7 ปี
		</td>
		<td>
			<?=$age->male_year_7?>
		</td>
		<td>
			<?=$age->female_year_7?>
		</td>
		<td>
			<?=$age->male_year_7 + $age->female_year_7?>
		</td>
	</tr>
</table>
<?endif;?>



<?if(@$_GET['main_factor'] == 'age' && @$_GET['second_factor'] == 'c1'):?>
<script>
$(function () {
    $('#container2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามอายุ และโรค<?=@$filter?>'
        },
        xAxis: {
            categories: ['ต่ำกว่า 1 ปี', '1 ปี', '2 ปี', '3 ปี', '4 ปี','5 ปี', '6 ปี', '7 ปี']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'โรค'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'หวัด',
            data: [<?=$ageDisease->year_0_c?>, <?=$ageDisease->year_1_c?>, <?=$ageDisease->year_2_c?>, <?=$ageDisease->year_3_c?>, <?=$ageDisease->year_4_c?>, <?=$ageDisease->year_5_c?>, <?=$ageDisease->year_6_c?>, <?=$ageDisease->year_7_c?>]
        }, {
            name: 'มือ เท้า ปาก',
            data: [<?=$ageDisease->year_0_h?>, <?=$ageDisease->year_1_h?>, <?=$ageDisease->year_2_h?>, <?=$ageDisease->year_3_h?>, <?=$ageDisease->year_4_h?>, <?=$ageDisease->year_5_h?>, <?=$ageDisease->year_6_h?>, <?=$ageDisease->year_7_h?>]
        }, {
            name: 'อุจจาระร่วง',
            data: [<?=$ageDisease->year_0_d?>, <?=$ageDisease->year_1_d?>, <?=$ageDisease->year_2_d?>, <?=$ageDisease->year_3_d?>, <?=$ageDisease->year_4_d?>, <?=$ageDisease->year_5_d?>, <?=$ageDisease->year_6_d?>, <?=$ageDisease->year_7_d?>]
        }, {
            name: 'ไข้',
            data: [<?=$ageDisease->year_0_f?>, <?=$ageDisease->year_1_f?>, <?=$ageDisease->year_2_f?>, <?=$ageDisease->year_3_f?>, <?=$ageDisease->year_4_f?>, <?=$ageDisease->year_5_f?>, <?=$ageDisease->year_6_f?>, <?=$ageDisease->year_7_f?>]
        }, {
            name: 'ไข้ออกผื่น',
            data: [<?=$ageDisease->year_0_r?>, <?=$ageDisease->year_1_r?>, <?=$ageDisease->year_2_r?>, <?=$ageDisease->year_3_r?>, <?=$ageDisease->year_4_r?>, <?=$ageDisease->year_5_r?>, <?=$ageDisease->year_6_r?>, <?=$ageDisease->year_7_r?>]
        }, {
            name: 'อื่นๆ',
            data: [<?=$ageDisease->year_0_o?>, <?=$ageDisease->year_1_o?>, <?=$ageDisease->year_2_o?>, <?=$ageDisease->year_3_o?>, <?=$ageDisease->year_4_o?>, <?=$ageDisease->year_5_o?>, <?=$ageDisease->year_6_o?>, <?=$ageDisease->year_7_o?>]
        }]
    });
});
</script>
<div id="container2"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>

<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			อายุเด็ก
		</th>
		<th colspan="7">
			โรคที่พบบ่อย
		</th>
	</tr>
	<tr>
		<th width="75">
			หวัด
		</th>
		<th width="75">
			มือ เท้า ปาก
		</th>
		<th width="75">
			อุจจาระร่วง
		</th>
		<th width="75">
			ไข้
		</th>
		<th width="75">
			ไข้ออกผื่น
		</th>
		<th width="75">
			อื่นๆ
		</th>
		<th width="75">
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- ต่ำกว่า 1 ปี
		</td>
		<td>
			<?=$ageDisease->year_0_c?>
		</td>
		<td>
			<?=$ageDisease->year_0_h?>
		</td>
		<td>
			<?=$ageDisease->year_0_d?>
		</td>
		<td>
			<?=$ageDisease->year_0_f?>
		</td>
		<td>
			<?=$ageDisease->year_0_r?>
		</td>
		<td>
			<?=$ageDisease->year_0_o?>
		</td>
		<td>
			<?=$ageDisease->year_0_c + $ageDisease->year_0_h + $ageDisease->year_0_d + $ageDisease->year_0_f + $ageDisease->year_0_r + $ageDisease->year_0_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 1 ปี
		</td>
		<td>
			<?=$ageDisease->year_1_c?>
		</td>
		<td>
			<?=$ageDisease->year_1_h?>
		</td>
		<td>
			<?=$ageDisease->year_1_d?>
		</td>
		<td>
			<?=$ageDisease->year_1_f?>
		</td>
		<td>
			<?=$ageDisease->year_1_r?>
		</td>
		<td>
			<?=$ageDisease->year_1_o?>
		</td>
		<td>
			<?=$ageDisease->year_1_c + $ageDisease->year_1_h + $ageDisease->year_1_d + $ageDisease->year_1_f + $ageDisease->year_1_r + $ageDisease->year_1_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 2 ปี
		</td>
		<td>
			<?=$ageDisease->year_2_c?>
		</td>
		<td>
			<?=$ageDisease->year_2_h?>
		</td>
		<td>
			<?=$ageDisease->year_2_d?>
		</td>
		<td>
			<?=$ageDisease->year_2_f?>
		</td>
		<td>
			<?=$ageDisease->year_2_r?>
		</td>
		<td>
			<?=$ageDisease->year_2_o?>
		</td>
		<td>
			<?=$ageDisease->year_2_c + $ageDisease->year_2_h + $ageDisease->year_2_d + $ageDisease->year_2_f + $ageDisease->year_2_r + $ageDisease->year_2_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 3 ปี
		</td>
		<td>
			<?=$ageDisease->year_3_c?>
		</td>
		<td>
			<?=$ageDisease->year_3_h?>
		</td>
		<td>
			<?=$ageDisease->year_3_d?>
		</td>
		<td>
			<?=$ageDisease->year_3_f?>
		</td>
		<td>
			<?=$ageDisease->year_3_r?>
		</td>
		<td>
			<?=$ageDisease->year_3_o?>
		</td>
		<td>
			<?=$ageDisease->year_3_c + $ageDisease->year_3_h + $ageDisease->year_3_d + $ageDisease->year_3_f + $ageDisease->year_3_r + $ageDisease->year_3_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 4 ปี
		</td>
		<td>
			<?=$ageDisease->year_4_c?>
		</td>
		<td>
			<?=$ageDisease->year_4_h?>
		</td>
		<td>
			<?=$ageDisease->year_4_d?>
		</td>
		<td>
			<?=$ageDisease->year_4_f?>
		</td>
		<td>
			<?=$ageDisease->year_4_r?>
		</td>
		<td>
			<?=$ageDisease->year_4_o?>
		</td>
		<td>
			<?=$ageDisease->year_4_c + $ageDisease->year_4_h + $ageDisease->year_4_d + $ageDisease->year_4_f + $ageDisease->year_4_r + $ageDisease->year_4_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 5 ปี
		</td>
		<td>
			<?=$ageDisease->year_5_c?>
		</td>
		<td>
			<?=$ageDisease->year_5_h?>
		</td>
		<td>
			<?=$ageDisease->year_5_d?>
		</td>
		<td>
			<?=$ageDisease->year_5_f?>
		</td>
		<td>
			<?=$ageDisease->year_5_r?>
		</td>
		<td>
			<?=$ageDisease->year_5_o?>
		</td>
		<td>
			<?=$ageDisease->year_5_c + $ageDisease->year_5_h + $ageDisease->year_5_d + $ageDisease->year_5_f + $ageDisease->year_5_r + $ageDisease->year_5_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 6 ปี
		</td>
		<td>
			<?=$ageDisease->year_6_c?>
		</td>
		<td>
			<?=$ageDisease->year_6_h?>
		</td>
		<td>
			<?=$ageDisease->year_6_d?>
		</td>
		<td>
			<?=$ageDisease->year_6_f?>
		</td>
		<td>
			<?=$ageDisease->year_6_r?>
		</td>
		<td>
			<?=$ageDisease->year_6_o?>
		</td>
		<td>
			<?=$ageDisease->year_6_c + $ageDisease->year_6_h + $ageDisease->year_6_d + $ageDisease->year_6_f + $ageDisease->year_6_r + $ageDisease->year_6_o?>
		</td>
	</tr>
	<tr>
		<td>
			- 7 ปี
		</td>
		<td>
			<?=$ageDisease->year_7_c?>
		</td>
		<td>
			<?=$ageDisease->year_7_h?>
		</td>
		<td>
			<?=$ageDisease->year_7_d?>
		</td>
		<td>
			<?=$ageDisease->year_7_f?>
		</td>
		<td>
			<?=$ageDisease->year_7_r?>
		</td>
		<td>
			<?=$ageDisease->year_7_o?>
		</td>
		<td>
			<?=$ageDisease->year_7_c + $ageDisease->year_7_h + $ageDisease->year_7_d + $ageDisease->year_7_f + $ageDisease->year_7_r + $ageDisease->year_7_o?>
		</td>
	</tr>
</table>
<?endif;?>




<?if(@$_GET['main_factor'] == 'age' && @$_GET['second_factor'] == 'c3'):?>
<script>
$(function () {
    $('#container3').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามอายุ และสถานะเด็กป่วย<?=@$filter?>'
        },
        xAxis: {
            categories: ['ต่ำกว่า 1 ปี', '1 ปี', '2 ปี', '3 ปี', '4 ปี','5 ปี', '6 ปี', '7 ปี']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'สถานะเด็กป่วย'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'มาเรียน',
            data: [<?=$ageStatus->status_come_0?>, <?=$ageStatus->status_come_1?>, <?=$ageStatus->status_come_2?>, <?=$ageStatus->status_come_3?>, <?=$ageStatus->status_come_4?>, <?=$ageStatus->status_come_5?>, <?=$ageStatus->status_come_6?>, <?=$ageStatus->status_come_7?>]
        }, {
            name: 'หยุดเรียน',
            data: [<?=$ageStatus->status_absent_0?>, <?=$ageStatus->status_absent_1?>, <?=$ageStatus->status_absent_2?>, <?=$ageStatus->status_absent_3?>, <?=$ageStatus->status_absent_4?>, <?=$ageStatus->status_absent_5?>, <?=$ageStatus->status_absent_6?>, <?=$ageStatus->status_absent_7?>]
        }]
    });
});
</script>

<div id="container3"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>


<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			อายุเด็ก
		</th>
		<th colspan="3">
			สถานะเด็กป่วย
		</th>
	</tr>
	<tr>
		<th>
			มาเรียน
		</th>
		<th>
			หยุดเรียน
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- ต่ำกว่า 1 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_0?>
		</td>
		<td>
			<?=$ageStatus->status_absent_0?>
		</td>
		<td>
			<?=$ageStatus->status_come_0+$ageStatus->status_absent_0?>
		</td>
	</tr>
	<tr>
		<td>
			- 1 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_1?>
		</td>
		<td>
			<?=$ageStatus->status_absent_1?>
		</td>
		<td>
			<?=$ageStatus->status_come_1+$ageStatus->status_absent_1?>
		</td>
	</tr>
	<tr>
		<td>
			- 2 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_2?>
		</td>
		<td>
			<?=$ageStatus->status_absent_2?>
		</td>
		<td>
			<?=$ageStatus->status_come_2+$ageStatus->status_absent_2?>
		</td>
	</tr>
	<tr>
		<td>
			- 3 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_3?>
		</td>
		<td>
			<?=$ageStatus->status_absent_3?>
		</td>
		<td>
			<?=$ageStatus->status_come_3+$ageStatus->status_absent_3?>
		</td>
	</tr>
	<tr>
		<td>
			- 4 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_4?>
		</td>
		<td>
			<?=$ageStatus->status_absent_4?>
		</td>
		<td>
			<?=$ageStatus->status_come_4+$ageStatus->status_absent_4?>
		</td>
	</tr>
	<tr>
		<td>
			- 5 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_5?>
		</td>
		<td>
			<?=$ageStatus->status_absent_5?>
		</td>
		<td>
			<?=$ageStatus->status_come_5+$ageStatus->status_absent_5?>
		</td>
	</tr>
	<tr>
		<td>
			- 6 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_6?>
		</td>
		<td>
			<?=$ageStatus->status_absent_6?>
		</td>
		<td>
			<?=$ageStatus->status_come_6+$ageStatus->status_absent_6?>
		</td>
	</tr>
	<tr>
		<td>
			- 7 ปี
		</td>
		<td>
			<?=$ageStatus->status_come_7?>
		</td>
		<td>
			<?=$ageStatus->status_absent_7?>
		</td>
		<td>
			<?=$ageStatus->status_come_7+$ageStatus->status_absent_7?>
		</td>
	</tr>
</table>
<?endif;?>



<?if(@$_GET['main_factor'] == 'disease' && @$_GET['second_factor'] == 'sex'):?>
<script>
$(function () {
    $('#container4').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามโรค และเพศ<?=@$filter?>'
        },
        xAxis: {
            categories: ['หวัด', 'มือ เท้า ปาก', 'อุจจาระร่วง', 'ไข้', 'ไข้ออกผื่น','อื่นๆ']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'เพศ'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'ชาย',
            data: [<?=$diseaseSex->disease_c_male?>, <?=$diseaseSex->disease_h_male?>, <?=$diseaseSex->disease_d_male?>, <?=$diseaseSex->disease_f_male?>, <?=$diseaseSex->disease_r_male?>, <?=$diseaseSex->disease_o_male?>]
        }, {
            name: 'หญิง',
            data: [<?=$diseaseSex->disease_c_female?>, <?=$diseaseSex->disease_h_female?>, <?=$diseaseSex->disease_d_female?>, <?=$diseaseSex->disease_f_female?>, <?=$diseaseSex->disease_r_female?>, <?=$diseaseSex->disease_o_female?>]
        }]
    });
});
</script>

<div id="container4"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>


<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			โรคที่พบบ่อย
		</th>
		<th colspan="3">
			เพศ
		</th>
	</tr>
	<tr>
		<th>
			ชาย
		</th>
		<th>
			หญิง
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- หวัด
		</td>
		<td>
			<?=$diseaseSex->disease_c_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_c_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_c_male+$diseaseSex->disease_c_female?>
		</td>
	</tr>
	<tr>
		<td>
			- มือ เท้า ปาก
		</td>
		<td>
			<?=$diseaseSex->disease_h_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_h_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_h_male+$diseaseSex->disease_h_female?>
		</td>
	</tr>
	<tr>
		<td>
			- อุจจาระร่วง
		</td>
		<td>
			<?=$diseaseSex->disease_d_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_d_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_d_male+$diseaseSex->disease_d_female?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้
		</td>
		<td>
			<?=$diseaseSex->disease_f_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_f_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_f_male+$diseaseSex->disease_f_female?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้ออกผื่น
		</td>
		<td>
			<?=$diseaseSex->disease_r_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_r_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_r_male+$diseaseSex->disease_r_female?>
		</td>
	</tr>
	<tr>
		<td>
			- อื่นๆ
		</td>
		<td>
			<?=$diseaseSex->disease_o_male?>
		</td>
		<td>
			<?=$diseaseSex->disease_o_female?>
		</td>
		<td>
			<?=$diseaseSex->disease_o_male+$diseaseSex->disease_o_female?>
		</td>
	</tr>
</table>
<?endif;?>




<?if(@$_GET['main_factor'] == 'disease' && @$_GET['second_factor'] == 'c3'):?>
<script>
$(function () {
    $('#container5').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามโรค และสถานะเด็กป่วย<?=@$filter?>'
        },
        xAxis: {
            categories: ['หวัด', 'มือ เท้า ปาก', 'อุจจาระร่วง', 'ไข้', 'ไข้ออกผื่น','อื่นๆ']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'สถานะเด็กป่วย'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'มาเรียน',
            data: [<?=$diseaseStatus->disease_c_come?>, <?=$diseaseStatus->disease_h_come?>, <?=$diseaseStatus->disease_d_come?>, <?=$diseaseStatus->disease_f_come?>, <?=$diseaseStatus->disease_r_come?>,<?=$diseaseStatus->disease_o_come?>]
        }, {
            name: 'หยุดเรียน',
            data: [<?=$diseaseStatus->disease_c_absent?>, <?=$diseaseStatus->disease_h_absent?>, <?=$diseaseStatus->disease_d_absent?>, <?=$diseaseStatus->disease_f_absent?>, <?=$diseaseStatus->disease_r_absent?>, <?=$diseaseStatus->disease_o_absent?>]
        }]
    });
});
</script>

<div id="container5"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>


<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			โรคที่พบบ่อย
		</th>
		<th colspan="3">
			สถานะเด็กป่วย
		</th>
	</tr>
	<tr>
		<th>
			มาเรียน
		</th>
		<th>
			หยุดเรียน
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- หวัด
		</td>
		<td>
			<?=$diseaseStatus->disease_c_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_c_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_c_come+$diseaseStatus->disease_c_absent?>
		</td>
	</tr>
	<tr>
		<td>
			- มือ เท้า ปาก
		</td>
		<td>
			<?=$diseaseStatus->disease_h_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_h_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_h_come+$diseaseSex->disease_h_absent?>
		</td>
	</tr>
	<tr>
		<td>
			- อุจจาระร่วง
		</td>
		<td>
			<?=$diseaseStatus->disease_d_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_d_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_d_come+$diseaseSex->disease_d_absent?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้
		</td>
		<td>
			<?=$diseaseStatus->disease_f_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_f_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_f_come+$diseaseSex->disease_f_absent?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้ออกผื่น
		</td>
		<td>
			<?=$diseaseStatus->disease_r_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_r_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_r_come+$diseaseSex->disease_r_absent?>
		</td>
	</tr>
	<tr>
		<td>
			- อื่นๆ
		</td>
		<td>
			<?=$diseaseStatus->disease_o_come?>
		</td>
		<td>
			<?=$diseaseStatus->disease_o_absent?>
		</td>
		<td>
			<?=$diseaseStatus->disease_o_come+$diseaseSex->disease_o_absent?>
		</td>
	</tr>
</table>
<?endif;?>




<?if(@$_GET['main_factor'] == 'disease' && @$_GET['second_factor'] == 'c2'):?>
<script>
$(function () {
    $('#container6').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามโรค และการแยกเด็กป่วย<?=@$filter?>'
        },
        xAxis: {
            categories: ['หวัด', 'มือ เท้า ปาก', 'อุจจาระร่วง', 'ไข้', 'ไข้ออกผื่น','อื่นๆ']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'การแยกเด็กป่วย'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'ไม่มีการแยกนอนแยกเล่น',
            data: [<?=$diseaseSep->disease_c_0?>, <?=$diseaseSep->disease_h_0?>, <?=$diseaseSep->disease_d_0?>, <?=$diseaseSep->disease_f_0?>, <?=$diseaseSep->disease_r_0?>, <?=$diseaseSep->disease_o_0?>]
        }, {
            name: 'แยกนอน',
            data: [<?=$diseaseSep->disease_c_1?>, <?=$diseaseSep->disease_h_1?>, <?=$diseaseSep->disease_d_1?>, <?=$diseaseSep->disease_f_1?>, <?=$diseaseSep->disease_r_1?>, <?=$diseaseSep->disease_o_1?>]
        }, {
            name: 'แยกเล่น',
            data: [<?=$diseaseSep->disease_c_2?>, <?=$diseaseSep->disease_h_2?>, <?=$diseaseSep->disease_d_2?>, <?=$diseaseSep->disease_f_2?>, <?=$diseaseSep->disease_r_2?>, <?=$diseaseSep->disease_o_2?>]
        }]
    });
});
</script>

<div id="container6"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>


<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			โรคที่พบบ่อย
		</th>
		<th colspan="4">
			การแยกเด็กป่วย
		</th>
	</tr>
	<tr>
		<th>
			ไม่มีการแยกนอนแยกเล่น
		</th>
		<th>
			แยกนอน
		</th>
		<th>
			แยกเล่น
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- หวัด
		</td>
		<td>
			<?=$diseaseSep->disease_c_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_c_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_c_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_c_0+$diseaseSep->disease_c_1+$diseaseSep->disease_c_2?>
		</td>
	</tr>
	<tr>
		<td>
			- มือ เท้า ปาก
		</td>
		<td>
			<?=$diseaseSep->disease_h_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_h_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_h_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_h_0+$diseaseSep->disease_h_1+$diseaseSep->disease_h_2?>
		</td>
	</tr>
	<tr>
		<td>
			- อุจจาระร่วง
		</td>
		<td>
			<?=$diseaseSep->disease_d_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_d_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_d_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_d_0+$diseaseSep->disease_d_1+$diseaseSep->disease_d_2?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้
		</td>
		<td>
			<?=$diseaseSep->disease_f_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_f_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_f_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_f_0+$diseaseSep->disease_f_1+$diseaseSep->disease_f_2?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้ออกผื่น
		</td>
		<td>
			<?=$diseaseSep->disease_r_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_r_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_r_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_r_0+$diseaseSep->disease_r_1+$diseaseSep->disease_r_2?>
		</td>
	</tr>
	<tr>
		<td>
			- อื่นๆ
		</td>
		<td>
			<?=$diseaseSep->disease_o_0?>
		</td>
		<td>
			<?=$diseaseSep->disease_o_1?>
		</td>
		<td>
			<?=$diseaseSep->disease_o_2?>
		</td>
		<td>
			<?=$diseaseSep->disease_o_0+$diseaseSep->disease_o_1+$diseaseSep->disease_o_2?>
		</td>
	</tr>
</table>
<?endif;?>




<?if(@$_GET['main_factor'] == 'disease' && @$_GET['second_factor'] == 'c5'):?>
<script>
$(function () {
    $('#container7').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'ตารางแสดงจำนวนเด็กที่ป่วยในศูนย์เด็กเล็กปลอดโรค แจกแจงตามโรค และกรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน<?=@$filter?>'
        },
        xAxis: {
            categories: ['หวัด', 'มือ เท้า ปาก', 'อุจจาระร่วง', 'ไข้', 'ไข้ออกผื่น','อื่นๆ']
        },
        yAxis: {
            min: 0,
            title: {
                text: 'กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน'
            }
        },
        tooltip: {
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y}</b> ({point.percentage:.2f}%)<br/>',
            shared: true
        },
        plotOptions: {
            column: {
                stacking: 'percent'
            },
            series: {
	            dataLabels: {
	                enabled: true,
									format: '{point.percentage:.2f}%'
	            }
	        }
        },
        series: [{
            name: 'มี',
            data: [<?=$diseaseSame->disease_c_s1?>, <?=$diseaseSame->disease_h_s1?>, <?=$diseaseSame->disease_d_s1?>, <?=$diseaseSame->disease_f_s1?>, <?=$diseaseSame->disease_r_s1?>, <?=$diseaseSame->disease_o_s1?>]
        }, {
            name: 'ไม่มี',
            data: [<?=$diseaseSame->disease_c_s2?>, <?=$diseaseSame->disease_h_s2?>, <?=$diseaseSame->disease_d_s2?>, <?=$diseaseSame->disease_f_s2?>, <?=$diseaseSame->disease_r_s2?>, <?=$diseaseSame->disease_o_s2?>]
        }]
    });
});
</script>

<div id="container7"></div>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>


<table class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
	<tr>
		<th rowspan="2">
			โรคที่พบบ่อย
		</th>
		<th colspan="3">
			กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน
		</th>
	</tr>
	<tr>
		<th>
			มี
		</th>
		<th>
			ไม่มี
		</th>
		<th>
			รวม
		</th>
	</tr>
	<tr>
		<td>
			- หวัด
		</td>
		<td>
			<?=$diseaseSame->disease_c_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_c_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_c_s1+$diseaseSame->disease_c_s2?>
		</td>
	</tr>
	<tr>
		<td>
			- มือ เท้า ปาก
		</td>
		<td>
			<?=$diseaseSame->disease_h_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_h_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_h_s1+$diseaseSame->disease_h_s2?>
		</td>
	</tr>
	<tr>
		<td>
			- อุจจาระร่วง
		</td>
		<td>
			<?=$diseaseSame->disease_d_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_d_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_d_s1+$diseaseSame->disease_d_s2?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้
		</td>
		<td>
			<?=$diseaseSame->disease_f_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_f_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_f_s1+$diseaseSame->disease_f_s2?>
		</td>
	</tr>
	<tr>
		<td>
			- ไข้ออกผื่น
		</td>
		<td>
			<?=$diseaseSame->disease_r_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_r_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_r_s1+$diseaseSame->disease_r_s2?>
		</td>
	</tr>
	<tr>
		<td>
			- อื่นๆ
		</td>
		<td>
			<?=$diseaseSame->disease_o_s1?>
		</td>
		<td>
			<?=$diseaseSame->disease_o_s2?>
		</td>
		<td>
			<?=$diseaseSame->disease_o_s1+$diseaseSame->disease_o_s2?>
		</td>
	</tr>
</table>
<?endif;?>



<?endif;?>




<script type="text/javascript" charset="utf-8">
$(document).ready(function(){
	$('.btn-excel-report').click(function(){
        var url = 'http://<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['REQUEST_URI']?>&export_type=excel';
        window.open(url);
    });
    
	$('.btn-print-report').click(function(){
	    var url = 'http://<?=$_SERVER['SERVER_NAME']?><?=$_SERVER['REQUEST_URI']?>&export_type=print';
	    window.open(url);
	});
});

<?php if(@$_GET['export_type']=='print'):?>
setTimeout("window.print();",2000);
<?php endif;?>
</script>