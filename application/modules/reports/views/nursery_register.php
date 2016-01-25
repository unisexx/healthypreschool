<?
	if(isset($_GET['classroom_id']) && ($_GET['classroom_id']!="")){
		$rs = new Classroom();
		$rs->where('id = ',$_GET['classroom_id'])->order_by('room_name','asc')->get();
	}elseif(isset($_GET['nursery_id']) && ($_GET['nursery_id']!="")){
		$rs = new Classroom();
		$rs->where('nursery_id = ',$_GET['nursery_id'])->order_by('room_name','asc')->get();
	}elseif(isset($_GET['district_id']) && ($_GET['district_id']!="")){
		$rs = new Nursery();
		$rs->where('district_id = ',$_GET['district_id'])->order_by('name','asc')->get();
	}elseif(isset($_GET['amphur_id']) && ($_GET['amphur_id']!="")){
		$rs = new District();
		$rs->where('amphur_id = ',$_GET['amphur_id'])->order_by('district_name','asc')->get();
	}elseif(isset($_GET['province_id']) && ($_GET['province_id']!="")){
		$rs = new Amphur();
		$rs->where('province_id = '.$_GET['province_id'])->order_by('amphur_name','asc')->get();
	}elseif(isset($_GET['area_id']) && ($_GET['area_id']!="")){
		$rs = new V_province();
		$rs->where('area_id = '.$_GET['area_id'])->order_by('name','asc')->get();
	}else{
		$rs = new Area();
		$rs->order_by('id','asc')->get();
	}
?>

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


<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><a href="reports/nursery_register">รายงานการสมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</a></li>
</ul>

<h1>รายงานแบบคัดกรองโรค</h1>

<form id="search_report" method="get" action="reports/nursery_register">
	<div>
		<span>ปี</span>
		<?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556'),@$_GET['year'],'class="span2"','-- สะสม 3 ปี --');?>
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
	    <!-- <span>ตำบล</span>
	    <span id="district">
	    <?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
	    </span> -->
	</div>

	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</form>







<?if(!empty($_GET)): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>







<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>


<table id="datatable" class="table table-bordered">
	<thead>
		<tr>
			<th></th>
			<th>เข้าร่วม</th>
			<th>ผ่านเกณฑ์</th>
			<th>รอการประเมิน</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($rs as $row):?>
		<tr>
			<th class="span2">
				<?
					//**********************************************
					if(@$_GET['district_id']!=""){
						//ชื่อศูนย์เด็กเล็ก + กราฟ categories
						echo $row->name;
						$categories[] = "'".$row->name."'";
					}elseif(@$_GET['amphur_id']!=""){
						//ชื่อตำบล + กราฟ categories
						echo $row->district_name;
						$categories[] = "'".$row->district_name."'";
					}elseif(@$_GET['province_id']!=""){
						//ชื่ออำเภอ + กราฟ categories
						echo $row->amphur_name;
						$categories[] = "'".$row->amphur_name."'";
					}elseif(@$_GET['area_id']!=""){
						//ชื่อจังหวัด + กราฟ categories
						echo $row->name;
						$categories[] = "'".$row->name."'";
					}else{
						// สคร.+ กราฟ categories
						echo $row->area_name;
						$categories[] = "'".$row->area_name."'";
					}
					//**********************************************
				?>
			</th>
				<?
					$condition = " 1=1 ";

					if(@$_GET['district_id']!=""){
						@$condition.=" and v_nurseries.district_id = ".$row->id;
					}elseif(@$_GET['amphur_id']!=""){
						@$condition.=" and v_nurseries.district_id = ".$row->id;
					}elseif(@$_GET['province_id']!=""){
						@$condition.=" and v_nurseries.amphur_id = ".$row->id;
					}elseif(@$_GET['area_id']!=""){
						@$condition.=" and v_provinces.id = ".$row->id;
					}else{
						@$condition.=" and v_provinces.area_id = ".$row->id;
					}
					//**********************************************


					if(@$_GET['year']!=""){
						@$condition.=" and v_nurseries.year = ".$_GET['year'];
					}
					$sql = "SELECT
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
							WHERE
								".@$condition."
						) nursery_register,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
							WHERE
								".@$condition."
							AND v_nurseries.`status` = 1
						) nursery_pass,
						(
							SELECT
								count(v_nurseries.id)
							FROM
								v_nurseries
							INNER JOIN v_provinces ON v_nurseries.area_province_id = v_provinces.area_province_id
							WHERE
								".@$condition."
							AND v_nurseries.`status` = 0
						) nursery_not
					";
					$nursery = new V_nursery();
					$nursery->query($sql);

					// echo $sql.'<br><br>';
				?>
			<td><?=$nursery->nursery_register?></td>
			<td><?=$nursery->nursery_pass?></td>
			<td><?=$nursery->nursery_not?></td>
		</tr>

		<?
			// สร้างตัวแปรสำหรับเจนกราฟ
			$nursery_register[] = convert_2_percent($nursery->nursery_register,$nursery->nursery_register);
			$nursery_pass[] = convert_2_percent($nursery->nursery_pass,$nursery->nursery_register);
			$nursery_not[] = convert_2_percent($nursery->nursery_not,$nursery->nursery_register);
		?>
		<?php endforeach;?>

	</tbody>
</table>

<?
/*
 * 	สร้างตัวแปรสำหรับเจนกราฟ
 */
	$categories = implode(",", $categories);
	$nursery_register  = implode(",", $nursery_register);
	$nursery_pass  = implode(",", $nursery_pass);
	$nursery_not  = implode(",", $nursery_not);
?>

<script type="text/javascript">
$(function () {
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: 'สรุปผลการดำเนินงานโครงการศูนย์เด็กเล็กปลอดโรคโดยรวมทั้งหมด'
        },
        // subtitle: {
            // text: 'Source: WorldClimate.com'
        // },
        xAxis: {
            categories: [<?=$categories?>],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'ร้อยละ'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f} %</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: 'เข้าร่วม',
            data: [<?=$nursery_register?>]

        }, {
            name: 'ผ่านเกณฑ์',
            data: [<?=$nursery_pass?>]

        }, {
            name: 'รอการประเมิน',
            data: [<?=$nursery_not?>]

        }]
    });
});
</script>





<?endif;?>
