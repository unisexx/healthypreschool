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
</style>
<script type="text/javascript" src="media/js/jquery.chained.remote.min.js"></script>
<script>
$(document).ready(function() {
	$("#province").remoteChained({
	    parents : "#area",
	    url : "home/get_province"
	});

	$("#ampor").remoteChained({
	    parents : "#province",
	    url : "home/get_ampor"
	});

	$("#tumbon").remoteChained({
	    parents : "#ampor",
	    url : "home/get_tumbon"
	});

	$("#nursery").remoteChained({
	    parents : "#tumbon",
	    url : "home/get_nursery"
	});

	$("#classroom").remoteChained({
	    parents : "#nursery",
	    url : "home/get_classroom"
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

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><a href="diseases/newreport">รายงานแบบคัดกรองโรค</a></li>
</ul>

<h1>รายงานแบบคัดกรองโรค</h1>

<form method="get" action="diseases/newreport">
<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
    <div>
		<span>ช่วงอายุ</span>
		<?=form_dropdown('lowage',array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['lowage'],'class="span1"');?>
		<?=form_dropdown('agecondition',array('between'=>'ถึง','or'=>'และ'),@$_GET['agecondition'],'class="span1"');?>

		<?if(@!isset($_GET['hiage']) or @$_GET['hiage']==""){$_GET['hiage'] = 7;}?>
		<?=form_dropdown('hiage',array('1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['hiage'],'class="span1"');?>
	</div>

	<div>
		<span>ช่วงเวลาที่เกิดโรค</span>
		วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
		วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
	</div>

	<div>
		<span>สถานะเด็กป่วย</span>
		<?=form_dropdown('c3',array('/'=>'มาเรียน','x'=>'หยุดเรียน'),@$_GET['c3'],'class="span2"','--- เลือก ---');?>
	</div>

	<div>
		<span>การแยกเด็กป่วย</span>
		<?=form_dropdown('c2',array('0'=>'ไม่มีการแยกนอนแยกเล่น','1'=>'แยกนอน','2'=>'แยกเล่น'),@$_GET['c2'],'class="span3"','--- เลือก ---');?>
	</div>

	<div>
		<span>กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน</span>
		<?=form_dropdown('c5',array('*'=>'มี','no'=>'ไม่มี'),@$_GET['c5'],'class="span2"',"--- เลือก ---");?>
	</div>

	<div>
		<span>สคร.</span>
		<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'id="area" class="span2"','--- เลือกสคร. ---');?>
	</div>

	<div>
		<span>จังหวัด</span>
		<?php
			if(isset($_GET['area_id']) && ($_GET['area_id']!="")){
				echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.@$_GET['area_id'].' order by name asc'),@$_GET['province_id'],'id="province"','--- เลือกจังหวัด ---');
			}else{
				echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'id="province"','--- เลือกจังหวัด ---');
			}
		?>
	</div>

	<div>
		<span>อำเภอ</span>
		<?php
			if(isset($_GET['province_id']) && ($_GET['province_id']!="")){
				echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.@$_GET['province_id'].' order by amphur_name asc'),@$_GET['amphur_id'],'id="ampor"','--- เลือกอำเภอ ---');
			}else{
				echo form_dropdown('amphur_id',array(''=>'---'),'','id="ampor" disabled');
			}
		?>
	</div>

	<div>
		<span>ตำบล</span>
		<?php
			if(isset($_GET['amphur_id']) && ($_GET['amphur_id']!="")){
				echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.@$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'id="tumbon"','--- เลือกตำบล ---');
			}else{
				echo form_dropdown('district_id',array(''=>'---'),'','id="tumbon" disabled');
			}
		?>
	</div>

	<div>
		<span>ศูนย์เด็กเล็ก</span>
		<?php
			if(isset($_GET['district_id']) && ($_GET['district_id']!="")){
				echo form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.@$_GET['district_id'].' order by name asc'),@$_GET['nursery_id'],'id="nursery"','--- เลือกศูนย์เด็กเล็ก ---');
			}else{
				echo form_dropdown('nursery_id',array(''=>'---'),'','id="nursery" class="span4" disabled');
			}
		?>
	</div>

	<div>
		<span>ห้องเรียน</span>
		<?php
			if(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
				echo form_dropdown('classroom_id',get_option('id','room_name','classrooms','where nursery_id = '.@$_GET['nursery_id'].' order by room_name asc'),@$_GET['classroom_id'],'id="classroom"','--- เลือกห้องเรียน ---');
			}else{
				echo form_dropdown('id',array(''=>'---'),'','id="classroom" class="span4" disabled');
			}
		?>
	</div>

	<!-- <select name="classroom_id">
	<option value="">-- ทุกห้องเรียน --</option>
	<?foreach($classrooms as $row):?>
		<option value="<?=$row->id?>" <?=$row->id == @$_GET['classroom_id'] ? 'selected' : '' ;?>><?=$row->room_name?></option>
	<?endforeach;?>
	</select>

	ช่วงอายุ <input class="span1" type="text" name="lowage" value="<?=(@$_GET['lowage']) ? $_GET['lowage'] : '0' ;?>"> ถึง <input class="span1" type="text" name="hiage" value="<?=(@$_GET['hiage']) ? $_GET['hiage'] : 99 ;?>">

	<select name="year">
	<option value="">-- เลือกทุกปี --</option>
	<?foreach($years as $row):?>
		<option value="<?=$row->year?>" <?=($row->year == @$_GET['year'])? 'selected' : '' ;?>><?=$row->year?></option>
	<?endforeach;?>
	</select>

	<select name="month">
	<option value="">-- เลือกทุกเดือน --</option>
	<?foreach($months as $row):?>
		<option value="<?=$row->month?>" <?=($row->month == @$_GET['month'])? 'selected' : '' ;?>><?=$arrayMonth[$row->month]?></option>
	<?endforeach;?>
	</select> -->

	<!-- <input type="hidden" name="nursery_id" value="<?=$_GET['nursery_id']?>"> -->
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>
</form>



