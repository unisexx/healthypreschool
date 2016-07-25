<script type="text/javascript">
$(document).ready(function(){
	$("select[name='province_id']").live("change",function(){
		$("#district").html("");
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
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</li>
</ul>
    <div id="data">
    	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">สมัครเข้าร่วมโครงการศูนย์เด็กเล็กปลอดโรค</div>
    	
    	<form method="get" action="nurseries/searchs">
	    	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	    		<?//=form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$_GET['nursery_category_id'],'','--- เลือกคำนำหน้า ---');?>
	    		<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;"/>
	    		
				<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	           	
				<span id="amphur">
					<?php if(@$_GET['province_id']):?>
						<?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_GET['province_id'].' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---') ?>
					<?php endif;?>
				</span>
				
				<span id="district">
					<?php if(@$_GET['amphur_id']):?>
						<?php echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---') ?>
					<?php endif;?>
				</span>
				
				<input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
	    	</div>
    	</form>

<?php if($_GET):?>
	ผลการค้นหาพบทั้งหมด <?=$count?> แห่ง
        <!-- <div style="float:right; padding:10px 0;">
        	<a href="nurseries/searchs/register_form"><div class="btn">สมัครเข้าร่วมโครงการ</div></a>
        </div> -->
    	<table class="table">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อศุนย์พัฒนาเด็กเล็ก</th>
	        <th>ที่อยู่</th>
	        <th>ปีที่เข้าร่วม</th>
	        <th>หัวหน้าศูนย์</th>
	        <th>ผลการประเมิน</th>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
		        <td><?=($key+1)+$nurseries->paged->current_row?></td>
		        <td><?//=$nursery->title?><?=$nursery->name?></td>
		        <td>ต.<?=$nursery->district_name?><br>อ.<?=$nursery->amphur_name?><br>จ.<?=$nursery->province_name?></td>
		        <td><?=$nursery->year?></td>
		        <td>
		        	<?php if($nursery->p_title == "นาย"):?>
		        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
		        	<?php else:?>
		        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
		        	<?php endif;?>
		        </td>
		        <td>
		        	<!-- <?=($nursery->status == 0)?"รอการประเมิน":"ผ่านเกณฑ์ <br>(พ.ศ. ".$nursery->approve_year.")";?> -->
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
		        </td>
	        </tr>
		<?php endforeach;?>
        </table>
        <?php echo $nurseries->pagination(); ?>
<?php endif;?>
	</div>