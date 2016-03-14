<?php if(@$_GET['export_type']!=''):?>
	<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="media/js/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet" href="themes/hps/style.css" type="text/css">
    <script type="text/javascript" src="media/js/jquery-1.4.2.min.js"></script>
    <link rel="stylesheet" href="media/js/date_input/date_input.css" type="text/css" media="screen">
    <script type="text/javascript" src="media/js/date_input/jquery.date_input.min.js"></script>
    <script type="text/javascript" src="media/js/date_input/jquery.date_input.th_TH.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
    <script type="text/javascript" src="media/js/rgbcolor.js"></script>
    <script type="text/javascript" src="media/js/canvg.js"></script>
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
			#container{width:800px; height: 400px; margin: 0 auto;}
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
#search_report{
	padding: 10px;
	border: 1px solid #ccc;
	margin-bottom: 10px;
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
  <li class="active"><a href="diseases/newreport">รายงานแบบคัดกรองโรค</a></li>
</ul>
<?endif;?>

<h1>รายงานแบบคัดกรองโรค</h1>


<?php if(@$_GET['export_type']!='excel'):?>
<form id="search_report" method="get" action="diseases/newreport">
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
		<span>ปีที่คัดกรอง</span>
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
		
		<span>เดือนที่คัดกรองโรค</span>
		<?=form_dropdown('month',$arrayMonth,@$_GET['month'],'class="span2"','--- เลือกเดือน ---');?>
		
	</div>

	<!-- <div>
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
	</div> -->

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
	<input type="hidden" value="1" name='search'>
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</form>
<?endif;?>




<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>


<?
						
	if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){
		if(@$_GET['agecondition'] == 'between'){
			@$filter.=" ช่วงอายุระหว่าง ".$_GET['lowage']." ถึง ".$_GET['hiage']."  ปี";
		}elseif(@$_GET['agecondition'] == 'or'){
			@$filter.=" อายุ ".$_GET['lowage']." และ ".$_GET['hiage']." ปี";
		}
	}

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
		$filter .= ", ปีที่คัดกรอง พ.ศ. ".$_GET['year'];
	}
	
	// เดือนที่คัดกรอง
	if(@$_GET['month']){
		$filter .= ", เดือนที่คัดกรองโรค ".$arrayMonth[$_GET['month']];
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
		@$filter = "( ".$filter." )";
	}
	
	$title_graph = "สรุปผลรายงานแบบคัดกรองโรค<br>".@$filter;
