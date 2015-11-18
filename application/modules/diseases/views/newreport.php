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
                title: {
                    text: 'จำนวนศูนย์เด็กเล็กปลอดโรค'
                },
                stackLabels: {
                    enabled: true,
                    style: {
                        fontWeight: 'bold',
                        color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    }
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +' : '+ this.y +'<br/>'+
                        'เข้าร่วมทั้งหมด (แห่ง) : '+ this.point.stackTotal;
                }
            },
            plotOptions: {
                column: {
                    stacking: 'normal',
                    dataLabels: {
                        enabled: true,
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                    }
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

<form method="get" action="diseases/newreport">
<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
    <div>
		<span>ช่วงอายุ</span> 
		<?=form_dropdown('lowage',array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['lowage'],'class="span1"');?>
		<?=form_dropdown('agecondition',array('between'=>'ถึง','or'=>'และ'),@$_GET['agecondition'],'class="span1"');?>
		<?=form_dropdown('hiage',array('0'=>'0','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5','6'=>'6','7'=>'7'),@$_GET['hiage'],'class="span1"');?>
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

<table id="datatable" class="table table-bordered">
	<thead>
		<tr>
			<th></th>
			<?if(@$_GET['diseases']):?>
				<th><?=array_search($_GET['diseases'], $diseasesArray);?></th>
			<?else:?>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			<?endif;?>
		</tr>
	</thead>
	<tbody>
		<?php foreach($rs as $row):?>
		<tr>
			<th class="span2">
				<?
					//**********************************************
					if(@$_GET['nursery_id']!=""){
						echo $row->room_name; //ชื่อห้องเรียน
					}elseif(@$_GET['district_id']!=""){
						echo $row->name; //ชื่อศูนย์เด็กเล็ก
					}elseif(@$_GET['amphur_id']!=""){
						echo $row->district_name; //ชื่อตำบล
					}elseif(@$_GET['province_id']!=""){
						echo $row->amphur_name; //ชื่ออำเภอ
					}elseif(@$_GET['area_id']!=""){
						echo $row->name; //ชื่อจังหวัด
					}else{
						echo $row->area_name; // สคร.
					}
					//**********************************************
				?>
			</th>
				<? foreach($diseasesArray as $key=>$disease):?>
					<?
						$condition = "";
						// if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						// if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						// if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						// if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						
						//**********************************************
						if(@$_GET['nursery_id']!=""){
							@$condition.=" and d.classroom_id = ".$row->id;
						}elseif(@$_GET['district_id']!=""){
							@$condition.=" and n.id = ".$row->id;
						}elseif(@$_GET['amphur_id']!=""){
							@$condition.=" and n.district_id = ".$row->id;
						}elseif(@$_GET['province_id']!=""){
							@$condition.=" and n.amphur_id = ".$row->id;
						}elseif(@$_GET['area_id']!=""){
							@$condition.=" and n.province_id = ".$row->id;
						}else{
							@$condition.=" and n.area_id = ".$row->id; 
						}
						//**********************************************
						
						
						
						// ช่วงอายุ
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){
							if(@$_GET['agecondition'] == 'between'){
								@$condition.=" and (d.child_age_year between ".$_GET['lowage']." and ".$_GET['hiage'].")";
							}elseif(@$_GET['agecondition'] == 'or'){
								@$condition.=" and (d.child_age_year = ".$_GET['lowage']." or d.child_age_year = ".$_GET['hiage'].")";
							}
						}
						
						// สถานะเด็กป่วย
						if(@$_GET['c3']){ @$condition.=" and d.c3 = '".$_GET['c3']."'";  }
						
						// การแยกเด็กป่วย
						if(@$_GET['c2']){ @$condition.=" and d.c2 = '".$_GET['c2']."'";  }

						// กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน
						if(@$_GET['c5']){
							if($_GET['c5'] == "no"){
								@$condition.=" and d.c5 = ''"; 
							}else{
								@$condition.=" and d.c5 = '".$_GET['c5']."'"; 
							}
						 }

						// วันที่เริ่ม - วันที่สิ้นสุด
						if(@$_GET['start_date'] and @$_GET['end_date']){
							$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
							$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
							$condition .= " and start_date between ".$start_date." and ".$end_date;
						}
						if(@$_GET['start_date'] and @empty($_GET['end_date'])){
							$start_date = str_replace("-", "", Date2DB($_GET['start_date']));
							$condition .= " and start_date >= ".$start_date;
						}
						if(@$_GET['end_date'] and @empty($_GET['start_date'])){
							$end_date = str_replace("-", "", Date2DB($_GET['end_date']));
							$condition .= " and start_date >= ".$end_date;
						}
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$disease."' ".@$condition."  and start_date IS NOT NULL";
						$rs = new Disease();
						$rs->query($sql);
						
						// echo $sql.'<br><br>';
					?>
					<td class="span2"><?=$rs->total?></td>
				<? endforeach;?>
		</tr>
		
		<?php endforeach;?>
		
		<!-- <tr class="sum">
			<th>รวมทั้งหมด</th>
			<?if(@$_GET['diseases']):?>
		        <td id='t1'>0</td>
		    <?else:?>
				<td id='t1'>0</td>
		        <td id='t2'>0</td>
		        <td id='t3'>0</td>
		        <td id='t4'>0</td>
		        <td id='t5'>0</td>
		        <td id='t6'>0</td>
			<?endif;?>
		</tr> -->
			
	</tbody>
</table>