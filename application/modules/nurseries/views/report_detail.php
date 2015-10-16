<script>
$(document).ready(function(){
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
			$("#amphur").show();
			$("#province,#area,#district").hide();
			$("select[name=province_id],select[name=area_id],select[name=district_id]").val("0");
           break;
           case '4':
			$("#district").show();
			$("#province,#amphur,#area").hide();
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
<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</div>
    	
<form method="get" action="nurseries/reports/index/stacked_column">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556'),@$_GET['year'],'','--- เลือกปี ---');?>
		
	<?=form_dropdown('type',array('1'=>'สคร.','2'=>'จังหวัด','3'=>'อำเภอ','4'=>'ตำบล'),@$_GET['type'],'','--- แยกตาม ---');?>
	
	<span id="area" <?=(@$_GET['area_id'] == "")?'style="display:none;"':'';?>>
	<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'','--- เลือกสคร. ---');?>
	</span>
	
	<span id="province" <?=(@$_GET['province_id'] == "")?'style="display:none;"':'';?>>
	<?php echo form_dropdown('province_id',get_option('id','name','provinces'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	</span>
   	
	<span id="amphur" <?=(@$_GET['amphur_id'] == "")?'style="display:none;"':'';?>>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	</span>
	
	<span id="district" <?=(@$_GET['district_id'] == "")?'style="display:none;"':'';?>>
		<?=form_dropdown('district_id',get_option('id','district_name','districts'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
	</span>
	
      <input class="btn" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	</div>
</form>

<a class="btn btn-small" action="action" type="button" onclick="history.go(-1);" /><i class="icon-arrow-left"></i></a>

<div class="pull-right">
<a href="nurseries/reports/export_detail/word?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>"><div class="btn btn-mini">word</div></a>
<a href="nurseries/reports/export_detail/excel?type=<?=@$_GET['type']?>&year=<?=@$_GET['year']?>&area_id=<?=@$_GET['area_id']?>&province_id=<?=@$_GET['province_id']?>&amphur_id=<?=@$_GET['amphur_id']?>"><div class="btn btn-mini">excel</div></a>
</div>

<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#01a8d2">รายละเอียดศูนย์เด็กเล็ก <?=@$district?> <?=@$amphur?> <?=@$province?> <?=@$area?> <?=@$year?></div>

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
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
		        <td><?=($key+1)+$nurseries->paged->current_row?></td>
		        <td><?//=$nursery->nursery_category->title?><?=$nursery->name?></td>
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
		<?php endforeach;?>
	</tbody>
</table>
<?=$nurseries->pagination();?>