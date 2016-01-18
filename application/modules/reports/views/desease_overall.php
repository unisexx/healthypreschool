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

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><a href="diseases/newreport">รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค</a></li>
</ul>

<h1>รายงานจำนวนและร้อยละของศูนย์เด็กเล็ก แจกแจงข้อมูลรายงานแบบคัดกรองโรค</h1>

<form id="search_report" method="get" action="reports/desease_overall" style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">

	<div>
		<span>ช่วงเวลาที่เกิดโรค</span>
		วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
		วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
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

//-------------------------------------------- sql select join template --------------------------------
$sql_tempate = " SELECT
								Count(d.id)
								FROM
								diseases AS d
								INNER JOIN nurseries AS n ON d.nursery_id = n.id
								INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
								INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
								INNER JOIN area_provinces ON n.area_province_id = area_provinces.area_province_id";

//-------------------------------------------- เพศ --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		childrens.title = 'ด.ช.' ".@$condition."
	) male,
	(
		".$sql_tempate."
		WHERE
		childrens.title = 'ด.ญ.' ".@$condition."
	) female";

$sex = new Disease();
$sex->query($sql);
$sex_total = $sex->male + $sex->female;

//-------------------------------------------- อายุ --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 0 ".@$condition."
	) year_0,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 1 ".@$condition."
	) year_1,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 2 ".@$condition."
	) year_2,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 3 ".@$condition."
	) year_3,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 4 ".@$condition."
	) year_4,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 5 ".@$condition."
	) year_5,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 6 ".@$condition."
	) year_6,
	(
		".$sql_tempate."
		WHERE
			d.child_age_year = 7 ".@$condition."
	) year_7";

$age = new Disease();
$age->query($sql);
$age_total = $age->year_0 + $age->year_1 + $age->year_2 + $age->year_3 + $age->year_4 + $age->year_5 + $age->year_6 + $age->year_7;

//-------------------------------------------- โรค --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'C' ".@$condition."
	) disease_1,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'H' ".@$condition."
	) disease_2,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'D' ".@$condition."
	) disease_3,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'F' ".@$condition."
	) disease_4,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'R' ".@$condition."
	) disease_5,
	(
		".$sql_tempate."
		WHERE
			d.c1 = 'O' ".@$condition."
	) disease_6";

	$disease = new Disease();
	$disease->query($sql);
	$disease_total = $disease->disease_1 + $disease->disease_2 + $disease->disease_3 + $disease->disease_4 + $disease->disease_5 + $disease->disease_6;

//-------------------------------------------- สถานะเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c3 = '/' ".@$condition."
	) sick_status_1,
	(
		".$sql_tempate."
		WHERE
		d.c3 = 'x' ".@$condition."
	) sick_status_2";

$sick_status = new Disease();
$sick_status->query($sql);
$sick_status_total = $sick_status->sick_status_1 + $sick_status->sick_status_2;

//-------------------------------------------- การแยกเด็กป่วย --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c2 = '0' ".@$condition."
	) separate_1,
	(
		".$sql_tempate."
		WHERE
		d.c2 = '1' ".@$condition."
	) separate_2,
	(
		".$sql_tempate."
		WHERE
		d.c2 = '2' ".@$condition."
	) separate_3";

$separate = new Disease();
$separate->query($sql);
$separate_total = $separate->separate_1 + $separate->separate_2 + $separate->separate_3;

//-------------------------------------------- กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน --------------------------------------------
$sql = "SELECT
	(
		".$sql_tempate."
		WHERE
		d.c5 = '*' ".@$condition."
	) same_1,
	(
		".$sql_tempate."
		WHERE
		d.c5 = '' ".@$condition."
	) same_2";

$same = new Disease();
$same->query($sql);
$same_total = $same->same_1 + $same->same_2;
?>

