<? $arrayTotalAll = array("720", "705", "1298", "2000", "1971", "3433", "2916", "835", "1189", "2776", "1069", "1230");?>
<?php 
function convert_2_percent($number,$total){
	return @number_format(($number / $total) * 100,2);
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
                }
            },
            tooltip: {
                formatter: function() {
                    return '<b>'+ this.x.toLowerCase() +'</b><br/>'+ this.series.name +' '+ this.y +'%'
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
    
    $("select[name='province_id']").live("change",function(){
		$.post('nurseries/searchs/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$("#amphur").html(data);
			});
	});
	
	$("select[name='amphur_id']").live("change",function(){
		$.post('nurseries/searchs/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$("#district").html(data);
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
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries/reports/index/basic_column">ผลการดำเนินงานศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">รายงาน</li>
</ul>

<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</div>
    	
<form method="get" action="nurseries/reports/index/basic_column">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556'),@$_GET['year'],'','--- ผลการดำเนินงานสะสม 3 ปี ---');?>
		
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
	
	<?=form_dropdown('status',array('1'=>'เข้าร่วม','2'=>'ผ่านเกณฑ์','3'=>'รอประเมิน'),@$_GET['status'],'','--- สถานะ ---');?>
	
	<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	</div>
</form>

<div class='pull-right' <?=(@$_GET['type'] == 4)?"style='display:none;'":"";?>>
	<a href="nurseries/reports/index/basic_column?<?=$_SERVER['QUERY_STRING']?>"><div class="btn btn-mini">Basic Column</div></a> <a href="nurseries/reports/index/stacked_column?<?=$_SERVER['QUERY_STRING']?>"><div class="btn btn-mini">Stacked Column</div></a>
</div>

<div class='pull-left' <?=(@!$_GET)?"style='display:none;'":"";?>>
	<a class="btn btn-small" action="action" type="button" onclick="history.go(-1);" /><i class="icon-arrow-left"></i></a>
	<a class="btn btn-small" action="action" type="button" onclick="history.go(1);" /><i class="icon-arrow-right"></i></a>
</div>
<br clear="all">

<div id="container"></div>


<a href="nurseries/reports/export_graphpage/word?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">word</div></a>
<a href="nurseries/reports/export_graphpage/excel?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>&district_id=<?=@$_GET['district_id']?>"><div class="btn btn-mini">excel</div></a>



















<!-- block เทเบิ้ลไว้เจนกราฟ -->
<div style="display:none;">
<?php if(@$_GET['type'] == 1):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน</th>
				<?else:?>
				<th>เข้าร่วม</th>
				<th>ผ่านเกณฑ์</th>
				<th>รอการประเมิน</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($provinces as $province):?>
				<?php
					if($_GET['year'] == ""){
						$all = $province->nurseries->get()->result_count();
						$pass = $province->nurseries->where("status = 1")->get()->result_count();
						$not = $province->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $province->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $province->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $province->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$province->name?></th>
				<?if(@$_GET['status'] == 1):?>
				<td><?=convert_2_percent($all,$all)?></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><?=convert_2_percent($pass,$all)?></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><?=convert_2_percent($not,$all)?></td>
				<?else:?>
				<td><?=convert_2_percent($all,$all)?></td>
				<td><?=convert_2_percent($pass,$all)?></td>
				<td><?=convert_2_percent($not,$all)?></td>
				<?endif;?>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 2):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน</th>
				<?else:?>
				<th>เข้าร่วม</th>
				<th>ผ่านเกณฑ์</th>
				<th>รอการประเมิน</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($amphurs as $amphur):?>
				<?php
					if($_GET['year'] == ""){
						$all = $amphur->nurseries->get()->result_count();
						$pass = $amphur->nurseries->where("status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $amphur->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $amphur->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$amphur->amphur_name?></th>
				<?if(@$_GET['status'] == 1):?>
				<td><?=convert_2_percent($all,$all)?></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><?=convert_2_percent($pass,$all)?></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><?=convert_2_percent($not,$all)?></td>
				<?else:?>
				<td><?=convert_2_percent($all,$all)?></td>
				<td><?=convert_2_percent($pass,$all)?></td>
				<td><?=convert_2_percent($not,$all)?></td>
				<?endif;?>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 3):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน</th>
				<?else:?>
				<th>เข้าร่วม</th>
				<th>ผ่านเกณฑ์</th>
				<th>รอการประเมิน</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($districts as $district):?>
				<?php
					if($_GET['year'] == ""){
						$all = $district->nurseries->get()->result_count();
						$pass = $district->nurseries->where("status = 1")->get()->result_count();
						$not = $district->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $district->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $district->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $district->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th><?=$district->district_name?></th>
				<?if(@$_GET['status'] == 1):?>
				<td><?=convert_2_percent($all,$all)?></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><?=convert_2_percent($pass,$all)?></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><?=convert_2_percent($not,$all)?></td>
				<?else:?>
				<td><?=convert_2_percent($all,$all)?></td>
				<td><?=convert_2_percent($pass,$all)?></td>
				<td><?=convert_2_percent($not,$all)?></td>
				<?endif;?>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 4):?>
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2"><?=$text?></div>
	<table class="table">
		<thead>
			<tr>
		        <th>ลำดับ</th>
		        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
		        <th>ที่อยู่</th>
		        <th>ปีที่เข้าร่วม</th>
		        <th>หัวหน้าศูนย์</th>
		        <th>สถานะ</th>
	        </tr>
		</thead>
		<tbody>
			<?php $i=(@$_GET['page'] > 1)? (((@$_GET['page'])* 20)-20)+1:1;?>
	        <?php foreach($nurseries as $key=>$nursery):?>
	        	<tr>
			        <td><?=$i?></td>
			        <td><?=$nursery->nursery_category->title?><?=$nursery->name?></td>
			        <td>ต.<?=$nursery->district->district_name?><br>อ.<?=$nursery->amphur->amphur_name?><br>จ.<?=$nursery->province->name?></td>
			        <td><?=$nursery->year?></td>
			        <td>
			        	<?php if($nursery->p_title == "นาย"):?>
			        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
			        	<?php else:?>
			        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
			        	<?php endif;?>
			        </td>
			        <td><?=($nursery->status == 0)?"เข้าร่วมโครงการ":"ผ่านเกณฑ์";?></td>
		        </tr>
		        <?php $i++;?>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else:?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน</th>
				<?else:?>
				<th>เข้าร่วม</th>
				<th>ผ่านเกณฑ์</th>
				<th>รอการประเมิน</th>
				<!-- <th>จำนวนทั้งหมดในพื้นที่</th> -->
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($areas as $key=>$area):?>
				<?php
					if(@$_GET['year']){
						$all = $area->nurseries->where("year = ".@$_GET['year'])->get()->result_count();
						$pass = $area->nurseries->where("year = ".@$_GET['year']." and status = 1")->get()->result_count();
						$not = $area->nurseries->where("year = ".@$_GET['year']." and status = 0")->get()->result_count();
					}else{
						$all = $area->nurseries->where_related('provinces', 'area_id', $area->id)->get()->result_count();
						$pass = $area->nurseries->where("status = 1")->where_related('provinces', 'area_id', $area->id)->get()->result_count();
						$not = $area->nurseries->where("status = 0")->where_related('provinces', 'area_id', $area->id)->get()->result_count();
					}
				?>
			<tr>
				<th><?=$area->area_name?></th>
				<?if(@$_GET['status'] == 1):?>
				<td><?=convert_2_percent($all,$arrayTotalAll[$key])?></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><?=convert_2_percent($pass,$all)?></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><?=convert_2_percent($not,$all)?></td>
				<?else:?>
				<td><?=convert_2_percent($all,$arrayTotalAll[$key])?></td>
				<td><?=convert_2_percent($pass,$all)?></td>
				<td><?=convert_2_percent($not,$all)?></td>
				<!-- <td><?=convert_2_percent($arrayTotalAll[$key],$arrayTotalAll[$key])?></td> -->
				<?endif;?>
			</tr>
			<?php endforeach;?>
		</tbody>
	</table>
<?php endif;?>
</div>
<!-- block เทเบิ้ลไว้เจนกราฟ -->


















<?php if(@$_GET['type'] == 1):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม (แห่ง)</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน (แห่ง)</th>
				<?else:?>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($provinces as $province):?>
				<?php
					if($_GET['year'] == ""){
						$all = $province->nurseries->get()->result_count();
						$pass = $province->nurseries->where("status = 1")->get()->result_count();
						$not = $province->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $province->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $province->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $province->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th>
					<a href="nurseries/reports/index/basic_column?year=<?=$_GET['year']?>&type=2&province_id=<?=$province->id?>&status=<?=@$_GET['status']?>"><?=$province->name?></a>
				</th>
				<?if(@$_GET['status'] == 1):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>"><?=$all?></a></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>&status=1"><?=$pass?></a></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>&status=0"><?=$not?></a></td>
				<?else:?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>"><?=$all?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>&status=1"><?=$pass?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&area_id=<?=$_GET['area_id']?>&province_id=<?=$province->id?>&status=0"><?=$not?></a></td>
				<?endif;?>
			</tr>
			
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<th>รวมทั้งหมด</th>
				<?if(@$_GET['status'] == 1):?>
				<th><?=$totalAll?></th>
				<?elseif(@$_GET['status'] == 2):?>
				<th><?=$totalPass?></th>
				<?elseif(@$_GET['status'] == 3):?>
				<th><?=$totalNot?></th>
				<?else:?>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
				<?endif;?>
			</tr>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 2):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม (แห่ง)</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน (แห่ง)</th>
				<?else:?>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($amphurs as $amphur):?>
				<?php
					if($_GET['year'] == ""){
						$all = $amphur->nurseries->get()->result_count();
						$pass = $amphur->nurseries->where("status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $amphur->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $amphur->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $amphur->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th>
					<a href="nurseries/reports/index/basic_column?year=<?=$_GET['year']?>&type=3&amphur_id=<?=$amphur->id?>&status=<?=@$_GET['status']?>"><?=$amphur->amphur_name?></a>
				</th>
				<?if(@$_GET['status'] == 1):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>"><?=$all?></a></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>&status=1"><?=$pass?></a></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>&status=0"><?=$not?></a></td>
				<?else:?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>"><?=$all?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>&status=1"><?=$pass?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&province_id=<?=$_GET['province_id']?>&amphur_id=<?=$amphur->id?>&status=0"><?=$not?></a></td>
				<?endif;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<th>รวมทั้งหมด</th>
				<?if(@$_GET['status'] == 1):?>
				<th><?=$totalAll?></th>
				<?elseif(@$_GET['status'] == 2):?>
				<th><?=$totalPass?></th>
				<?elseif(@$_GET['status'] == 3):?>
				<th><?=$totalNot?></th>
				<?else:?>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
				<?endif;?>
			</tr>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 3):?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม (แห่ง)</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน (แห่ง)</th>
				<?else:?>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($districts as $district):?>
				<?php
					if($_GET['year'] == ""){
						$all = $district->nurseries->get()->result_count();
						$pass = $district->nurseries->where("status = 1")->get()->result_count();
						$not = $district->nurseries->where("status = 0")->get()->result_count();
					}else{
						$all = $district->nurseries->where("year = ".$_GET['year'])->get()->result_count();
						$pass = $district->nurseries->where("year = ".$_GET['year']." and status = 1")->get()->result_count();
						$not = $district->nurseries->where("year = ".$_GET['year']." and status = 0")->get()->result_count();
					}
				?>
			<tr>
				<th>
					<a href="nurseries/reports/index/basic_column?year=<?=$_GET['year']?>&type=4&district_id=<?=$district->id?>&status=<?=@$_GET['status']?>"><?=$district->district_name?></a>
				</th>
				<?if(@$_GET['status'] == 1):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>"><?=$all?></a></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>&status=1"><?=$pass?></a></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>&status=0"><?=$not?></a></td>
				<?else:?>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>"><?=$all?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>&status=1"><?=$pass?></a></td>
				<td><a href="nurseries/reports/detail?type=<?=$_GET['type']?>&year=<?=$_GET['year']?>&amphur_id=<?=$_GET['amphur_id']?>&district_id=<?=$district->id?>&status=0"><?=$not?></a></td>
				<?endif;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<th>รวมทั้งหมด</th>
				<?if(@$_GET['status'] == 1):?>
				<th><?=$totalAll?></th>
				<?elseif(@$_GET['status'] == 2):?>
				<th><?=$totalPass?></th>
				<?elseif(@$_GET['status'] == 3):?>
				<th><?=$totalNot?></th>
				<?else:?>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
				<?endif;?>
			</tr>
		</tbody>
	</table>
<?php elseif(@$_GET['type'] == 4):?>
	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2"><?=$text?></div>
	<table class="table">
		<thead>
			<tr>
		        <th>ลำดับ</th>
		        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
		        <th>ที่อยู่</th>
		        <th>ปีที่เข้าร่วม</th>
		        <th>หัวหน้าศูนย์</th>
		        <th>สถานะ</th>
	        </tr>
		</thead>
		<tbody>
			<?php $i=(@$_GET['page'] > 1)? (((@$_GET['page'])* 20)-20)+1:1;?>
	        <?php foreach($nurseries as $key=>$nursery):?>
	        	<tr>
			        <td><?=$i?></td>
			        <td><?=$nursery->nursery_category->title?><?=$nursery->name?></td>
			        <td>ต.<?=$nursery->district->district_name?><br>อ.<?=$nursery->amphur->amphur_name?><br>จ.<?=$nursery->province->name?></td>
			        <td><?=$nursery->year?></td>
			        <td>
			        	<?php if($nursery->p_title == "นาย"):?>
			        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
			        	<?php else:?>
			        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
			        	<?php endif;?>
			        </td>
			        <td><?=($nursery->status == 0)?"เข้าร่วมโครงการ":"ผ่านเกณฑ์";?></td>
		        </tr>
		        <?php $i++;?>
			<?php endforeach;?>
		</tbody>
	</table>
<?php else:?>
	<table id="datatable" class="table">
		<thead>
			<tr>
				<th></th>
				<?if(@$_GET['status'] == 1):?>
				<th>เข้าร่วม (แห่ง)</th>
				<?elseif(@$_GET['status'] == 2):?>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<?elseif(@$_GET['status'] == 3):?>
				<th>รอการประเมิน (แห่ง)</th>
				<?else:?>
				<th>เข้าร่วม (แห่ง)</th>
				<th>ผ่านเกณฑ์ (แห่ง)</th>
				<th>รอการประเมิน (แห่ง)</th>
				<th>จำนวนทั้งหมดในพื้นที่  (แห่ง)</th>
				<?endif;?>
			</tr>
		</thead>
		<tbody>
			<?php foreach($areas as $key=>$area):?>
				<?php
					if(@$_GET['year']){
						$all = $area->nurseries->where("year = ".@$_GET['year'])->get()->result_count();
						$pass = $area->nurseries->where("year = ".@$_GET['year']." and status = 1")->get()->result_count();
						$not = $area->nurseries->where("year = ".@$_GET['year']." and status = 0")->get()->result_count();
					}else{
						$all = $area->nurseries->where_related('provinces', 'area_id', $area->id)->get()->result_count();
						$pass = $area->nurseries->where("status = 1")->where_related('provinces', 'area_id', $area->id)->get()->result_count();
						$not = $area->nurseries->where("status = 0")->where_related('provinces', 'area_id', $area->id)->get()->result_count();
					}
				?>
			<tr>
				<th><a href="nurseries/reports/index/basic_column?year=&type=1&area_id=<?=$area->id?>&status=<?=@$_GET['status']?>"><?=$area->area_name?></a></th>
				<?if(@$_GET['status'] == 1):?>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&year=<?=@$_GET['year']?>"><?=$all?></a></td>
				<?elseif(@$_GET['status'] == 2):?>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&year=<?=@$_GET['year']?>"&status=1><?=$pass?></a></td>
				<?elseif(@$_GET['status'] == 3):?>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&year=<?=@$_GET['year']?>"&status=0><?=$not?></a></td>
				<?else:?>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&year=<?=@$_GET['year']?>"><?=$all?></a></td>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&status=1&year=<?=@$_GET['year']?>"><?=$pass?></a></td>
				<td><a href="nurseries/reports/detail?area_id=<?=$area->id?>&status=0&year=<?=@$_GET['year']?>"><?=$not?></a></td>
				<td><?=$arrayTotalAll[$key]?></td>
				<?endif;?>
			</tr>
				<?php
					@$totalAll += $all;
					@$totalPass += $pass;
					@$totalNot += $not;
				?>
			<?php endforeach;?>
			<tr>
				<th>รวมทั้งหมด</th>
				<?if(@$_GET['status'] == 1):?>
				<th><?=$totalAll?></th>
				<?elseif(@$_GET['status'] == 2):?>
				<th><?=$totalPass?></th>
				<?elseif(@$_GET['status'] == 3):?>
				<th><?=$totalNot?></th>
				<?else:?>
				<th><?=$totalAll?></th>
				<th><?=$totalPass?></th>
				<th><?=$totalNot?></th>
				<th>20142</th>
				<?endif;?>
			</tr>
		</tbody>
	</table>
<?php endif;?>