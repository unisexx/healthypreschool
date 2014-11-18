<?php
// ถ้าไม่มีการเลือกจากการค้นหา ให้กำหนด เป็นเดือนปัจจุบัน ปีปัจจุบัน สคร.1 โรคหวัด
@$_GET['month'] = !$_GET['month'] ? date("m") : $_GET['month'];
@$_GET['year'] = !$_GET['year'] ? date("Y")+543 : $_GET['year'];
@$_GET['diseases'] = !$_GET['diseases'] ? 'C' : $_GET['diseases'];
@$_GET['type'] = !$_GET['type'] ? '1' : $_GET['type'];
@$_GET['area_id'] = $_GET['type'] == 1 && !$_GET['area_id'] ? '1' : $_GET['area_id'];
@$_GET['province_id'] = !$_GET['province_id'] ? $_GET['province_id'] : $_GET['province_id'];
@$_GET['amphur_id'] = !$_GET['amphur_id'] ? $_GET['amphur_id'] : $_GET['amphur_id'];
@$_GET['district_id'] = !$_GET['district_id'] ? $_GET['district_id'] : $_GET['district_id'];
@$_GET['nursery_id'] = !$_GET['nursery_id'] ? $_GET['nursery_id'] : $_GET['nursery_id'];

$arrdiseases = array('C'=>'หวัด','H'=>'มือ เท้า ปาก','D'=>'อุจจาระร่วง','F'=>'ไข้','R'=>'ไข้ออกผื่น','O'=>'อื่นๆ');

$arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);

$arrayMonthDay = array('1' => '31', '2' => '28', '3' => '31', '4' => '30', '5' => '31', '6' => '30', '7' => '31', '8' => '31', '9' => '30', '10' => '31', '11' => '30', '12' => '31',);

$base = array("1"=>"null","2"=>"null", "3"=>"null", "4"=>"null", "5"=>"null", "6"=>"null", "7"=>"null", "8"=>"null", "9"=>"null", "10"=>"null", "11"=>"null", "12"=>"null", "13"=>"null",
				"14"=>"null", "15"=>"null", "16"=>"null", "17"=>"null", "18"=>"null", "19"=>"null", "20"=>"null", "21"=>"null", "22"=>"null", "23"=>"null", "24"=>"null", "25"=>"null",
				"26"=>"null", "27"=>"null", "28"=>"null", "29"=>"null", "30"=>"null", "31"=>"null");

// foreach($bmis as $bmi){
	// $replacements[$bmi->child_age_year.'-'.$bmi->child_age_month] = $bmi->height;
// }

// @$heights = array_replace($base, $replacements);

@$condition .= " 1=1 ";
$_GET['year'] ? $condition .= " and diseases.year = ".$_GET['year'] : '';
$_GET['month'] ? $condition .= " and diseases.month = ".$_GET['month'] : '';
$_GET['diseases'] ? $condition .= " and diseases.c1 = '".$_GET['diseases']."'" : '';
$_GET['area_id'] ? $condition .= " and nurseries.area_id = ".$_GET['area_id'] : '';
$_GET['province_id'] ? $condition .= " and nurseries.province_id = ".$_GET['province_id'] : '';
$_GET['amphur_id'] ? $condition .= " and nurseries.amphur_id = ".$_GET['amphur_id'] : '';
$_GET['district_id'] ? $condition .= " and nurseries.district_id = ".$_GET['district_id'] : '';
$_GET['nursery_id'] ? $condition .= " and nurseries.id = ".$_GET['nursery_id'] : '';
if(@$_GET['lowage'] != "" && @$_GET['hiage'] != ""){ $condition .=  " and child_age_year between ".$_GET['lowage']." and ".$_GET['hiage']; }

// ----- หัวข้อกราฟ -----
$_GET['area_id'] ? @$text .= "ประจำ สคร.".$_GET['area_id'] : '';
$_GET['province_id'] ? @$text .= "จังหวัด".get_province_name($_GET['province_id']) : '';
$_GET['amphur_id'] ? @$text .= " อำเภอ".get_amphur_name($_GET['amphur_id']) : '';
$_GET['district_id'] ? @$text .= " ตำบล".get_district_name($_GET['district_id']) : '';
$_GET['nursery_id'] ? @$text .= " ศูนย์เด็กเล็ก".get_nursery_name($_GET['nursery_id']) : '';

for($i=1;$i<=$arrayMonthDay[$_GET['month']];$i++):
	$sql = "SELECT count(diseases.id) total
	FROM
	classroom_details
	INNER JOIN diseases ON diseases.classroom_detail_id = classroom_details.id
	INNER JOIN nurseries ON classroom_details.nursery_id = nurseries.id
	WHERE ".$condition." AND classroom_details.title='ด.ช.' AND diseases.day = ".$i;
	$data['disease_count'] = $this->db->query($sql)->result();
	
	$replacements[$i] = $data['disease_count'][0]->total;
endfor;

@$boys = array_replace($base, $replacements);

for($i=1;$i<=$arrayMonthDay[$_GET['month']];$i++):
	$sql = "SELECT count(diseases.id) total
	FROM
	classroom_details
	INNER JOIN diseases ON diseases.classroom_detail_id = classroom_details.id
	INNER JOIN nurseries ON classroom_details.nursery_id = nurseries.id
	WHERE ".$condition." AND classroom_details.title='ด.ญ.' AND diseases.day = ".$i;
	$data['disease_count'] = $this->db->query($sql)->result();
	
	$replacements[$i] = $data['disease_count'][0]->total;
endfor;

@$girls = array_replace($base, $replacements);
?>