<style>
	tr.subheader{font-weight:bold;background:#f1f1f1;}
</style>
<?
//-------------------------------------------- เพศ --------------------------------------------
$sql = "SELECT
	(
		SELECT
		Count(d.id) AS male
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		childrens.title = 'ด.ช.'
	) male,
	(
		SELECT
		Count(d.id) AS female
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		childrens.title = 'ด.ญ.'
	) female";

$sex = new Disease();
$sex->query($sql);
$sex_total = $sex->male + $sex->female;

//-------------------------------------------- อายุ --------------------------------------------
$sql = "SELECT
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 0
	) year_0,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 1
	) year_1,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 2
	) year_2,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 3
	) year_3,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 4
	) year_4,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 5
	) year_5,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 6
	) year_6,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.child_age_year = 7
	) year_7";

$age = new Disease();
$age->query($sql);
$age_total = $age->year_0 + $age->year_1 + $age->year_2 + $age->year_3 + $age->year_4 + $age->year_5 + $age->year_6 + $age->year_7;

//-------------------------------------------- โรค --------------------------------------------
$sql = "SELECT
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'C'
	) disease_1,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'H'
	) disease_2,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'D'
	) disease_3,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'F'
	) disease_4,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'R'
	) disease_5,
	(
		SELECT
			Count(d.id)
		FROM
			diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
			d.c1 = 'O'
	) disease_6";

	$disease = new Disease();
	$disease->query($sql);
	$disease_total = $disease->disease_1 + $disease->disease_2 + $disease->disease_3 + $disease->disease_4 + $disease->disease_5 + $disease->disease_6;

//-------------------------------------------- สถานะเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c3 = '/'
	) sick_status_1,
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c3 = 'x'
	) sick_status_2";

$sick_status = new Disease();
$sick_status->query($sql);
$sick_status_total = $sick_status->sick_status_1 + $sick_status->sick_status_2;

//-------------------------------------------- การแยกเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c2 = '0'
	) separate_1,
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c2 = '1'
	) separate_2,
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c2 = '2'
	) separate_3";

$separate = new Disease();
$separate->query($sql);
$separate_total = $separate->separate_1 + $separate->separate_2 + $separate->separate_3;

//-------------------------------------------- กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน --------------------------------------------
$sql = "SELECT
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c5 = '*'
	) same_1,
	(
		SELECT
		Count(d.id)
		FROM
		diseases AS d
		INNER JOIN nurseries AS n ON d.nursery_id = n.id
		INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
		INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
		WHERE
		d.c5 = ''
	) same_2";

$same = new Disease();
$same->query($sql);
$same_total = $same->same_1 + $same->same_2;
?>