?>

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
            	// height: 500,
                renderTo: 'container',
                type: 'column'
            },
            title: {
                text: "<?=$title_graph?>"
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
                },
                labels: {
	                formatter: function () {
	                    return Highcharts.numberFormat(this.value,0);
	                }
	            },
                stackLabels: {
                    enabled: true,
                    // style: {
                        // fontWeight: 'bold',
                        // color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                    // }
                }
            },
            // tooltip: {
                // formatter: function() {
                    // return '<b>'+ this.x +'</b><br/>'+
                        // this.series.name +' : '+ this.y +' ครั้ง ('+ Highcharts.numberFormat(this.percentage, 2) +'%)<br/>'+
                        // 'จำนวนการป่วยทั้งหมด : '+ this.point.stackTotal + ' ครั้ง';
                // }
            // },
            tooltip: {
            	headerFormat: '<b>{point.key}</b><table style="font-weight:bold;">',
	            pointFormat: '<tr><td style="color:{series.color};">{series.name}:</td><td style="text-align: right;">{point.percentage:.1f}%<td></tr>',
	            footerFormat: '</table>',
	            shared: true,
	            useHTML: true
	        },
            plotOptions: {
                column: {
                    stacking: 'percent',
                    dataLabels: {
                        enabled: true,
                        formatter: function() {
	                        return Math.round(this.percentage*100)/100 + ' %';
	                    },
                        color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'black'
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
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<?php $diseasesArray = array(
	'หวัด' => 'C',
	'มือ เท้า ปาก' => 'H',
	'อุจจาระร่วง' => 'D',
	'ไข้' => 'F',
	'ไข้ออกผื่น' => 'R',
	'อื่นๆ' => 'O'
);?>

<?php if(@$_GET['export_type']!='excel'):?>
<div class="input-prepend pull-right">
	<span class="add-on">ส่งออก</span>
    <span class="btn btn-default btn-print-report">เครื่องพิมพ์</span>
    <span class="btn btn-default btn-excel-report">Excel</span>
</div>
<?endif;?>

<table id="datatable" class="table table-bordered" <?php if(@$_GET['export_type']=='excel')echo 'border="1" cellpadding="5" cellspacing="0"'?>>
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
					if(@$_GET['classroom_id']!=""){
						echo $row->room_name; //ห้องเรียน
					}elseif(@$_GET['nursery_id']!=""){
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
				<?
					// หา last loop ใส่ class other ที่ td สุดท้าย
					$numItems = count($diseasesArray);
					$i = 0;
				?>
				<? foreach($diseasesArray as $key=>$disease):?>
					<?
						$condition = "";
						// if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						// if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						// if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						// if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }

						//**********************************************
						// if(@$_GET['classroom_id']!=""){
							// @$condition.=" and d.classroom_id = ".$row->id;
						// }elseif(@$_GET['nursery_id']!=""){
							// @$condition.=" and d.classroom_id = ".$row->id;
						// }elseif(@$_GET['district_id']!=""){
							// @$condition.=" and n.id = ".$row->id;
						// }elseif(@$_GET['amphur_id']!=""){
							// @$condition.=" and n.district_id = ".$row->id;
						// }elseif(@$_GET['province_id']!=""){
							// @$condition.=" and n.amphur_id = ".$row->id;
						// }elseif(@$_GET['area_id']!=""){
							// @$condition.=" and n.province_id = ".$row->id;
						// }else{
							// @$condition.=" and n.area_id = ".$row->id;
						// }

						if(@$_GET['classroom_id']!=""){
							@$condition.=" and d.classroom_id = ".$row->id;
						}elseif(@$_GET['nursery_id']!=""){
							@$condition.=" and d.classroom_id = ".$row->id;
						}elseif(@$_GET['district_id']!=""){
							@$condition.=" and d.nursery_id = ".$row->id;
						}elseif(@$_GET['amphur_id']!=""){
							@$condition.=" and n.district_id = ".$row->id;
						}elseif(@$_GET['province_id']!=""){
							@$condition.=" and n.amphur_id = ".$row->id;
						}elseif(@$_GET['area_id']!=""){
							@$condition.=" and area_provinces.province_id = ".$row->id;
						}else{
							@$condition.=" and area_provinces.area_id = ".$row->id;
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
						
						// ปีที่คัดกรอง
						if(@$_GET['year']){
							$condition .= " and d.year = ".$_GET['year'];
						}
						
						// เดือนที่คัดกรอง
						if(@$_GET['month']){
							$condition .= " and d.month = ".$_GET['month'];
						}

						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN nurseries AS n ON d.nursery_id = n.id
						INNER JOIN classroom_childrens ON d.classroom_children_id = classroom_childrens.id
						INNER JOIN childrens ON classroom_childrens.children_id = childrens.id
						INNER JOIN area_provinces ON n.area_province_id = area_provinces.area_province_id
						WHERE 1=1 and d.c1 = '".$disease."' ".@$condition."  and start_date IS NOT NULL";
						$rs = new Disease();
						$rs->query($sql);

						// echo $sql.'<br><br>';
					?>
					<td class="span2 <?if((++$i === $numItems) && ($rs->total != 0)) { echo 'other" href="#myModal" role="button" data-toggle="modal" data-condition="'.@$condition.'" style="cursor:pointer;" '; }?>"><?=$rs->total?></td>
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


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
  	<div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
  	<div class="modal-body-form"></div>
  </div>
</div>


<?endif;?>


<script>
$(".other").live("click",function(){
	$('.loader').show();
	$.get('ajax/get_other_disease_detail',{
		'condition' : $(this).attr('data-condition')
	},function(data){
		$('.modal-body-form').html(data);
		$('.loader').hide();
	});
});
</script>


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