<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/data.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>

<script type="text/javascript">
$(function () {
    $('#container1').highcharts({
    	chart: {
            type: 'line'
        },
        title: {
            text: 'กราฟแสดงการเฝ้าระวังโรค<?=$arrdiseases[$_GET['diseases']]?> <?=$text?> เดือน<?=$arrayMonth[$_GET['month']]?> ปี <?=$_GET['year']?>',
            style: {
                fontSize: '16px'
            }
        },
        xAxis: {
        	title: {
                text: 'วันที่'
            },
            categories: ['1','2','3','4','5','6','7','8','9','10','11','12',
            			'13','14','15','16','17','18','19','20','21','22','23','24',
            			'25','26','27','28','29','30','31']
        },
        yAxis: {
        	title: {
                text: 'จำนวน (ครั้ง)'
			}
			,allowDecimals: false
			,min: 0
            ,startOnTick: false
        },
        tooltip: {
            shared: true,
            valueSuffix: ' ซม.'
        },
        credits: {
            enabled: false
        },
        plotOptions: {
            areaspline: {
                fillOpacity: 0.5
            },
            series: {
                connectNulls: true
            },
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'ชาย',
            data: [<?foreach($boys as $boy):?><?=$boy?>,<?endforeach;?>]
        },{
        	color: '#f15c80',
            name: 'หญิง',
            data: [<?foreach($girls as $girl):?><?=$girl?>,<?endforeach;?>]
        }],
        exporting: { enabled: false }
    });
    
    $("select[name='province_id']").live("change",function(){
		$.post('nurseries/nurseries/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$("#amphur").html(data);
			});
	});
	
	$("select[name='amphur_id']").live("change",function(){
		$.post('nurseries/nurseries/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$("#district").html(data);
			});
	});
	
	$("select[name='district_id']").live("change",function(){
		$.post('surveillances/get_nursery',{
				'district_id' : $(this).val()
			},function(data){
				$("#nursery").html(data);
			});
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
			$("#province,#amphur").show();
			$("#area,#district").hide();
			$("select[name=province_id],select[name=area_id],select[name=district_id]").val("0");
           break;
           case '4':
			$("#province,#amphur,#district").show();
			$("#area").hide();
			$("select[name=province_id],select[name=amphur_id],select[name=area_id]").val("0");
           break;
           case '5':
			$("#province,#amphur,#district,#nursery").show();
			$("#area").hide();
			$("select[name=province_id],select[name=amphur_id],select[name=district_id],select[name=area_id]").val("0");
           break;
		}
	});
    
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li>การเฝ้าระวังโรค</li>
</ul>

<form method="get" action="">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">	
	
	<select name="month" style="margin-bottom:5px;">
	<?for($i=1;$i<=12;$i++):?>
        	<option value="<?=$i?>" <?=($_GET['month']==$i)?"selected":"";?>><?=$arrayMonth[$i]?></option>
    <?endfor;?>
    </select>
        	
	<?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556','2557'=>'2557'),@$_GET['year']);?>
	
	<?=form_dropdown('type',array('1'=>'สคร.','2'=>'จังหวัด','3'=>'อำเภอ','4'=>'ตำบล','5'=>'ศูนย์เด็กเล็ก'),@$_GET['type'],'','--- แยกตาม ---');?>
	
	<span id="area" <?=(@$_GET['area_id'] == "")?'style="display:none;"':'';?>>
	<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'','--- เลือกสคร. ---');?>
	</span>
	
	<span id="province" <?=(@$_GET['province_id'] == "")?'style="display:none;"':'';?>>
	<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	</span>
   	
	<span id="amphur" <?=(@$_GET['amphur_id'] == "")?'style="display:none;"':'';?>>
		<?$condition2 = $_GET['province_id'] ? " where province_id = ".$_GET['province_id'] : '' ; ?>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures',$condition2.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	</span>
	
	<span id="district" <?=(@$_GET['district_id'] == "")?'style="display:none;"':'';?>>
		<?
			$condition3 .= " where 1=1 ";
			$condition3 .= $_GET['province_id'] ? " and province_id = ".$_GET['province_id'] : '' ; 
			$condition3 .= $_GET['amphur_id'] ? " and amphur_id = ".$_GET['amphur_id'] : '' ; 
		?>
		<?=form_dropdown('district_id',get_option('id','district_name','districts',$condition3.' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
	</span>
	
	<span id="nursery" <?=(@$_GET['nursery_id'] == "")?'style="display:none;"':'';?>>
		<?$condition4 = $_GET['district_id'] ? " where district_id = ".$_GET['district_id'] : '' ; ?>
		<?=form_dropdown('nursery_id',get_option('id','name','nurseries',$condition4.' order by name asc'),@$_GET['nursery_id'],'','--- เลือกศูนย์เด็กเล็ก ---');?>
	</span>
	
	<?=form_dropdown('diseases',array('C'=>'หวัด','H'=>'มือ เท้า ปาก','D'=>'อุจจาระร่วง','F'=>'ไข้','R'=>'ไข้ออกผื่น','O'=>'อื่นๆ'),@$_GET['diseases'],'');?>
	
	ช่วงอายุ <input class="span1" type="text" name="lowage" value="<?=(@$_GET['lowage']) ? $_GET['lowage'] : '0' ;?>"> ถึง <input class="span1" type="text" name="hiage" value="<?=(@$_GET['hiage']) ? $_GET['hiage'] : 7 ;?>">
	
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	</div>
</form>


<div id="container1" style="min-width: 310px; height: 400px; margin: 0 auto"></div>