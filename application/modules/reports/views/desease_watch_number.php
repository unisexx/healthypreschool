<?php
switch(@$_GET['place_type']){
    case '2':
        $place_type_name = 'พื้นที่ชุมชน';
        break;
    case '1':
        $place_type_name = 'ศูนย์เด็กเล็ก';
        break;
    default:
        $place_type_name = 'ทั้งหมด';
        break;
}
?>
<base href="<?php echo base_url(); ?>" />
<style type="text/css">
#search_report>div{
	padding-top:10px;
	padding-bottom:10px;
}

#datatable{
  /*table-layout: fixed;*/
  *margin-left: -326px;/*ie7*/
}
#datatable td, th {
  vertical-align: top;
  /*border-top: 1px solid #ccc;*/
  padding:10px;
}
#datatable th {
  /*position:absolute;
  *position: relative; /*ie7*/
	left: 0;
	width: 172px;
	border-right: 1px solid #ccc;
	margin-top: 0px;
	font-weight: normal;
	padding: 10px;
	font-weight:normal;
}
.outer {
/*	position: relative*/
}
.inner {
/*	overflow-x: scroll;
	overflow-y: visible;
	width:752px;
	margin-left: 192px;*/
}
.th_datatable {
	background: #0088CC !important;
	color: #FFFFFF;
	text-align:center !important;
}
#datatable>thead>tr>td{
	/*width:650px !important;*/
}
#datatable td{
	text-align:right;
}
tr.year_total>th{
    background:#d9ffbf !important;
    color:#000000 !important;
}
tr.year_total>td{
    background:#d9ffbf !important;
    color:#000000 !important;
}
tr.month_total>th{
    background:#ffe2bf !important;
    color:#000000 !important;
}
tr.month_total>td{
    background:#ffe2bf !important;
    color:#000000 !important;
}
tr.desease_total>th{
    background:#fff2cc !important;
    color:#000000 !important;
}
tr.desease_total>td{
    background:#fff2cc !important;
}
#datatable .desease_age_range>th{
    text-align:right;
    background:#f4f4f4 !important;
}
#datatable .desease_age_range>td{
    text-align:right;
    background:#f4f4f4 !important;
}
tbody>tr>th{
	background:#ffffff !important;
	color:#000000 !important;
}
.th_total{
    width:150px !important;
}
</style>
<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>

