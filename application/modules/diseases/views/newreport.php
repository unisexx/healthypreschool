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
});
</script>

<script type="text/javascript" src="media/js/highchart/highcharts.js"></script>
<script type="text/javascript" src="media/js/highchart/modules/exporting.js"></script>
<script type="text/javascript">
$(function(){
	// On document ready, call visualize on the datatable.
    $(document).ready(function() {
        /**
         * Visualize an HTML table using Highcharts. The top (horizontal) header
         * is used for series names, and the left (vertical) header is used
         * for category names. This function is based on jQuery.
         * @param {Object} table The reference to the HTML table to visualize
         * @param {Object} options Highcharts options
         */
        Highcharts.visualize = function(table, options) {
            // the categories
            options.xAxis.categories = [];
            $('tbody th', table).each( function(i) {
                options.xAxis.categories.push(this.innerHTML.replace(/&amp;/g, '&'));
            });
    
            // the data series
            options.series = [];
            $('tr', table).each( function(i) {
                var tr = this;
                $('th, td', tr).each( function(j) {
                    if (j > 0) { // skip first column
                        if (i == 0) { // get the name and init the series
                            options.series[j - 1] = {
                                name: this.innerHTML,
                                data: []
                            };
                        } else { // add values
                            options.series[j - 1].data.push(parseFloat(this.innerHTML));
                        }
                    }
                });
            });
    
            var chart = new Highcharts.Chart(options);
        }
    
        var table = document.getElementById('datatable'),
        options = {
            chart: {
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: "<?=$text?>"
            },
            xAxis: {
            	labels: {
                    rotation: -45,
                    align: 'right'
                }
            },
            yAxis: {
            	allowDecimals: false,
                title: {
                    text: 'จำนวนครั้งที่ป่วย'
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.series.name +'</b><br/>'+
                        this.y +' '+ this.x.toLowerCase();
                }
            },
            exporting: {
			    buttons: {
			        exportButton: {
			            enabled: false
			        },
	                printButton: {
	                    x: -10
	                }
			    }
			}
        };
    
        Highcharts.visualize(table, options);
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
  <li class="active"><?//=get_nursery_name($_GET['nursery_id'])?> / รายงานแบบคัดกรองโรค</li>
</ul>

<h1>รายงานแบบคัดกรองโรค</h1>

<form method="get" action="diseases/report_guest">
<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
    <div>
		<span>ช่วงอายุ</span> 
		<?=form_dropdown('lowage',array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['lowage'],'class="span1"');?>
		<?=form_dropdown('agecondition',array('ถึง'=>'ถึง'),@$_GET['agecondition'],'class="span1"');?>
		<?=form_dropdown('hiage',array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['hiage'],'class="span1"');?>
	</div>
	
	<div>
		<span>ช่วงเวลาที่เกิดโรค</span>
		วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
		วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
	</div>
	
	<div>
		<span>สถานะเด็กป่วย</span>
		<?=form_dropdown('c3',array('/'=>'มาเรียน','x'=>'หยุดเรียน'),@$_GET['c3'],'class="span2"');?>
	</div>
	
	<div>
		<span>การแยกเด็กป่วย</span>
		<?=form_dropdown('c2',array('0'=>'ไม่มีการแยกนอนแยกเล่น','1'=>'แยกนอน','2'=>'แยกเล่น'),@$_GET['c2'],'class="span3"');?>
	</div>
	
	<div>
		<span>กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน</span>
		<?=form_dropdown('c5',array('*'=>'มี'),@$_GET['c2'],'class="span2"','ไม่มี');?>
	</div>
	
	<div>
		<span>สคร.</span>
		<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'id="area" class="span2"','--- เลือกสคร. ---');?>
	</div>
	
	<div>
		<span>จังหวัด</span>
		<?=form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'id="province"','--- เลือกจังหวัด ---') ?>
	</div>
	
	<div>
		<span>อำเภอ</span>
		<?php
			if(isset($_GET['province_id'])){
				echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.@$_GET['province_id'].' order by amphur_name asc'),@$_GET['amphur_id'],'id="ampor"','--- เลือกอำเภอ ---');
			}else{
				echo form_dropdown('amphur_id',array(''=>'--- เลือกตำบล ---'),'','id="ampor"');
			}
		?>
	</div>
	
	<div>
		<span>ตำบล</span>
		<?php
			if(isset($_GET['amphur_id'])){
				echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.@$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'id="tumbon"','--- เลือกตำบล ---');
			}else{
				echo form_dropdown('district_id',array(''=>'--- เลือกตำบล ---'),'','id="tumbon"');
			}
		?>
	</div>
	
	<div>
		<span>ศูนย์เด็กเล็ก</span>
		<?php
			if(isset($_GET['district_id'])){
				echo form_dropdown('nursery_id',get_option('id','name','nurseries','where district_id = '.@$_GET['district_id'].' order by name asc'),@$_GET['nursery_id'],'id="nursery"','--- เลือกศูนย์เด็กเล็ก ---');
			}else{
				echo form_dropdown('nursery_id',array(''=>'--- เลือกศูนย์เด็กเล็ก ---'),'','id="nursery" class="span4"');
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

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<?php $diseasesArray = array(
	'หวัด' => 'C', 
	'มือ เท้า ปาก' => 'H', 
	'อุจจาระร่วง' => 'D',
	'ไข้' => 'F',
	'ไข้ออกผื่น' => 'R',
	'อื่นๆ' => 'O'
);?>

<table id="datatable" class="table">
	<thead>
		<tr>
			<th></th>
			<th>ชาย</th>
			<th>หญิง</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($diseasesArray as $key=>$row):?>
			<?
				if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
				if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
				if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
				if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
				
				$sql = "
				SELECT count(d.id) boy
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ช.' and d.c1 = '".$row."' ".@$condition;
				$disease = new Disease();
				$disease->query($sql);
				
				$sql = "
				SELECT count(d.id) girl
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ญ.' and d.c1 = '".$row."' ".@$condition;
				$disease2 = new Disease();
				$disease2->query($sql);
			?>
		<tr>
			<th><?=$key?></th>
			<td><?=$disease->boy?></td>
			<td><?=$disease2->girl?></td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>