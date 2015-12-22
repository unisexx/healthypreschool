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
  *margin-left: -326px;/*ie7*/
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
	width: 326px;
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
		width: 598px;
		margin-left: 346px;
	}
	.th_datatable {
		background: #0088CC !important;
		color: #FFFFFF;
		text-align:center !important;
	}
#datatable td{
	text-align:right;
}
tr.desease_total>th{
	background:#f4f4f4 !important;
	color:#000000 !important;
}
tbody>tr>th{
	background:#ffffff !important;
	color:#000000 !important;
}
tr.desease_total>td{
	background:#f4f4f4;
}
</style>
<script type="text/javascript" src="media/js/jquery.chained.remote.min.js"></script>
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
  	});
  	$("select[name='province_id']").live("change",function(){
  		$.post('ajax/get_amphur',{
  				'province_id' : $(this).val()
  			},function(data){
  				$("#amphur").html(data);
  			});
  	});

  	$("select[name='amphur_id']").live("change",function(){
  		$.post('ajax/get_district',{
  				'amphur_id' : $(this).val()
  			},function(data){
  				$("#district").html(data);
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
  <li class="active"><a href="report/desease_watch_menu">รายงานเหตุการณ์การเฝ้าระวังโรค</a></li>
 <li class="active"><a href="report/desease_watch_number">รายงานสรุปจำนวนเหตุการณ์การเฝ้าระวังโรค</a></li>  
</ul>

<h1>รายงานสรุปจำนวนเหตุการณ์การเฝ้าระวังโรค</h1>

<form method="get" enctype="multipart/form-data">
<div id="search_report" style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">   
	<div>
		<span>สคร.</span>		
		<?php echo form_dropdown('area_id',get_option('id','area_name','areas',' order by id '),@$_GET['area_id'],'id="area" class="span2"','--แสดงทั้งหมด--');?>
	</div>
	
	<div>
		<span>จังหวัด</span>
		<span id="province">
		<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
		</span>
	</div>
	
	<div>
		<span>อำเภอ</span>
		<span id="amphur">
		<?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
		</span>
	</div>
	
	<div>
		<span>ตำบล</span>
		<span id="district">
		<?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
		</span>
	</div>	
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
</div>
<?php
	$desease = New Desease_watch_name();	
	$desease->get();
	if(@$_GET['area_id']=='' && @$_GET['province_id']==''){
		$area = new Area();
		$area->get();
	}else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
		$province = new V_Province();
		$province->where('area_id = '.$_GET['area_id'])->get();
	}else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
		$amphur = new Amphur();
		$amphur->where('province_id = '.$_GET['province_id'])->get();
	}else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
		$district = new District();
		$district->where('amphur_id = '.$_GET['amphur_id'])->get();
	}else if(@$_GET['district_id']!=''){
		$nursery = new V_Nursery();
		$nursery->where('district_id = '.$_GET['district_id'])->get();
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
			
			<?php
			if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
				foreach($area as $area_row):
					echo '<td colspan="4"  class="th_datatable" style="width:400px;">'.$area_row->area_name.'</td>';
				endforeach;
			}else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
				foreach($province as $province_row):
					echo '<td colspan="4"  class="th_datatable" style="width:400px;">'.$province_row->name.'</td>';
				endforeach;
			}else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
				foreach($amphur as $amphur_row):
					echo '<td colspan="4"  class="th_datatable" style="width:400px;">'.$amphur_row->amphur_name.'</td>';
				endforeach;
			}else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
				foreach($district as $district_row):
					echo '<td colspan="4"  class="th_datatable" style="width:400px;">'.$district_row->district_name.'</td>';
				endforeach;
			}else if(@$_GET['district_id']!=''){
				foreach($nursery as $nursery_row):
					echo '<td colspan="4"  class="th_datatable" style="width:400px;">'.$nursery_row->name.'</td>';
				endforeach;
			}
			?>
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
			<?php
			if(@$_GET['area_id']=='' && @$_GET['province_id']==''){ 
				foreach($area as $area_row):
					echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
				endforeach;
			}else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
				foreach($province as $province_row):
					echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
				endforeach;
			}else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
				foreach($amphur as $amphur_row):
					echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
				endforeach;
			}else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
				foreach($district as $district_row):
					echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
				endforeach;
			}else if(@$_GET['district_id']!=''){
				foreach($nursery as $nursery_row):
					echo '<td class="th_datatable" style="">จำนวนอีเว้น</td><td class="th_datatable" style="">จำนวนผู้ป่วย</td><td class="th_datatable" style="">ชาย</td><td class="th_datatable" style="">หญิง</td>';
				endforeach;
			}
			?>
		</tr>	
	</thead>
	<tbody>
		<?php
			foreach($desease as $desease_row): 			
			$condition = " AND disease = ".$desease_row->id;
			$condition.= @$_GET['area_id']!='' && @$_GET['province_id'] == '' ? " AND v_nurseries.area_id = ".$_GET['area_id'] : '';
			$condition.= @$_GET['province_id']!='' && @$_GET['amphur_id'] == '' ? " AND v_nurseries.province_id = ".@$_GET['province_id'] : '';
			$condition.= @$_GET['amphur_id']!='' && @$_GET['district_id'] == '' ? " AND v_nurseries.amphur_id = ".@$_GET['amphur_id'] : '';
			$condition.= @$_GET['district_id']!='' ? " AND v_nurseries.district_id = ".@$_GET['district_id'] : '';
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
		<tr class="desease_total">
			<th>
				<?php echo $desease_row->desease_name;?>
			</th>
			<?php
			echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
			echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
			echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
			echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
			?>		
			<?php 
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
								1=1 ";
				$condition = " AND disease = ".$desease_row->id;								
				if(@$_GET['area_id']=='' && @@$_GET['province_id']==''){
					foreach($area as $area_row):				
						$ex_condition = " AND area_id = ".$area_row->id;						
						$desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
						echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';			
					endforeach;
				}else if(@$_GET['area_id']!='' && $_GET['province_id']==''){
					foreach($province as $province_row):				
						$ex_condition = " AND province_id = ".@$province_row->id;						
						$desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
						echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
					endforeach;
				}else if(@$_GET['province_id']!='' && $_GET['amphur_id']==''){
					foreach($amphur as $amphur_row):				
						$ex_condition = " AND amphur_id = ".@$amphur_row->id;						
						$desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
						echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
					endforeach;
				}else if(@$_GET['amphur_id']!='' && $_GET['district_id']==''){
					foreach($district as $district_row):				
						$ex_condition = " AND district_id = ".@$district_row->id;						
						$desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
						echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
					endforeach;
				}else if(@$_GET['district_id']!=''){
					foreach($nursery as $nursery_row):				
						$ex_condition = " AND nurseries_id = ".@$nursery_row->id;						
						$desease_age = $this->db->query($sql.$condition.$ex_condition)->result();
						echo $result = $desease_age[0]->n_event > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
						echo $result = $desease_age[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($desease_age[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
					endforeach;
				}
			?>
		</tr>
			<?php
				$condition = " AND disease = ".$desease_row->id;
				$condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
				$condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
				$condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
				$condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : '';
				$sql = " SELECT
							disease,
							age_duration_start age_start,
							age_duration_end age_end,
							CONCAT('อายุ ',age_duration_start, ' ถึง ', age_duration_end) age_range							
						FROM
							disease_watch
							LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
						WHERE
							1=1 ".$condition."
						group by age_duration_start, age_duration_end
						order by age_duration_start
						";
				$desease_age = $this->db->query($sql)->result();
				foreach($desease_age as $age):
					$condition = " AND disease = ".$desease_row->id." AND age_duration_start = ".$age->age_start." AND age_duration_end = ".$age->age_end;
					$condition.= @$_GET['area_id'] != '' && @$_GET['province_id'] == '' ? " AND area_id = ".$_GET['area_id'] : '';
					$condition.= @$_GET['province_id'] != '' && @$_GET['amphur_id'] == '' ? " AND province_id = ".$_GET['province_id'] : '';
					$condition.= @$_GET['amphur_id'] != '' && @$_GET['district_id'] == '' ? " AND amphur_id = ".$_GET['amphur_id'] : '';
					$condition.= @$_GET['district_id'] != '' ? " AND district_id = ".$_GET['district_id'] : ''; 
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
				<tr class="desease_age_range">
					<th>
						<?php echo $age->age_range;?>
					</th>
					<?php
					echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
					echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
					echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
					echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
					?>
					<?php 
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
								LEFT JOIN v_nurseries on disease_watch.nurseries_id = v_nurseries.id
							WHERE
								1=1 ";
					if(@$_GET['area_id']==''&&@ $_GET['province_id']==''){
						foreach($area as $area_row):
							$ex_condition = " AND area_id = ".$area_row->id;										
							$value = $this->db->query($sql.$condition.$ex_condition)->result();
							//if($area_row->id == 3) echo $sql.$condition.';';
							echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
						endforeach;
					}else if(@$_GET['area_id']!='' && @$_GET['province_id']==''){
						foreach($province as $province_row):
							$ex_condition = " AND province_id = ".$province_row->id;			
							$value = $this->db->query($sql.$condition.$ex_condition)->result();
							echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
						endforeach;
					}else if(@$_GET['province_id']!='' && @$_GET['amphur_id']==''){
						foreach($amphur as $amphur_row):
							$ex_condition = " AND amphur_id = ".$amphur_row->id;			
							$value = $this->db->query($sql.$condition.$ex_condition)->result();
							echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
						endforeach;
					}else if(@$_GET['amphur_id']!='' && @$_GET['district_id']==''){
						foreach($district as $district_row):
							$ex_condition = " AND district_id = ".$district_row->id;			
							$value = $this->db->query($sql.$condition.$ex_condition)->result();
							echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
						endforeach;
					}else if(@$_GET['district_id']!=''){
						foreach($nursery as $nursery_row):
							$ex_condition = " AND nurseries_id = ".$nursery_row->id;			
							$value = $this->db->query($sql.$condition.$ex_condition)->result();
							echo $result = $value[0]->n_event > 0 ? '<td>&nbsp;'.number_format($value[0]->n_event,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->total_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->total_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->boy_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->boy_amount,0).'</td>' : '<td>&nbsp;</td>';
							echo $result = $value[0]->girl_amount > 0 ? '<td>&nbsp;'.number_format($value[0]->girl_amount,0).'</td>' : '<td>&nbsp;</td>';
						endforeach;
					}
					?>
				</tr>
			<?php endforeach; //end desease_age_row?>
		<?php endforeach; //end desease?>
	</tbody>
</table>
</div>
</div>