<?php 
if(@$_GET['export_type']==''){
?>
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
    
     
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><a href="#">รายงานจำนวนเหตุการณ์การเฝ้าระวังโรคติดต่อ</a></li>
</ul>

<h1>รายงานจำนวนเหตุการณ์การเฝ้าระวังโรคติดต่อ</h1>

<form method="get" enctype="multipart/form-data">
<div id="search_report" style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
    <div>
        <span>โรค</span>
        <?php echo form_dropdown('disease', get_option('id', 'desease_name', 'desease_watch_names', ' order by id '), @$_GET['disease'], '', '--แสดงทั้งหมด--');?>
        
        <span>พื้นที่ที่เกิดโรค</span>
        <select name="place_type" class="form-control">
                <option value="">-- ทั้งหมด --</option>
                <option value="2" <?php echo $selected = @$_GET['place_type'] == 2 ? 'selected="selected"' : '';?>>พื้นที่ชุมชน</option>
                <option value="1" <?php echo $selected = @$_GET['place_type'] == 1 ? 'selected="selected"' : '';?>>ศูนย์เด็กเล็ก/โรงเรียนอนุบาล</option>
        </select>
        
        <!--
        <span>ช่วงอายุ</span>
        <?php echo form_dropdown('age_range',get_option('age_range_param','age_range','v_disease_watch_age_range'),@$_GET['age_range'],'','--แสดงทั้งหมด--');?>
        -->
    </div>

	<div>
		<span>สคร.</span>
		<?php echo form_dropdown('area_id',get_option('id','area_name','areas',' order by id '),@$_GET['area_id'],'id="area" class="span2"','--แสดงทั้งหมด--');?>
	</div>

	<div>
		<span>จังหวัด</span>
		<span id="province">
		<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id'],true);?>
		</span>
		<span>อำเภอ</span>
        <span id="amphur">
        <?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id'],true);?>
        </span>
        <span>ตำบล</span>
        <span id="district">
        <?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id'],true);?>
        </span>
	</div>

	<div>
		<span>ช่วงเวลาการแสดงผล</span>
		<span id="range_type">
			<select name="range_type">
				<option value="">--ไม่ระบุ--</option>
				<option value="year" <?php echo $selected = @$_GET['range_type']=='year' ?  'selected="selected"':'';?>>ระหว่างปี</option>
				<option value="month_year" <?php echo $selected = @$_GET['range_type']=='month_year' ?  'selected="selected"':'';?>>รายเดือนของปี</option>
				<option value="time" <?php echo $selected = @$_GET['range_type']=='time' ?  'selected="selected"':'';?>>ช่วงวันที่</option>
			</select>
		</span>
	</div>
	<div id="year_range" style="<?php echo $display = @$_GET['range_type']!='year'? 'display:none;' : '';?>">
		<span>ช่วงเวลาที่เกิดโรค ระหว่างปี</span>
		ปีที่เริ่ม
		<select name="report_start_year">
			<option value="">--ระบุปีที่เริ่ม--</option>
			<?php
				$sql_year = " SELECT
								DISTINCT YEAR (start_date)report_year
							FROM
								disease_watch
						 order by report_year desc
						";
				$report_year_list = $this->db->query($sql_year)->result();
				foreach($report_year_list as $row):
			?>
			<option value="<?php echo $row->report_year;?>" <?php echo $selected = @$_GET['report_start_year']==$row->report_year ?  'selected="selected"':'';?>><?php echo $row->report_year + 543;?></option>
			<?php endforeach;?>
		</select>
		ปีที่สิ้นสุด
		<select name="report_end_year">
			<option value="">--ระบุปีที่สิ้นสุด--</option>
			<?php
				$report_year_list = $this->db->query($sql_year)->result();
				foreach($report_year_list as $row):
			?>
			<option value="<?php echo $row->report_year;?>" <?php echo $selected = @$_GET['report_end_year']==$row->report_year ?  'selected="selected"':'';?>><?php echo $row->report_year + 543;?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div id="month_year_range" style="<?php echo $display = @$_GET['range_type']!='month_year'? 'display:none;' : '';?>">
		<span>ช่วงเวลาที่เกิดโรค รายเดือนของ</span>
		<select name="report_month_year">
			<option value="">แต่ล่ะเดือนของทุกปี</option>
			<?php
				$report_year_list = $this->db->query($sql_year)->result();
				foreach($report_year_list as $row):
			?>
			<option value="<?php echo $row->report_year;?>" <?php echo $selected = @$_GET['report_month_year']==$row->report_year ?  'selected="selected"':'';?>><?php echo $row->report_year + 543;?></option>
			<?php endforeach;?>
		</select>
	</div>
	<div id="time_range" style="<?php echo $display = @$_GET['range_type']!='time'? 'display:none;' : '';?>">
		<span>ช่วงเวลาที่เกิดโรค</span>
		วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
		วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
	</div>	
	<input class="btn btn-primary" type="submit" value=" แสดง " style="margin-bottom: 10px;">
</div>
<?php }else{?>
    <link rel="stylesheet" href="media/js/bootstrap/css/bootstrap.min.css" type="text/css">
    <script type="text/javascript" src="media/js/jquery-1.4.2.min.js"></script>
    <link rel="stylesheet" href="media/js/date_input/date_input.css" type="text/css" media="screen">
    <script type="text/javascript" src="media/js/date_input/jquery.date_input.min.js"></script>
    <script type="text/javascript" src="media/js/date_input/jquery.date_input.th_TH.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="http://code.highcharts.com/modules/exporting.js"></script>
    <script src="http://code.highcharts.com/modules/offline-exporting.js"></script>
    <script type="text/javascript" src="media/js/rgbcolor.js"></script>
    <script type="text/javascript" src="media/js/canvg.js"></script>
<?php } ?>    
<?php if(@$_GET): ?>
<div style="text-align:right;padding-top:30px;">ข้อมูล ณ วันที่ <?php echo mysql_to_th(date("Y-m-d H:i:s"));?></div>
<div id="report_header" style="text-align:center;">    
    <h4>รายงานข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ</h4>
    <?php
    if(@$_GET['area_id']=='' && @$_GET['province_id']==''){
        echo '<h5>จำแนกตามพื้นที่ สคร. 13 เขต </h5>';
        echo '<h5>พื้นที่ที่เกิดโรค '.$place_type_name.'</h5>';
    }else if(@$_GET['area_id']!=''&&@$_GET['province_id']==''){
        $area_title = $this->db->query('select * from areas where id = '.$_GET['area_id'])->result();
        echo '<h5>จำแนกตามจังหวัด ในเขตพื้นที่ '.$area_title[0]->area_name.'</h5>';
        echo '<h5>พื้นที่ที่เกิดโรค '.$place_type_name.'</h5>';
    }else if(@$_GET['province_id']!=''&&@$_GET['amphur_id']==''){
        $province_title = $this->db->query('select * from provinces where id = '.$_GET['province_id'])->result();
        echo '<h5>จำแนกตามอำเภอ ในเขตพื้นที่จังหวัด  '.$province_title[0]->name.'</h5>';
        echo '<h5>พื้นที่ที่เกิดโรค '.$place_type_name.'</h5>';
    }else if(@$_GET['amphur_id']!=''&&@$_GET['district_id']==''){
        $province_title = $this->db->query('select * from provinces where id = '.$_GET['province_id'])->result();
        $amphur_title = $this->db->query('select * from amphures where id = '.$_GET['amphur_id'])->result();
        echo '<h5>จำแนกตามพื้นที่ตำบล ในเขตพื้นที่ เขต/อำเภอ '.$amphur_title[0]->amphur_name.' จังหวัด '.$province_title[0]->name.'</h5>';
        echo '<h5>พื้นที่ที่เกิดโรค '.$place_type_name.'</h5>';
    }else if(@$_GET['district_id']!=''){
        $province_title = $this->db->query('select * from provinces where id = '.$_GET['province_id'])->result();
        $amphur_title = $this->db->query('select * from amphures where id = '.$_GET['amphur_id'])->result();
        $district_title = $this->db->query('select * from districts where id = '.$_GET['district_id'])->result();
        echo '<h5>จำแนกตามศูนย์เด็กเล็กและโรงเรียนอนุบาล ในเขตพื้นที่ แขวง/ตำบล '.$district_title[0]->district_name.' เขต/อำเภอ '.$amphur_title[0]->amphur_name.' จังหวัด '.$province_title[0]->name.'</h5>';
        echo '<h5>พื้นที่ที่เกิดโรค '.$place_type_name.'</h5>';
    }

    switch(@$_GET['range_type']){
        case 'year':
            $start_year = @$_GET['report_end_year']!='' ? @$_GET['report_end_year'] : date("Y");
            $end_year =   @$_GET['report_start_year']!='' ? @$_GET['report_start_year'] : $start_year-5;
            echo '<h5>ระหว่างปี '.($end_year+543).' ถึง ปี'.($start_year+543).'</h5>';
        break;
        case 'month_year':
            if(@$_GET['report_month_year']!='')
                echo '<h5>จำแนกตามเดือน  ของ ปี'.($_GET['report_month_year']+543).'</h5>';
            else
                echo '<h5>จำแนกตามเดือน  จากข้อมูลทั้งหมด</h5>';
        break;
        case 'time':
            $start_date = @$_GET['start_date']!='' ? @$_GET['start_date'] : '';
            $end_date = @$_GET['end_date']!='' ? @$_GET['end_date'] : '';
            if($start_date!='' && $end_date != ''){
                echo '<h5>ระหว่างวันที่ '.$start_date.' ถึง '.$end_date.'</h5>';
            }else if($start_date!='' && $end_date==''){
                echo '<h5>ตั้งแต่วันที่ '.$start_date.' ถึง ณ ปัจจุบัน </h5>';
            }else if($start_date=='' && $end_date!=''){
                echo '<h5>ข้อมูล ถึง ณ วันที่ '.$end_date.'</h5>';
            }else{

            }
        break;
        default:
        break;
    }


?>
</div>
<?php
    switch(@$_GET['range_type']){
        case 'year':                       
            echo Modules::run("reports/desease_watch_number_table_year");
        break;
        case 'month_year':
            echo Modules::run("reports/desease_watch_number_table_month_year");
        break;
        case 'time':
            echo Modules::run("reports/desease_watch_number_table_default");
        break;
        default:
            echo Modules::run("reports/desease_watch_number_table_default");
        break;
    }
    echo Modules::run("reports/desease_watch_number_symptom");
?>
<?php endif;?>
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

  	$("select[name=range_type]").live("change",function(){
  		var range_type = $(this).val();
  		$("#year_range").hide();
  		$("#month_year_range").hide();
  		$("#time_range").hide();
  		switch(range_type){
  		    case 'year':
  		        $("#year_range").show();
  		    break;
  		    case 'month_year':
                $("#month_year_range").show();
            break;
            case 'time':
                $("#time_range").show();
            break;
  		}
  	});
  	
});
</script>
