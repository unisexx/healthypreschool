<script type="text/javascript">
$(document).ready(function(){
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
		$.get('nurseries/get_nursery_data2',{
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
  <li><a href="nurseries">ศูนย์เด็กเล็กปลอดโรค</a> <span class="divider">/</span></li>
  <li class="active">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</li>
</ul>
    <div id="data">
    	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">รายละเอียดชื่อโครงการศูนย์เด็กเล็กปลอดโรค</div>

    	<form method="get" action="nurseries/register">
	    	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
			
			<?=form_dropdown('nursery_type',array('1'=>'ศูนย์เด็กเล็ก','2'=>'โรงเรียนอนุบาล'),@$_GET['nursery_type']);?>
	    	<?// =form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$_GET['nursery_category_id'],'','--- เลือกคำนำหน้า ---');?>
	    	<input name="id" type="number" value="<?=@$_GET['id']?>" placeholder="หมายเลขศูนย์" style="width:100px;"/>
	    	<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;"/>
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
				<option value="">--- ปีที่เข้าร่วมโครงการ ---</option>
			    <?php
				    for($i=2554;$i<=(date("Y")+543);$i++) {
				        $sel = ($i == @$_GET['year']) ? 'selected' : "";
				        echo "<option value=".$i." ".$sel.">".date("Y", mktime(0,0,0,0,1,$i+1))."</option>";
				    }
			    ?>
			</select>
	    	  <?=form_dropdown('status',array('1'=>'ผ่านเกณฑ์','2'=>'ไม่ผ่านเกณฑ์','3'=>'รอการประเมิน','4'=>'เข้าร่วมโครงการ','5'=>'หมดอายุแล้ว'),@$_GET['status'],'','--- เลือกสถานะ ---');?><br>
	    	  วันที่เริ่ม <input type="text" name="start_date" value="<?=@$_GET['start_date']?>" class="datepicker" style="width:75px;" />
	    	  วันที่สิ้นสุด <input type="text" name="end_date" value="<?=@$_GET['end_date']?>" class="datepicker" style="width:75px;"/>
	    	  <input type="hidden" name="search" value="1">
	  	      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	    	</div>
    	</form>



<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>



        <div style="margin-bottom: 10px;">
        	ผ่านเกณฑ์<a href="nurseries/register?<?=@$_SERVER['QUERY_STRING']?>&status=1"> <span class="badge badge-success"><?=$count['pass']?></span></a>
        	ไม่ผ่านเกณฑ์<a href="nurseries/register?<?=@$_SERVER['QUERY_STRING']?>&status=2"> <span class="badge badge-important"><?=$count['not_pass']?></span></a>
        	รอการประเมิน<a href="nurseries/register?<?=@$_SERVER['QUERY_STRING']?>&status=3"> <span class="badge"><?=$count['wait']?></span></a>
        	เข้าร่วมโครงการ<a href="nurseries/register?<?=@$_SERVER['QUERY_STRING']?>&status=0"> <span class="badge badge-info"><?=$count['total']?></span></a>

        </div>

        <!-- <div style="float:right; padding:10px 0;">
        	<a href="nurseries/register_form"><div class="btn">เพิ่มศูนย์เด็กเล็ก</div></a>
        	<?php if(user_login()->user_type_id == 1): //ถ้าเป็นผู้ดูแลระบบ ?>
	        	<a href="nurseries/category_form"><div class="btn">คำนำหน้า</div></a>
	        	<a href="nurseries/reports/index/basic_column" target="_blank"><div class="btn">รายงาน</div></a>
        	<?elseif(user_login()->user_type_id == 6): //ถ้าเป็นเจ้าหน้าที่เขต ?>
        		<a href="nurseries/reports/index/basic_column?year=&type=1&area_id=<?=user_login()->area_id?>" target="_blank"><div class="btn">รายงาน</div></a>
        	<?elseif(user_login()->user_type_id == 7): //ถ้าเป็นเจ้าหน้าที่ประจำจังหวัด ?>
        		<a href="nurseries/reports/index/basic_column?type=2&province_id=<?=user_login()->province_id?>" target="_blank"><div class="btn">รายงาน</div></a>
        	<?elseif(user_login()->user_type_id == 8): //ถ้าเป็นเจ้าหน้าที่ประจำอำเภอ ?>
        		<a href="nurseries/reports/index/basic_column?type=3&amphur_id=<?=user_login()->amphur_id?>" target="_blank"><div class="btn">รายงาน</div></a>
        	<?endif;?>
        </div> -->

    	<table class="table table-striped">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์พัฒนาเด็กเล็ก<br>(ไอดีศูนย์เด็กเล็ก)</th>
	        <!-- <th>จังหวัด</th> -->
	        <th>ที่อยู่</th>
	        <!-- <th>ปีที่เข้าร่วม</th> -->
	        <!-- <th>หัวหน้าศูนย์</th> -->
	        <th>วันที่ลงทะเบียน</th>
	        <th>ผลการประเมิน</th>
	        <th>รูปแบบการประเมิน</th>
	        <!-- <th>วันที่ประเมิน</th>
	        <th>ผู้ประเมิน</th> -->
	        <th width="77">จัดการ</th>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
	        <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
	        <td>
	        	<input type="hidden" name="id" value="<?=$nursery->id?>">
	        	<!-- <a href="#myModal" class="btn-estimate" data-toggle="modal"><b><?=$nursery->name?> (<?=$nursery->id?>)</b></a> -->
	        	<a href="nurseries/estimate_view/<?=$nursery->id?>" target="_blank"><b><?//=$nursery->nursery_category->title?><?=$nursery->name?> (<?=$nursery->id?>)</b></a>
	        	<ul>
	        		<li>
	        			<a href="childrens?nursery_id=<?=$nursery->id?>" target="_blank">รายชื่อเด็ก/นักเรียน</a>
	        			<?
	        				$rs = $this->db->query("SELECT
																count(classroom_childrens.id) total
																FROM
																classrooms
																INNER JOIN classroom_childrens ON classroom_childrens.classroom_id = classrooms.id
																WHERE classrooms.nursery_id = ".$nursery->id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li>
	        			<a href="classrooms?nursery_id=<?=$nursery->id?>" target="_blank">รายชื่อห้องเรียน</a>
	        			<?
	        				$rs = $this->db->query("SELECT COUNT(id) total FROM classrooms where nursery_id = ".$nursery->id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li>
	        			<a href="teachers?nursery_id=<?=$nursery->id?>" target="_blank">รายชื่อครู/เจ้าหน้าที่</a>
	        			<?
	        				$rs = $this->db->query("SELECT
																count(classroom_teachers.id) total
																FROM
																classrooms
																INNER JOIN classroom_teachers ON classroom_teachers.classroom_id = classrooms.id
																WHERE classrooms.nursery_id = ".$nursery->id)->row_array();
							echo '<span style="color:#666666;">('.$rs['total'].')</span>';
	        			?>
	        		</li>
	        		<li><a href="diseases/list_guest/<?=$nursery->id?>" target="_blank">บันทึกแบบคัดกรองโรค</a></li>
	        		<li><a href="diseases/report_guest?nursery_id=<?=$nursery->id?>" target="_blank">รายงานแบบคัดกรองโรค</a></li>
	        		<li><a href="assessments/preview/<?=$nursery->id?>" target="_blank">รายงานแบบประเมินสมัครเข้าร่วมโครงการ</a></li>
	        	</ul>
	        </td>
	        <!-- <td>จ.<?=$nursery->province_name?></td> -->
	        <td>จ.<?=$nursery->province_name?><br>อ.<?=$nursery->amphur_name?><br>ต.<?=$nursery->district_name?> </td>
	        <!-- <td><?=$nursery->year?></td> -->
	        <!-- <td>
	        	<?php if($nursery->p_title == "นาย"):?>
	        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php else:?>
	        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php endif;?>
	        </td> -->
	        <td nowrap="nowrap">
	        	<?=mysql_to_th($nursery->created,'S',TRUE)?> น.
	        	<?
	        		if(!empty($nursery->user_id)){
	        			echo "<br>(".get_user_name($nursery->user_id).")";
					}
	        	?>
	        </td>
	        <!-- <td nowrap="nowrap">
	        	<?//=($nursery->status == 0)?"รอการประเมิน":"ผ่านเกณฑ์ <br>(พ.ศ. ".$nursery->approve_year.")";?>

	        	<?if($nursery->status == 0):?>
	        		<?if($nursery->assessments_total != 0):?>
	        			<a href="assessments/preview/<?=$nursery->id?>" target="_blank">
	        			<span style="color:#D14">ไม่ผ่านเกณฑ์ <br>(<?=$nursery->assessments_total?> คะแนน)</span>
	        			</a>
	        		<?else:?>
	        			รอการประเมิน
	        		<?endif;?>
	        	<?else:?>
	        		<span style="color:teal">
	        		<?if($nursery->assessment_approve_year != 0):?>
	        			ผ่านเกณฑ์ <br>(พ.ศ. <?=$nursery->assessment_approve_year?>)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=$nursery->assessment_approve_year + 2?></span>
	        		<?else:?>
	        		<a href="assessments/preview/<?=$nursery->id?>" target="_blank">
	        			ผ่านเกณฑ์ <br>(<?=$nursery->assessments_total?> คะแนน)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=date("Y", strtotime($nursery->assessment_approve_date)) + 545;?></span>
	        		</a>
	        		<?endif;?>
	        		</span>
	        		<div><a href="nurseries/cert/index/<?=$nursery->id?>" target="_blank">พิมพ์ใบประกาศ</a></div>
	        	<?endif;?>
	        </td>
	        <td><?=mysql_to_th($nursery->assessment_approve_date)?></td>
	        <td><?=get_user_name($nursery->assessment_approve_user_id)?></td> -->
	        <td>
	        	<?=get_assessment_status($nursery->assessment_status)?>
	        	<?if($nursery->assessment_status == 1):?>
	        		<div>
	        			<!-- <a href="nurseries/cert/index/<?=$nursery->id?>" target="_blank">พิมพ์ใบประกาศ</a> -->
	        			<a href="nurseries/estimate_view/<?=$nursery->id?>" target="_blank">พิมพ์ใบประกาศ</a>
	        		</div>
	        	<?endif;?>
	        </td>
	        <td><?=get_assessment_approve_type_2($nursery->assessment_status,$nursery->assessment_approve_type,$nursery->assessment_approve_user_id,$nursery->assessment_total)?></td>
	        <td>
	        	<!-- <a href="assessments/form?nursery_id=<?=$nursery->id?>" class='btn btn-mini' style="width:59px;">ประเมินผลแบบ 35 ข้อ</a> -->
	        	<a href="nurseries/register_form/<?=$nursery->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        	<a href="nurseries/delete/<?=$nursery->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
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
