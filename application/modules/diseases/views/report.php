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
	</select>
	
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>

<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>

<?php $diseasesArray = array(
	'หวัด' => 'A', 
	'ข้หวัดใหญ่ตามฤดูกาล' => 'B', 
	'ไข้หวัดใหญ่สายพันธุ์ใหม่ 2009' => 'C',
	'อุจจาระร่วงเฉียบพลัน' => 'D',
	'อีสุกอีใส' => 'E',
	'คางทูม' => 'F',
	'ตาแดงหรือเยื่อบุตาอักเสบ' => 'G',
	'พิษสุนัขบ้าหรือโรคกลัวน้ำ' => 'H',
	'ไข้เลือดออก' => 'I',
	'ผิวหนังอักเสบจากเชื้อแบคทีเรีย' => 'J',
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
				WHERE 1=1 and cd.title = 'ด.ช.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition;
				$disease = new Disease();
				$disease->query($sql);
				
				$sql = "
				SELECT count(d.id) girl
				FROM
				diseases d
				INNER JOIN classroom_details cd ON d.classroom_detail_id = cd.id
				WHERE 1=1 and cd.title = 'ด.ญ.' and d.nursery_id = ".user_login()->nursery_id." and d.c1 = '".$row."' ".@$condition;
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