<script type="text/javascript">
$(function () {

//--------------------------- Create the chart แจกแจงตามเพศ --------------------------
var options = {
    chart: {
        plotBorderWidth: 0
    },
    title: {
        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามเพศ',
    },
    //
    // subtitle: {
    //  text: 'Subtitle'
    // },
    //
    xAxis: {
			type: 'category',
    },
    //
    yAxis: {
        title: {
            text: 'ร้อยละ'
        },
    },
    //
    legend: {
        enabled: true,
    },
    //
		tooltip: {
			formatter: function() {
			    // If you want to see what is available in the formatter, you can
			    // examine the `this` variable.
			    //     console.log(this);
			    return '<b>' + this.point.name + ': ' + this.y +'%</b>';
			}
		},
    plotOptions: {
        series: {
            pointPadding: 0.2,
            borderWidth: 0,
            dataLabels: {
                enabled: true,
								format: '{point.name}: <b>{point.y}%</b>'
            }
        },
        pie: {
            plotBorderWidth: 0,
            allowPointSelect: true,
            cursor: 'pointer',
            size: '100%',
            dataLabels: {
                enabled: true,
                format: '{point.name}: <b>{point.y}%</b>'
            }
        }
    },
     series: [{
          name: 'เพศ',
          colorByPoint: true,
          data: [{
              name: 'ชาย',
              y: <?=convert_2_percent($sex->male,$sex_total)?>
          }, {
              name: 'หญิง',
              y: <?=convert_2_percent($sex->female,$sex_total)?>
          }]
      }],
};

// Column chart
// options.chart.renderTo = 'container';
// options.chart.type = 'column';
// var chart1 = new Highcharts.Chart(options);


$('.renderChartArea').hide();

chartfunc = function()
{
var column = document.getElementById('column');
var bar = document.getElementById('bar');
var pie = document.getElementById('pie');
var line = document.getElementById('line');
var close = document.getElementById('close');


if(column.checked)
    {
				$('.renderChartArea').show();
        options.chart.renderTo = 'container';
        options.chart.type = 'column';
        var chart1 = new Highcharts.Chart(options);
    }
else if(bar.checked)
    {
				$('.renderChartArea').show();
        options.chart.renderTo = 'container';
        options.chart.type = 'bar';
        var chart1 = new Highcharts.Chart(options);
    }
else if(pie.checked)
    {
				$('.renderChartArea').show();
        options.chart.renderTo = 'container';
        options.chart.type = 'pie';
        var chart1 = new Highcharts.Chart(options);
    }
else if(close.checked)
    {
				$('.renderChartArea').hide();
    }
else
    {
				$('.renderChartArea').show();
        options.chart.renderTo = 'container';
        options.chart.type = 'line';
        var chart1 = new Highcharts.Chart(options);
    }

}


var randomData = function() {
        var len = 6;
        var dataArray = [];
        for(var i = 0; i < len; i++) {
            // Push a random integer between 0 and 10 into the array
            dataArray.push(Math.floor(Math.random() * (10 - 0 + 1)) + 0);
        }
        return dataArray;
    };

		$('.addSeries').click(function() {

        var chart = $('#container').highcharts();
        chart.addSeries({
            type: 'column',
            data: randomData()
        });
        $('.remove').removeAttr('disabled');
    });

	$('.remove').click(function() {
		var chart = $('#container').highcharts();
        var seriesLength = chart.series.length;
        for(var i = seriesLength -1; i > -1; i--) {
            chart.series[i].remove();
        }
		this.disabled = true;
	});

});
</script>

<button class="addSeries">Add Series</button>
<button class="remove" disabled>Remove All Series</button>

