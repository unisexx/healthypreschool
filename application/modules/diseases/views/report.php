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
                type: 'column',
                marginTop : 75
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

<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>


<form method="get" action="diseases/report">
<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<select name="classroom_id">
	<option value="">-- ทุกห้องเรียน --</option>
	<?foreach($classrooms as $row):?>
		<option value="<?=$row->id?>" <?=$row->id == @$_GET['classroom_id'] ? 'selected' : '' ;?>><?=$row->room_name?></option>
	<?endforeach;?>
	</select>
	
	ช่วงอายุ <input class="span1" type="text" name="lowage" value="<?=(@$_GET['lowage']) ? $_GET['lowage'] : '0' ;?>"> ถึง <input class="span1" type="text" name="hiage" value="<?=(@$_GET['hiage']) ? $_GET['hiage'] : 7 ;?>">
	
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
	</select>
	
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<!-- <a href="diseases/export_graphpage2/word?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">word</div></a>
<a href="diseases/export_graphpage2/excel?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">excel</div></a> -->

<?php $diseasesArray = array(
	'หวัด' => 'C', 
	'มือ เท้า ปาก' => 'H', 
	'อุจจาระร่วง' => 'D',
	'ไข้' => 'F',
	'ไข้ออกผื่น' => 'R',
	'อื่นๆ' => 'O'
);?>

<div style="display:none;">
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
				if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition .=" and TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) between ".$_GET['lowage']." and ".$_GET['hiage']; }
				if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
				if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
				
				$sql = "
				SELECT count(d.id) boy
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ช.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition." and start_date IS NOT NULL";
				$disease = new Disease();
				$disease->query($sql);
				
				$sql = "
				SELECT count(d.id) girl
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ญ.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition." and start_date IS NOT NULL";
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
</div>


<table class="table">
	<thead>
		<tr>
			<th></th>
			<th>ชาย</th>
			<th>หญิง</th>
			<th>รวม</th>
		</tr>
	</thead>
	<tbody>
		<?foreach($diseasesArray as $key=>$row):?>
			<?
				if(@$_GET['classroom_id']){ @$condition.=" and d.classroom_id = ".$_GET['classroom_id']; }
				if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ @$condition .=" and TIMESTAMPDIFF(YEAR, birth_date, CURDATE()) between ".$_GET['lowage']." and ".$_GET['hiage']; }
				if(@$_GET['year']){ @$condition.=" and d.year = ".$_GET['year'];  }
				if(@$_GET['month']){ @$condition.=" and d.month = ".$_GET['month'];  }
				
				// หาจำนวนครั้งที่เด็กป่วย
				$sql = "
				SELECT count(d.id) boy
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ช.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition." and start_date IS NOT NULL";
				$disease = new Disease();
				$disease->query($sql);
				// echo @$sql."<br><br>";
				
				$sql = "
				SELECT count(d.id) girl
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ญ.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition." and start_date IS NOT NULL";;
				$disease2 = new Disease();
				$disease2->query($sql);
				
				$sql = "
				SELECT count(d.id) total
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition." and start_date IS NOT NULL";;
				$disease3 = new Disease();
				$disease3->query($sql);
			?>
		<tr>
			<th><?=$key?></th>
			<td>
				<?if($disease->boy > 0):?>
					<a href="diseases/detail2?classroom_id=<?=@$_GET['classroom_id']?>&lowage=<?=@$_GET['lowage']?>&hiage=<?=@$_GET['hiage']?>&year=<?=@$_GET['year']?>&month=<?=@$_GET['month']?>&sex=<?=@$_GET['sex']?>&area_id=<?=@$area->id?>&c1=<?=@$row?>&title=ด.ช.&nursery_id=<?=user_login()->nursery_id?>" target="_blank"><?=$disease->boy?></a>
				<?else:?>
					<?=$disease->boy?>
				<?endif;?>
			</td>
			<td>
				<?if($disease2->girl > 0):?>
					<a href="diseases/detail2?classroom_id=<?=@$_GET['classroom_id']?>&lowage=<?=@$_GET['lowage']?>&hiage=<?=@$_GET['hiage']?>&year=<?=@$_GET['year']?>&month=<?=@$_GET['month']?>&sex=<?=@$_GET['sex']?>&area_id=<?=@$area->id?>&c1=<?=@$row?>&title=ด.ญ.&nursery_id=<?=user_login()->nursery_id?>" target="_blank"><?=$disease2->girl?></a>
				<?else:?>
					<?=$disease2->girl?>
				<?endif;?>
			</td>
			<td>
				<?if($disease3->total > 0):?>
					<a href="diseases/detail2?classroom_id=<?=@$_GET['classroom_id']?>&lowage=<?=@$_GET['lowage']?>&hiage=<?=@$_GET['hiage']?>&year=<?=@$_GET['year']?>&month=<?=@$_GET['month']?>&sex=<?=@$_GET['sex']?>&area_id=<?=@$area->id?>&c1=<?=@$row?>&nursery_id=<?=user_login()->nursery_id?>" target="_blank"><?=$disease3->total?></a>
				<?else:?>
					<?=$disease3->total?>
				<?endif;?>
			</td>
		</tr>
		<?endforeach;?>
	</tbody>
</table>