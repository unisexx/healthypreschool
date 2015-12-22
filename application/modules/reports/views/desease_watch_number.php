<style type="text/css">
#search_report>div{
	padding-top:10px;
	padding-bottom:10px;
}	

#datatable .desease_age_range>td{
	text-align:right;
}
</style>
<style type="text/css">
#datatable{
  table-layout: fixed; 
  *margin-left: -240px;/*ie7*/
}
#datatable td, th {
  vertical-align: top;
  /*border-top: 1px solid #ccc;*/
  padding:10px;
}
#datatable th {
  position:absolute;
  *position: relative; /*ie7*/
	left: 0;
	width: 220px;
	border-right: 1px solid #ccc;
	margin-top: 0px;
	font-weight: normal;
	padding: 10px;
	font-weight:normal;
	}
	.outer {
		position: relative
	}
	.inner {
		overflow-x: scroll;
		overflow-y: visible;
		width: 944px;
		margin-left: 240px;
	}
	.th_datatable {
		background: #0088CC !important;
		color: #FFFFFF;
		text-align:center !important;
	}
#datatable td{
	text-align:right;
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
  <li class="active"><a href="report/desease_watch_menu">รายงานเหตุการณ์การเฝ้าระวังโรค</a></li>
 <li class="active"><a href="report/desease_watch_number">รายงานสรุปจำนวนเหตุการณ์การเฝ้าระวังโรค</a></li>  
</ul>

<h1>รายงานสรุปจำนวนเหตุการณ์การเฝ้าระวังโรค</h1>

<form method="get" action="diseases/newreport">
<div id="search_report" style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">   
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
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>
<?php
	$desease = New Desease_watch_name();	
	$desease->get();
	if(@$_GET['area_id']=='' && @$_GET['province_id']==''){
		$area = new Area();
		$area->get();
	}
?>
<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
<div class="outer"> 
  <div class="inner">
<table id="datatable" class="table table-bordered">
	<thead>
		<tr>
			<th style="height:100px;background:#fff !important;border-left:none;">
				
			</th>
			<td colspan="4" class="th_datatable" style="width:400px;">
				รวม
			</td>
			<?php foreach($area as $area_row):?>
			<td colspan="4"  class="th_datatable" style="width:400px;">
				<?php echo $area_row->area_name;?>
			</td>
			<?php endforeach //end area_row?>
		</tr>
		<tr>	
			<th>
				โรค
			</th>
			<td class="th_datatable" style="">
				จำนวนอีเว้น
			</td>
			<td class="th_datatable" style="">
				จำนวนผู้ป่วย
			</td>
			<td class="th_datatable" style="">
				ชาย
			</td>
			<td class="th_datatable" style="">
				หญิง
			</td>	
			<?php foreach($area as $area_row):?>
			<td class="th_datatable" style="">
				จำนวนอีเว้น
			</td>
			<td class="th_datatable" style="">
				จำนวนผู้ป่วย
			</td>
			<td class="th_datatable" style="">
				ชาย
			</td>
			<td class="th_datatable" style="">
				หญิง
			</td>
			<?php endforeach //end area_row?>
		</tr>	
	</thead>
	<tbody>
		<?php
			foreach($desease as $desease_row): 
			
			$condition = " AND disease = ".$desease_row->id;
			$sql = " SELECT
						disease,
						age_duration_start age_start,
						age_duration_end age_end,
						CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
						COUNT(disease_watch.id)n_event,
					    SUM(total_amount)total_amount,
						SUM(boy_amount)boy_amount,
						SUM(girl_amount)girl_amount
					FROM
						disease_watch
					WHERE
						1=1 ".$condition;					
			$desease_age = $this->db->query($sql)->result();
		?>
		<tr class="desease_total">
			<th>
				<?php echo $desease_row->desease_name;?>
			</th>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->n_event,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->total_amount,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->boy_amount,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->girl_amount,0);?>
			</td>		
			<?php 
				foreach($area as $area_row):
					$condition = " AND disease = ".$desease_row->id. " AND area_id = ".$area_row->id;
					$sql = " SELECT
								disease,
								age_duration_start age_start,
								age_duration_end age_end,
								CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
								COUNT(disease_watch.id)n_event,
							    SUM(total_amount)total_amount,
								SUM(boy_amount)boy_amount,
								SUM(girl_amount)girl_amount
							FROM
								disease_watch
								LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
							WHERE
								1=1 ".$condition;
					$desease_age = $this->db->query($sql)->result();
			?>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->n_event,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->total_amount,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->boy_amount,0);?>
			</td>
			<td>
				&nbsp;<?php echo number_format($desease_age[0]->girl_amount,0);?>
			</td>
			<?php endforeach //end area_row?>	
		</tr>
			<?php
				$condition = " AND disease = ".$desease_row->id;
				$sql = " SELECT
							disease,
							age_duration_start age_start,
							age_duration_end age_end,
							CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range							
						FROM
							disease_watch
						WHERE
							1=1 ".$condition."
						group by age_duration_start, age_duration_end";
				$desease_age = $this->db->query($sql)->result();
				foreach($desease_age as $age):
					$condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
					$sql = " SELECT
								disease,
								age_duration_start age_start,
								age_duration_end age_end,
								CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
								COUNT(disease_watch.id)n_event,
							    SUM(total_amount)total_amount,
								SUM(boy_amount)boy_amount,
								SUM(girl_amount)girl_amount							
							FROM
								disease_watch
							WHERE
								1=1 ".$condition;
					$value = $this->db->query($sql)->result();							
			?>
				<tr class="desease_age_range">
					<th>
						<?php echo $age->age_range;?>
					</th>
					<td>
						<?php echo number_format($value[0]->n_event,0);?>
					</td>
					<td>
						<?php echo number_format($value[0]->total_amount,0);;?>
					</td>
					<td>
						<?php echo number_format($value[0]->boy_amount,0);?>
					</td>
					<td>
						<?php echo number_format($value[0]->girl_amount,0);?>
					</td>
					<?php 
						foreach($area as $area_row):
							$condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end." AND area_id = ".$area_row->id;
							$sql = " SELECT
										disease,
										age_duration_start age_start,
										age_duration_end age_end,
										CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range,
										COUNT(disease_watch.id)n_event,
									    SUM(total_amount)total_amount,
										SUM(boy_amount)boy_amount,
										SUM(girl_amount)girl_amount							
									FROM
										disease_watch
										LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
									WHERE
										1=1 ".$condition;
							$value = $this->db->query($sql)->result();
					?>
					<td>
						<?php echo number_format($value[0]->n_event,0);?>
					</td>
					<td>
						<?php echo number_format($value[0]->total_amount,0);;?>
					</td>
					<td>
						<?php echo number_format($value[0]->boy_amount,0);?>
					</td>
					<td>
						<?php echo number_format($value[0]->girl_amount,0);?>
					</td>
					<?php endforeach //end area_row?>
				</tr>
			<?php endforeach; //end desease_age_row?>
		<?php endforeach; //end desease?>
	</tbody>
</table>
</div>
</div>