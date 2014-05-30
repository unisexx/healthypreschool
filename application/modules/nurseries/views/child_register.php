<script type="text/javascript">
$(document).ready(function(){
	$("select[name='province_id']").live("change",function(){
		$.post('nurseries/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$("#amphur").html(data);
			});
	});
	
	$("select[name='amphur_id']").live("change",function(){
		$.post('nurseries/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$("#district").html(data);
			});
	});
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
	    		
	    	<?=form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$_GET['nursery_category_id'],'','--- เลือกคำนำหน้า ---');?>
	    	<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;"/>
			<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
           		<?php echo form_dropdown('province_id',get_option('id','name','provinces'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
           	<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
           		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
           	<?php endif;?>
           	
           	
			<span id="amphur">
				<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกอำเภอ?>
					
					<?php if(@$_GET['province_id']):?>
						<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures where province_id = '.@$_GET['province_id']),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
					<?php else:?>
						<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
					<?php endif;?>
					
				<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
					
					<?php if(@$_GET['province_id']):?>
						<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures where province_id = '.@$_GET['province_id']),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
					<?php else:?>
						<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id in (select id from provinces where area_id = '.user_login()->area_id.') order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
					<?php endif;?>
					
				<?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
				    <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by id asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
				<?php endif;?>
			</span>
			
			
			<span id="district">
				<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกตำบล?>
					
					<?php if(@$_GET['amphur_id']):?>
						<?=form_dropdown('district_id',get_option('id','district_name','districts where amphur_id = '.@$_GET['amphur_id']),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
					<?php else:?>
						<?=form_dropdown('district_id',get_option('id','district_name','districts'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
					<?php endif;?>
					
				<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
					
					<?php if(@$_GET['amphur_id']):?>
						<?=form_dropdown('district_id',get_option('id','district_name','districts where amphur_id = '.@$_GET['amphur_id']),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
					<?php else:?>
						<?=form_dropdown('district_id',get_option('id','district_name','districts','where province_id in (select id from provinces where area_id = '.user_login()->area_id.') order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
					<?php endif;?>
					
                <?php elseif(user_login()->user_type_id == 7 && $_GET): //เจ้าหน้าที่จังหวัด?>
                    <?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_GET['amphur_id'].' order by id asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
                <?php elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่อำเภอ?>
                    <?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.user_login()->amphur_id.' order by id asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
				<?php endif;?>
			</span>
	    	  <?=form_dropdown('year',array('2554'=>'2554','2555'=>'2555','2556'=>'2556'),@$_GET['year'],'','--- เลือกปี ---');?>
	    	  <?=form_dropdown('status',array('1'=>'ผ่านเกณฑ์','2'=>'ไม่ผ่านเกณฑ์','3'=>'รอการประเมิน','0'=>'เข้าร่วมโครงการ'),@$_GET['status'],'','--- เลือกสถานะ ---');?>
	  	      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	    	</div>
    	</form>
        <div style="margin-bottom: 10px;">
        	ผ่านเกณฑ์<a href="nurseries/register?status=1"> <span class="badge badge-success"><?=$pass_count?></span></a>
        	ไม่ผ่านเกณฑ์<a href="nurseries/register?status=2"> <span class="badge badge-important"><?=$nopass_count?></span></a>
        	รอการประเมิน<a href="nurseries/register?status=3"> <span class="badge"><?=$regis_count-($pass_count+$nopass_count)?></span></a>
        	เข้าร่วมโครงการ<a href="nurseries/register"> <span class="badge badge-info"><?=$regis_count?></span></a>
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
        
    	<table class="table">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
	        <th>จังหวัด</th>
	        <th>ที่อยู่</th>
	        <!-- <th>ปีที่เข้าร่วม</th> -->
	        <th>หัวหน้าศูนย์</th>
	        <th>วันที่ลงทะเบียน</th>
	        <th>ผลการประเมิน</th>
	        <th>วันที่ประเมิน</th>
	        <th>ผู้ประเมิน</th>
	        <th width="100">จัดการ</th>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
	        <td><?=($key+1)+$nurseries->paged->current_row?></td>
	        <td><?=$nursery->nursery_category->title?><?=$nursery->name?></td>
	        <td>จ.<?=$nursery->province->name?></td>
	        <td>อ.<?=$nursery->amphur->amphur_name?><br>ต.<?=$nursery->district->district_name?> </td>
	        <!-- <td><?=$nursery->year?></td> -->
	        <td>
	        	<?php if($nursery->p_title == "นาย"):?>
	        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php else:?>
	        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
	        	<?php endif;?>
	        </td>
	        <td nowrap="nowrap"><?=mysql_to_th($nursery->created)?></td>
	        <td nowrap="nowrap">
	        	<?//=($nursery->status == 0)?"รอการประเมิน":"ผ่านเกณฑ์ <br>(พ.ศ. ".$nursery->approve_year.")";?>
	        	
	        	<?if($nursery->status == 0):?>
	        		<?if($nursery->assessment->total != 0):?>
	        			<span style="color:#D14">ไม่ผ่านเกณฑ์ <br>(<?=$nursery->assessment->total?> คะแนน)</span>
	        		<?else:?>
	        			รอการประเมิน
	        		<?endif;?>
	        	<?else:?>
	        		<span style="color:teal">
	        		ผ่านเกณฑ์ <br>
	        		<?if($nursery->approve_year != 0):?>
	        			(พ.ศ. <?=$nursery->approve_year?>)
	        		<?else:?>
	        			(<?=$nursery->assessment->total?> คะแนน)
	        		<?endif;?>
	        		</span>
	        	<?endif;?>
	        <td><?=mysql_to_th($nursery->approve_date)?></td>
	        <td><?=get_user_name($nursery->approve_user_id)?></td>
	        </td>
	        <td>
	        	<a href="assessments/form?nursery_id=<?=$nursery->id?>" class='btn btn-mini' style="width:59px;">ประเมินผลแบบ 35 ข้อ</a>
	        	<a href="nurseries/register_form/<?=$nursery->id?>" class='btn btn-mini btn-info'>แก้ไข</a>
	        	<a href="nurseries/delete/<?=$nursery->id?>" class="btn btn-mini btn-danger" onclick="return(confirm('ยืนยันการลบข้อมูล'))">ลบ</a>
	        </td>
	        </tr>
		<?php endforeach;?>
        </table>
        <?=$nurseries->pagination();?>
	</div>