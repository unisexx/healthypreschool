<style>
	.modal.large {
	    width: 80%; /* respsonsive width */
	    margin-left:-40%; /* width/2) */ 
	}
	.modal-body{max-height:665px !important;}
	.table-condensed th, .table-condensed th a {
	    background-color: #f1f1f1 !important;
	    color: #000 !important;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('input[type="checkbox"][name="status"]').change(function() {
	     if(this.checked) {
			$.post('nurseries/save_status',{
				'id' : $(this).next().val(),
				'status' : 1
			});
	     }else{
	     	$.post('nurseries/save_status',{
				'id' : $(this).next().val(),
				'status' : 0
			});
	     }
	});

	$("select[name='area_id']").live("change",function(){
  		$.post('ajax/get_province',{
  				'area_id' : $(this).val()
  			},function(data){
  				$("#province").html(data);
  			});

  			$('select[name=amphur_id] option:first-child,select[name=district_id] option:first-child').attr("selected", "selected").attr("disabled", "disabled");
			$('select[name=amphur_id],select[name=district_id]').attr("disabled", "disabled");
  	});
  	$("select[name='province_id']").live("change",function(){
  		$.post('ajax/get_amphur',{
  				'province_id' : $(this).val()
  			},function(data){
  				$("#amphur").html(data);
  			});

  			$('select[name=district_id] option:first-child').attr("selected", "selected").attr("disabled", "disabled");
			$('select[name=district_id]').attr("disabled", "disabled");
  	});

  	$("select[name='amphur_id']").live("change",function(){
  		$.post('ajax/get_district',{
  				'amphur_id' : $(this).val()
  			},function(data){
  				$("#district").html(data);
  			});
  	});

	$(".btn-estimate").live("click",function(){
		$('.loader').show();
		$.get('nurseries/get_nursery_data',{
			'id' : $(this).prev('input[type=hidden]').val()
		},function(data){
			$('.modal-body-form').html(data);
			$('.loader').hide();
		});
	});
	
	// ถ้าเป็นเจ้าหน้าที่อำเภอ ให้ disable สคร และ จังหวัด
	if(<?=user_login()->user_type_id;?> == 8){
		$("select[name=area_id],select[name=province_id]").attr("disabled", true);
	}
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="nurseries">ศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">ส่งผลการประเมินโครงการศูนย์เด็กเล็กปลอดโรค</li>
</ul>



	<div id="data">
    	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">ส่งผลการประเมินโครงการศูนย์เด็กเล็กปลอดโรค</div>

    <form method="get" action="">
    	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
		<?=form_dropdown('nursery_type',array('1'=>'ศูนย์เด็กเล็ก','2'=>'โรงเรียนอนุบาล'),@$_GET['nursery_type']);?>
    	<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;" />
    	<?php get_area_dropdown(@$_GET['area_id']);?>
    	<span id="province">
    		<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
    	</span>
    	  <span id="amphur">
    	  	<?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
    	  </span>

    	  <span id="district">
    	  	<?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
    	  </span>
			<select name="year">
			<option value="">--- เลือกปีที่เข้าร่วม ---</option>
		    <?php
			    for($i=2554;$i<=(date("Y")+543);$i++) {
			        $sel = ($i == @$_GET['year']) ? 'selected' : "";
			        echo "<option value=".$i." ".$sel.">".date("Y", mktime(0,0,0,0,1,$i+1))."</option>";
			    }
		    ?>
			</select>
    	  <?=form_dropdown('status',array('0'=>'รอการประเมิน','1'=>'ผ่านเกณฑ์','2'=>'ไม่ผ่านเกณฑ์'),@$_GET['status'],'','');?>
    	  <input type="hidden" name="search" value="1">
  	      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
    	</div>
	</form>



	<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>




	<ul class="nav nav-tabs home-nav-tabs estimate-tab">
		<li <?=@$_GET['status']==0 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=0&page=1">รอการประเมิน <span class="badge"><?=@$count['wait']?></span></a></li>
		<li <?=@$_GET['status']==1 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=1&page=1">ผ่านเกณฑ์ <span class="badge badge-success"><?=@$count['pass']?></span></a></li>
		<li <?=@$_GET['status']==2 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=2&page=1">ไม่ผ่านเกณฑ์ <span class="badge badge-important"><?=@$count['not_pass']?></a></li>
	</ul>

	<table class="table">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์เด็กเล็ก</th>
	        <th>ที่อยู่</th>
	        <th>ปีที่เข้าร่วม</th>
	        <?if(@$_GET['status']!=0):?>
	        <th>ปีที่ประเมินล่าสุด</th>
	        <th>รูปแบบการประเมิน</th>
	        <?if(@$_GET['status']==1):?>
	        <th>หมดอายุ</th>
	        <?endif;?>
	        <?endif;?>
	        <th width="65">จัดการ</th>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
	        <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
	        <td><?=$nursery->name?></td>
	        <td>จ.<?=$nursery->province_name?><br>อ.<?=$nursery->amphur_name?><br>ต.<?=$nursery->district_name?></td>
	        <td><?=$nursery->year?></td>
	        <?if(@$_GET['status']!=0):?>
	        <td><?=$nursery->assessment_approve_year?></td>
	        <td><?=get_assessment_approve_type_2($nursery->assessment_status,$nursery->assessment_approve_type,$nursery->assessment_approve_user_id,$nursery->assessment_total)?></td>
	        <?if(@$_GET['status']==1):?>
	        <td><?=($nursery->assessment_approve_year)+2?></td>
	        <?endif;?>
	        <?endif;?>
	        <td>
	        	<input type="hidden" name="id" value="<?=$nursery->id?>">
		        <a href="#myModal" role="button" data-toggle="modal" class='btn btn-mini btn-estimate btn-info'>ประเมินผล</a>
	        </td>
		</tr>
		<?php endforeach;?>
	</table>
	<?=$pagination;?>
	</div>

<!-- Modal -->
<div id="myModal" class="modal large hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
  	<div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
  	<div class="modal-body-form"></div>
  </div>
</div>


<?endif;?>