<br>
<table class="table">
	<tr>
		<th>ข้อมูลรายงานแบบคัดกรองโรค</th>
		<th>จำนวน</th>
		<th>ร้อยละ</th>
	</tr>
	<tr class="subheader">
		<td colspan="3">เพศ
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column" value="column" onclick= "chartfunc()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar" value="bar" onclick= "chartfunc()"> <i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie" value="pie" onclick= "chartfunc()"> <i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line" value="line" onclick= "chartfunc()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close" value="close" onclick= "chartfunc()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
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
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		});
		</script>
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
		<td colspan="3">กลุ่มอายุ
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column2" value="column" onclick= "chartfunc2()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar2" value="bar" onclick= "chartfunc2()"><i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie2" value="pie" onclick= "chartfunc2()"><i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line2" value="line" onclick= "chartfunc2()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close2" value="close" onclick= "chartfunc2()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
		<script type="text/javascript">
		$(function () {
		//--------------------------- Create the chart แจกแจงตามกลุ่มอายุ --------------------------
		var options2 = {
		    chart: {
		        plotBorderWidth: 0
		    },
		    title: {
		        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามกลุ่มอายุ',
		    },
		    //
		    // subtitle: {
		    //  text: 'Subtitle'
		    // },
		    //
		    xAxis: {
					type: 'category',
		    },
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		          name: 'กลุ่มอายุ',
		          colorByPoint: true,
		          data: [{
		              name: 'ต่ำกว่า 1 ปี',
		              y: <?=convert_2_percent($age->year_0,$age_total)?>
		          }, {
		              name: '1 ปี',
		              y: <?=convert_2_percent($age->year_1,$age_total)?>
		          }, {
		              name: '2 ปี',
		              y: <?=convert_2_percent($age->year_2,$age_total)?>
		          }, {
		              name: '3 ปี',
		              y: <?=convert_2_percent($age->year_3,$age_total)?>
		          }, {
		              name: '4 ปี',
		              y: <?=convert_2_percent($age->year_4,$age_total)?>
		          }, {
		              name: '5 ปี',
		              y: <?=convert_2_percent($age->year_5,$age_total)?>
		          }, {
		              name: '6 ปี',
		              y: <?=convert_2_percent($age->year_6,$age_total)?>
		          }, {
		              name: '7 ปี',
		              y: <?=convert_2_percent($age->year_7,$age_total)?>
		          }]
		      }],
		};

		// Column chart
		// options.chart.renderTo = 'container';
		// options.chart.type = 'column';
		// var chart1 = new Highcharts.Chart(options);


		$('.renderChartArea2').hide();

		chartfunc2 = function()
		{
		var column = document.getElementById('column2');
		var bar = document.getElementById('bar2');
		var pie = document.getElementById('pie2');
		var line = document.getElementById('line2');
		var close = document.getElementById('close2');


		if(column.checked)
		    {
						$('.renderChartArea2').show();
		        options2.chart.renderTo = 'container2';
		        options2.chart.type = 'column';
		        var chart2 = new Highcharts.Chart(options2);
		    }
		else if(bar.checked)
		    {
						$('.renderChartArea2').show();
		        options2.chart.renderTo = 'container2';
		        options2.chart.type = 'bar';
		        var chart2 = new Highcharts.Chart(options2);
		    }
		else if(pie.checked)
		    {
						$('.renderChartArea2').show();
		        options2.chart.renderTo = 'container2';
		        options2.chart.type = 'pie';
		        var chart2 = new Highcharts.Chart(options2);
		    }
		else if(close.checked)
		    {
						$('.renderChartArea2').hide();
		    }
		else
		    {
						$('.renderChartArea2').show();
		        options2.chart.renderTo = 'container2';
		        options2.chart.type = 'line';
		        var chart2 = new Highcharts.Chart(options2);
		    }

		}
		});
		</script>
		<td colspan="3" class="renderChartArea2">
				<div id="container2"></div>
		</td>
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
		<td colspan="3">แจกแจงตามโรค
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column3" value="column" onclick= "chartfunc3()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar3" value="bar" onclick= "chartfunc3()"><i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie3" value="pie" onclick= "chartfunc3()"><i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line3" value="line" onclick= "chartfunc3()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close3" value="close" onclick= "chartfunc3()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
		<script type="text/javascript">
		$(function () {
		//--------------------------- Create the chart แจกแจงตามโรค --------------------------
		var options3 = {
		    chart: {
		        plotBorderWidth: 0
		    },
		    title: {
		        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามโรค',
		    },
		    //
		    // subtitle: {
		    //  text: 'Subtitle'
		    // },
		    //
		    xAxis: {
					type: 'category',
		    },
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		          name: 'โรค',
		          colorByPoint: true,
		          data: [{
		              name: 'หวัด',
		              y: <?=convert_2_percent($disease->disease_1,$disease_total)?>
		          }, {
		              name: 'มือ เท้า ปาก',
		              y: <?=convert_2_percent($disease->disease_2,$disease_total)?>
		          }, {
		              name: 'อุจจาระร่วง',
		              y: <?=convert_2_percent($disease->disease_3,$disease_total)?>
		          }, {
		              name: 'ไข้',
		              y: <?=convert_2_percent($disease->disease_4,$disease_total)?>
		          }, {
		              name: 'ไข้ออกผื่น',
		              y: <?=convert_2_percent($disease->disease_5,$disease_total)?>
		          }, {
		              name: 'อื่นๆ',
		              y: <?=convert_2_percent($disease->disease_6,$disease_total)?>
		          }]
		      }],
		};

		// Column chart
		// options.chart.renderTo = 'container';
		// options.chart.type = 'column';
		// var chart1 = new Highcharts.Chart(options);


		$('.renderChartArea3').hide();

		chartfunc3 = function()
		{
		var column = document.getElementById('column3');
		var bar = document.getElementById('bar3');
		var pie = document.getElementById('pie3');
		var line = document.getElementById('line3');
		var close = document.getElementById('close3');


		if(column.checked)
		    {
						$('.renderChartArea3').show();
		        options3.chart.renderTo = 'container3';
		        options3.chart.type = 'column';
		        var chart3 = new Highcharts.Chart(options3);
		    }
		else if(bar.checked)
		    {
						$('.renderChartArea3').show();
		        options3.chart.renderTo = 'container3';
		        options3.chart.type = 'bar';
		        var chart3 = new Highcharts.Chart(options3);
		    }
		else if(pie.checked)
		    {
						$('.renderChartArea3').show();
		        options3.chart.renderTo = 'container3';
		        options3.chart.type = 'pie';
		        var chart3 = new Highcharts.Chart(options3);
		    }
		else if(close.checked)
		    {
						$('.renderChartArea3').hide();
		    }
		else
		    {
						$('.renderChartArea3').show();
		        options3.chart.renderTo = 'container3';
		        options3.chart.type = 'line';
		        var chart3 = new Highcharts.Chart(options3);
		    }

		}
		});
		</script>
		<td colspan="3" class="renderChartArea3">
				<div id="container3"></div>
		</td>
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
		<td colspan="3">สถานะเด็กป่วย
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column4" value="column" onclick= "chartfunc4()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar4" value="bar" onclick= "chartfunc4()"><i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie4" value="pie" onclick= "chartfunc4()"><i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line4" value="line" onclick= "chartfunc4()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close4" value="close" onclick= "chartfunc4()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
		<script type="text/javascript">
		$(function () {
		//--------------------------- Create the chart แจกแจงตามสถานะเด็กป่วย --------------------------
		var options4 = {
		    chart: {
		        plotBorderWidth: 0
		    },
		    title: {
		        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามสถานะเด็กป่วย',
		    },
		    //
		    // subtitle: {
		    //  text: 'Subtitle'
		    // },
		    //
		    xAxis: {
					type: 'category',
		    },
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		          name: 'สถานะเด็กป่วย',
		          colorByPoint: true,
		          data: [{
		              name: 'มาเรียน',
		              y: <?=convert_2_percent($sick_status->sick_status_1,$sick_status_total)?>
		          }, {
		              name: 'หยุดเรียน',
		              y: <?=convert_2_percent($sick_status->sick_status_2,$sick_status_total)?>
		          }]
		      }],
		};

		// Column chart
		// options.chart.renderTo = 'container';
		// options.chart.type = 'column';
		// var chart1 = new Highcharts.Chart(options);


		$('.renderChartArea4').hide();

		chartfunc4 = function()
		{
		var column = document.getElementById('column4');
		var bar = document.getElementById('bar4');
		var pie = document.getElementById('pie4');
		var line = document.getElementById('line4');
		var close = document.getElementById('close4');


		if(column.checked)
		    {
						$('.renderChartArea4').show();
		        options4.chart.renderTo = 'container4';
		        options4.chart.type = 'column';
		        var chart4 = new Highcharts.Chart(options4);
		    }
		else if(bar.checked)
		    {
						$('.renderChartArea4').show();
		        options4.chart.renderTo = 'container4';
		        options4.chart.type = 'bar';
		        var chart4 = new Highcharts.Chart(options4);
		    }
		else if(pie.checked)
		    {
						$('.renderChartArea4').show();
		        options4.chart.renderTo = 'container4';
		        options4.chart.type = 'pie';
		        var chart4 = new Highcharts.Chart(options4);
		    }
		else if(close.checked)
		    {
						$('.renderChartArea4').hide();
		    }
		else
		    {
						$('.renderChartArea4').show();
		        options4.chart.renderTo = 'container4';
		        options4.chart.type = 'line';
		        var chart4 = new Highcharts.Chart(options4);
		    }

		}
		});
		</script>
		<td colspan="3" class="renderChartArea4">
				<div id="container4"></div>
		</td>
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
		<td colspan="3">การแยกเด็กป่วย
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column5" value="column" onclick= "chartfunc5()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar5" value="bar" onclick= "chartfunc5()"><i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie5" value="pie" onclick= "chartfunc5()"><i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line5" value="line" onclick= "chartfunc5()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close5" value="close" onclick= "chartfunc5()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
		<script type="text/javascript">
		$(function () {
		//--------------------------- Create the chart แจกแจงตามการแยกเด็กป่วย --------------------------
		var options5 = {
		    chart: {
		        plotBorderWidth: 0
		    },
		    title: {
		        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามการแยกเด็กป่วย',
		    },
		    //
		    // subtitle: {
		    //  text: 'Subtitle'
		    // },
		    //
		    xAxis: {
					type: 'category',
		    },
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		          name: 'สถานะเด็กป่วย',
		          colorByPoint: true,
		          data: [{
		              name: 'ไม่มีการแยกนอนแยกเล่น',
		              y: <?=convert_2_percent($separate->separate_1,$separate_total)?>
		          }, {
		              name: 'แยกนอน',
		              y: <?=convert_2_percent($separate->separate_2,$separate_total)?>
		          }, {
		              name: 'แยกเล่น',
		              y: <?=convert_2_percent($separate->separate_3,$separate_total)?>
		          }]
		      }],
		};

		// Column chart
		// options.chart.renderTo = 'container';
		// options.chart.type = 'column';
		// var chart1 = new Highcharts.Chart(options);


		$('.renderChartArea5').hide();

		chartfunc5 = function()
		{
		var column = document.getElementById('column5');
		var bar = document.getElementById('bar5');
		var pie = document.getElementById('pie5');
		var line = document.getElementById('line5');
		var close = document.getElementById('close5');


		if(column.checked)
		    {
						$('.renderChartArea5').show();
		        options5.chart.renderTo = 'container5';
		        options5.chart.type = 'column';
		        var chart5 = new Highcharts.Chart(options5);
		    }
		else if(bar.checked)
		    {
						$('.renderChartArea5').show();
		        options5.chart.renderTo = 'container5';
		        options5.chart.type = 'bar';
		        var chart5 = new Highcharts.Chart(options5);
		    }
		else if(pie.checked)
		    {
						$('.renderChartArea5').show();
		        options5.chart.renderTo = 'container5';
		        options5.chart.type = 'pie';
		        var chart5 = new Highcharts.Chart(options5);
		    }
		else if(close.checked)
		    {
						$('.renderChartArea5').hide();
		    }
		else
		    {
						$('.renderChartArea5').show();
		        options5.chart.renderTo = 'container5';
		        options5.chart.type = 'line';
		        var chart5 = new Highcharts.Chart(options5);
		    }

		}
		});
		</script>
		<td colspan="3" class="renderChartArea5">
				<div id="container5"></div>
		</td>
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
		<td colspan="3">กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน
			<div style="float:right; display:inline;">
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "column6" value="column" onclick= "chartfunc6()"><i class="fa fa-bar-chart"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "bar6" value="bar" onclick= "chartfunc6()"><i class="fa fa-bar-chart fa-rotate-90"></i></label>
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "pie6" value="pie" onclick= "chartfunc6()"><i class="fa fa-pie-chart"></i></label>
			<!-- <label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "line6" value="line" onclick= "chartfunc6()">Line</label> -->
			<label class="radio-inline"><input type="radio" name="mychart" class="mychart" id= "close6" value="close" onclick= "chartfunc6()"><i class="fa fa-times"></i></label>
			</div>
		</td>
	</tr>
	<tr>
		<script type="text/javascript">
		$(function () {
		//--------------------------- Create the chart แจกแจงตามกรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน --------------------------
		var options6 = {
		    chart: {
		        plotBorderWidth: 0
		    },
		    title: {
		        text: 'รอยละจำนวนเด็กของศูนย์เด็กเล็ก แจกแจงตามกรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน',
		    },
		    //
		    // subtitle: {
		    //  text: 'Subtitle'
		    // },
		    //
		    xAxis: {
					type: 'category',
		    },
		    yAxis: {
		        title: {
		            text: 'ร้อยละ'
		        },
		    },
		    legend: {
		        enabled: true,
		    },
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
		          name: 'กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน',
		          colorByPoint: true,
		          data: [{
		              name: 'มี',
		              y: <?=convert_2_percent($same->same_1,$same_total)?>
		          }, {
		              name: 'ไม่มี',
		              y: <?=convert_2_percent($same->same_2,$same_total)?>
		          }]
		      }],
		};

		// Column chart
		// options.chart.renderTo = 'container';
		// options.chart.type = 'column';
		// var chart1 = new Highcharts.Chart(options);


		$('.renderChartArea6').hide();

		chartfunc6 = function()
		{
		var column = document.getElementById('column6');
		var bar = document.getElementById('bar6');
		var pie = document.getElementById('pie6');
		var line = document.getElementById('line6');
		var close = document.getElementById('close6');


		if(column.checked)
		    {
						$('.renderChartArea6').show();
		        options6.chart.renderTo = 'container6';
		        options6.chart.type = 'column';
		        var chart6 = new Highcharts.Chart(options6);
		    }
		else if(bar.checked)
		    {
						$('.renderChartArea6').show();
		        options6.chart.renderTo = 'container6';
		        options6.chart.type = 'bar';
		        var chart6 = new Highcharts.Chart(options6);
		    }
		else if(pie.checked)
		    {
						$('.renderChartArea6').show();
		        options6.chart.renderTo = 'container6';
		        options6.chart.type = 'pie';
		        var chart6 = new Highcharts.Chart(options6);
		    }
		else if(close.checked)
		    {
						$('.renderChartArea6').hide();
		    }
		else
		    {
						$('.renderChartArea6').show();
		        options6.chart.renderTo = 'container6';
		        options6.chart.type = 'line';
		        var chart5 = new Highcharts.Chart(options6);
		    }
		}
		});
		</script>
		<td colspan="3" class="renderChartArea6">
				<div id="container6"></div>
		</td>
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