<h1>ตาราง จำนวนร้อยและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค</h1>
<table class="table">
	<tr>
		<th>ข้อมูลรายงานแบบคัดกรองโรค</th>
		<th>จำนวน</th>
		<th>ร้อยละ</th>
	</tr>
	<tr class="subheader">
		<td colspan="3">เพศ
			<div style="margin-left:10px; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column" value="column" onclick= "chartfunc()">Column</label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar" value="bar" onclick= "chartfunc()">Bar</label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie" value="pie" onclick= "chartfunc()">Pie</label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line" value="line" onclick= "chartfunc()">Line</label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close" value="close" onclick= "chartfunc()" checked>Close</label>
			</div>
		</td>
	</tr>
	<tr>
		<td colspan="3" class="renderChartArea">
				<div id="container"></div>
		</td>
	</tr>
	<tr>
		<td>- ชาย</td>
		<td><?=$sex->male?></td>
		<td><?=convert_2_percent($sex->male,$sex_total)?></td>
	</tr>
	<tr>
		<td>- หญิง</td>
		<td><?=$sex->female?></td>
		<td><?=convert_2_percent($sex->female,$sex_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">กลุ่มอายุ</td>
	</tr>
	<tr>
		<td>- ต่ำกว่า 1 ปี</td>
		<td><?=$age->year_0?></td>
		<td><?=convert_2_percent($age->year_0,$age_total)?></td>
	</tr>
	<tr>
		<td>- 1 ปี</td>
		<td><?=$age->year_1?></td>
		<td><?=convert_2_percent($age->year_1,$age_total)?></td>
	</tr>
	<tr>
		<td>- 2 ปี</td>
		<td><?=$age->year_2?></td>
		<td><?=convert_2_percent($age->year_2,$age_total)?></td>
	</tr>
	<tr>
		<td>- 3 ปี</td>
		<td><?=$age->year_3?></td>
		<td><?=convert_2_percent($age->year_3,$age_total)?></td>
	</tr>
	<tr>
		<td>- 4 ปี</td>
		<td><?=$age->year_4?></td>
		<td><?=convert_2_percent($age->year_4,$age_total)?></td>
	</tr>
	<tr>
		<td>- 5 ปี</td>
		<td><?=$age->year_5?></td>
		<td><?=convert_2_percent($age->year_5,$age_total)?></td>
	</tr>
	<tr>
		<td>- 6 ปี</td>
		<td><?=$age->year_6?></td>
		<td><?=convert_2_percent($age->year_6,$age_total)?></td>
	</tr>
	<tr>
		<td>- 7 ปี</td>
		<td><?=$age->year_7?></td>
		<td><?=convert_2_percent($age->year_7,$age_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">แจกแจงตามโรค</td>
	</tr>
	<tr>
		<td>- หวัด</td>
		<td><?=$disease->disease_1?></td>
		<td><?=convert_2_percent($disease->disease_1,$disease_total)?></td>
	</tr>
	<tr>
		<td>- มือ เท้า ปาก</td>
		<td><?=$disease->disease_2?></td>
		<td><?=convert_2_percent($disease->disease_2,$disease_total)?></td>
	</tr>
	<tr>
		<td>- อุจจาระร่วง</td>
		<td><?=$disease->disease_3?></td>
		<td><?=convert_2_percent($disease->disease_3,$disease_total)?></td>
	</tr>
	<tr>
		<td>- ไข้</td>
		<td><?=$disease->disease_4?></td>
		<td><?=convert_2_percent($disease->disease_4,$disease_total)?></td>
	</tr>
	<tr>
		<td>- ไข้ออกผื่น</td>
		<td><?=$disease->disease_5?></td>
		<td><?=convert_2_percent($disease->disease_5,$disease_total)?></td>
	</tr>
	<tr>
		<td>- อื่นๆ</td>
		<td><?=$disease->disease_6?></td>
		<td><?=convert_2_percent($disease->disease_6,$disease_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">สถานะเด็กป่วย</td>
	</tr>
	<tr>
		<td>- มาเรียน</td>
		<td><?=$sick_status->sick_status_1?></td>
		<td><?=convert_2_percent($sick_status->sick_status_1,$sick_status_total)?></td>
	</tr>
	<tr>
		<td>- หยุดเรียน</td>
		<td><?=$sick_status->sick_status_2?></td>
		<td><?=convert_2_percent($sick_status->sick_status_2,$sick_status_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">การแยกเด็กป่วย</td>
	</tr>
	<tr>
		<td>- ไม่มีการแยกนอนแยกเล่น</td>
		<td><?=$separate->separate_1?></td>
		<td><?=convert_2_percent($separate->separate_1,$separate_total)?></td>
	</tr>
	<tr>
		<td>- แยกนอน</td>
		<td><?=$separate->separate_2?></td>
		<td><?=convert_2_percent($separate->separate_2,$separate_total)?></td>
	</tr>
	<tr>
		<td>- แยกเล่น</td>
		<td><?=$separate->separate_3?></td>
		<td><?=convert_2_percent($separate->separate_3,$separate_total)?></td>
	</tr>
	<tr class="subheader">
		<td colspan="3">กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน</td>
	</tr>
	<tr>
		<td>- มี</td>
		<td><?=$same->same_1?></td>
		<td><?=convert_2_percent($same->same_1,$same_total)?></td>
	</tr>
	<tr>
		<td>- ไม่มี</td>
		<td><?=$same->same_2?></td>
		<td><?=convert_2_percent($same->same_2,$same_total)?></td>
	</tr>
</table>
