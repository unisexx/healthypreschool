<style>
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
    	<?//=form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$_GET['nursery_category_id'],'','--- เลือกคำนำหน้า ---');?>
    	<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;" />
    	<?php get_area_dropdown(@$_GET['area_id']);?>
    	<span id="province">
    		<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
    	</span>
    	<!--
		<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
       		<?php echo form_dropdown('province_id',get_option('id','name','provinces order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
       	<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
       		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
       	<?php endif;?>
       -->

    	  <span id="amphur">
    	  	<?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
    	  	<!--
    	  	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกอำเภอ?>
				<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
			<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
				<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id in (select id from provinces where area_id = '.user_login()->area_id.') order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
			<?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
                    <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
                <?php endif;?>
           -->
    	  </span>

    	  <span id="district">
    	  	<?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
    	  	<!--
    	  	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกตำบล?>
				<?=form_dropdown('district_id',get_option('id','district_name','districts order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
			<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
				<?=form_dropdown('district_id',get_option('id','district_name','districts','where province_id in (select id from provinces where area_id = '.user_login()->area_id.') order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
			<?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
                <?=form_dropdown('district_id',get_option('id','district_name','districts','where province_id = '.user_login()->province_id.' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
                <?php elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่อำเภอ?>
                    <?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.user_login()->amphur_id.' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
                <?php endif;?>
           -->
    	  </span>
    	  <?//=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556','2557'=>'2557','2558'=>'2558'),@$_GET['year'],'','--- เลือกปีที่เข้าร่วม ---');?>
			<select name="year">
			<option value="">--- เลือกปีที่เข้าร่วม ---</option>
		    <?php
			    for($i=2554;$i<=(date("Y")+543);$i++) {
			        $sel = ($i == @$_GET['year']) ? 'selected' : "";
			        echo "<option value=".$i." ".$sel.">".date("Y", mktime(0,0,0,0,1,$i+1))."</option>";
			    }
		    ?>
			</select>
    	  <?=form_dropdown('status',array('3'=>'รอการประเมิน','1'=>'ผ่านเกณฑ์','2'=>'ไม่ผ่านเกณฑ์'),@$_GET['status'],'','');?>
    	  <input type="hidden" name="search" value="1">
  	      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
    	</div>
	</form>



	<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>




	<ul class="nav nav-tabs home-nav-tabs estimate-tab">
		<li <?=@$_GET['status']==3 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=3&page=1">รอการประเมิน <span class="badge"><?=@$count['wait']?></span></a></li>
		<li <?=@$_GET['status']==1 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=1&page=1">ผ่านเกณฑ์ <span class="badge badge-success"><?=@$count['pass']?></span></a></li>
		<li <?=@$_GET['status']==2 ?"class='active'" : "" ;?>><a href="nurseries/estimate?<?=@$_SERVER['QUERY_STRING']?>&status=2&page=1">ไม่ผ่านเกณฑ์ <span class="badge badge-important"><?=@$count['not_pass']?></a></li>
	</ul>

	<table class="table">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์เด็กเล็ก</th>
	        <th>จังหวัด</th>
	        <th>ที่อยู่</th>
	        <th>ปีที่เข้าร่วม</th>
	        <th>หัวหน้าศูนย์</th>
	        <th>วันที่ประเมิน</th>
	        <th>ผู้ประเมิน</th>
	        <?php if($this->uri->segment(3) == 1): //ถ้าเป็นแทบประเมินผล ให้แสดงผลการประเมิน?>
	        	<th width="65">ประเมินผล</th>
	        <?php else:?>
	        	<th width="65">จัดการ</th>
	        <?php endif;?>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
	        <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
	        <td><?//=$nursery->nursery_category->title?><?=$nursery->name?></td>
	        <td>จ.<?=$nursery->province_name?></td>
	        <td>อ.<?=$nursery->amphur_name?><br>ต.<?=$nursery->district_name?></td>
	        <td><?=$nursery->year?></td>
	        <td>
	        	<?php if($nursery->p_title == "นาย"):?>
	        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_other?><?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php else:?>
	        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_other?><?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php endif;?>
	        </td>
	        <td><?=mysql_to_th($nursery->approve_date)?></td>
	        <td><?=get_user_name($nursery->approve_user_id)?></td>
	        <td>
	        <?php if($this->uri->segment(3) == 1): //ถ้าเป็นแทบประเมินผล ให้แสดงผลการประเมิน?>
	        	<?if($nursery->status == 0):?>
	        		<?if($nursery->assessment->total != 0):?>
	        			<a href="assessments/preview/<?=$nursery->id?>" target="_blank">
	        			<span style="color:#D14">ไม่ผ่านเกณฑ์ <br>(<?=$nursery->assessment->total?> คะแนน)</span>
	        			</a>
	        		<?else:?>
	        			รอการประเมิน
	        		<?endif;?>
	        	<?else:?>
	        		<span style="color:teal">
	        		<?if($nursery->approve_year != 0):?>
	        			ผ่านเกณฑ์ <br>(พ.ศ. <?=$nursery->approve_year?>)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=$nursery->approve_year + 3?></span>
	        		<?else:?>
	        		<a href="assessments/preview/<?=$nursery->id?>" target="_blank">
	        			ผ่านเกณฑ์ <br>(<?=$nursery->assessment->total?> คะแนน)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=date("Y", strtotime($nursery->approve_date)) + 546;?></span>
	        		</a>
	        		<?endif;?>
	        		</span>
	        	<?endif;?>
	        <?php else:?>
		        	<input type="hidden" name="id" value="<?=$nursery->id?>">
		        	<a href="#myModal" role="button" data-toggle="modal" class='btn btn-mini btn-estimate btn-info'>ประเมินผล</a>
	        <?php endif;?>
	        </td>
		</tr>
		<?php endforeach;?>
	</table>
	<?=$pagination;?>
	</div>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
  	<div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
  	<div class="modal-body-form"></div>
  </div>
</div>


<?endif;?>
