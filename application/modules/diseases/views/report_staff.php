<?php 
	$diseasesArray = array(
	'หวัด' => 'C', 
	'มือ เท้า ปาก' => 'H', 
	'อุจจาระร่วง' => 'D',
	'ไข้' => 'F',
	'ไข้ออกผื่น' => 'R',
	'อื่นๆ' => 'O'
	);
	
	
	if(@$_GET['sex'] == "ด.ช."){
		$sex = 'จำแนกตามเพศชาย';
	}elseif(@$_GET['sex'] == "ด.ญ."){
		$sex = 'จำแนกตามเพศหญิง';
	}
?>
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
                text: "<?=$text?> <?=@$sex?>"
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
    
    $("select[name=type]").change(function(){
		//alert( this.value );
		switch(this.value)
		{
           case '1':
			$("#area").show();
			$("#province,#amphur,#district").hide();
			$("select[name=province_id],select[name=amphur_id],select[name=district_id]").val("0");
           break;
           case '2':
			$("#province").show();
			$("#area,#amphur,#district").hide();
			$("select[name=area_id],select[name=amphur_id],select[name=district_id]").val("0");
           break;
           case '3':
			$("#amphur").show();
			$("#area,#district").hide();
			$("select[name=province_id],select[name=area_id],select[name=district_id]").val("0");
           break;
           case '4':
			$("#district").show();
			$("#area").hide();
			$("select[name=province_id],select[name=amphur_id],select[name=area_id]").val("0");
           break;
		}
	});
	
	$("input[type=submit]").click(function(){
		var type = $("select[name=type]").val();
		var area = $("select[name=area_id]").val();
		var province = $("select[name=province_id]").val();
		var amphur = $("select[name=amphur_id]").val();
		var district = $("select[name=district_id]").val();
		if(type == 1 && area == ""){
			alert('กรุณาเลือกสคร.');
			return false;
		}else if(type == 2 && province == ""){
			alert('กรุณาเลือกจังหวัด');
			return false;
		}else if(type == 3 && amphur == ""){
			alert('กรุณาเลือกอำเภอ');
			return false;
		}else if(type == 4 && district == ""){
			alert('กรุณาเลือกตำบล');
			return false;
		}
	});
	
});
</script>

<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">รายงานแบบคัดกรองโรค</li>
</ul>

<h1>รายงานแบบคัดกรองโรค</h1>

<form method="get" action="diseases/report_staff">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('sex',array('ด.ช.'=>'ชาย','ด.ญ.'=>'หญิง'),@$_GET['sex'],'','รวมทุกเพศ');?>
		
	<?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556','2557'=>'2557'),@$_GET['year'],'','--- ทุกปี ---');?>
		
	<?=form_dropdown('type',array('1'=>'สคร.','2'=>'จังหวัด','3'=>'อำเภอ','4'=>'ตำบล'),@$_GET['type'],'','--- แยกตาม ---');?>
	
	<span id="area" <?=(@$_GET['area_id'] == "")?'style="display:none;"':'';?>>
	<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'','--- เลือกสคร. ---');?>
	</span>
	
	<span id="province" <?=(@$_GET['province_id'] == "")?'style="display:none;"':'';?>>
	<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	</span>
   	
	<span id="amphur" <?=(@$_GET['amphur_id'] == "")?'style="display:none;"':'';?>>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	</span>
	
	<span id="district" <?=(@$_GET['district_id'] == "")?'style="display:none;"':'';?>>
		<?=form_dropdown('district_id',get_option('id','district_name','districts','order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
	</span>
	
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	</div>
</form>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<a href="diseases/export_graphpage/word?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">word</div></a>
<a href="diseases/export_graphpage/excel?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">excel</div></a>


<div>
<?php if(@$_GET['type'] == 1):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($provinces as $province):?>
			<tr>
				<th>
					<a href="diseases/report_staff/basic_column?year=<?=$_GET['year']?>&type=2&province_id=<?=$province->id?>"><?=$province->name?></a>
				</th>
				
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$province->id){ @$condition.=" and n.province_id = ".$province->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 2):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($amphurs as $amphur):?>
			<tr>
				<th>
					<a href="diseases/report_staff/basic_column?year=<?=$_GET['year']?>&type=3&amphur_id=<?=$amphur->id?>"><?=$amphur->amphur_name?></a>
				</th>
				
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$amphur->id){ @$condition.=" and n.amphur_id = ".$amphur->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
				
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 3):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($districts as $district):?>
			<tr>
				<th>
					<a href="diseases/report_staff/basic_column?year=<?=$_GET['year']?>&type=4&district_id=<?=$district->id?>"><?=$district->district_name?></a>
				</th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$district->id){ @$condition.=" and n.district_id = ".$district->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<!-- <th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 4):?>
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2"><?=$text?></div>
	<table id="datatable" class="table">
		<thead>
			<tr>
		        <th>ศูนย์เด็กเล็กปลอดโรค</th>
		        <? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
	        </tr>
		</thead>
		<tbody>
			<?php foreach($nurseries as $nursery):?>
			<tr>
				<th>
					<?=$nursery->name?>
				</th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$nursery->id){ @$condition.=" and n.id = ".$nursery->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<!-- <th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php else:?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<? foreach($diseasesArray as $key=>$row):?>
				<th><?=$key?></th>
				<? endforeach;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($areas as $area):?>
			<tr>
				<th><a href="diseases/report_staff/basic_column?year=&type=1&area_id=<?=$area->id?>"><?=$area->area_name?></a></th>
				<? foreach($diseasesArray as $key=>$row):?>
					<?
						$condition = "";
						if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
						if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition.=" and cd.age between ".$_GET['lowage']." and ".$_GET['hiage']; }
						if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
						if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
						if(@$_GET['sex']){ @$condition.=" and cd.title = '".$_GET['sex']."'"; }
						if(@$area->id){ @$condition.=" and n.area_id = ".$area->id; }
				
						$sql = "
						SELECT count(d.id) total
						FROM
						diseases d
						INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
						INNER JOIN nurseries n ON d.nursery_id = n.id
						WHERE 1=1 and d.c1 = '".$row."' ".@$condition;
						$disease = new Disease();
						$disease->query($sql);

					?>
					<td><?=$disease->total?></td>
				<? endforeach;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<!-- <tr>
				<th>รวมทั้งหมด</th>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
			</tr> -->
		</tbody>
	</table>
<?php endif;?>
</div>
