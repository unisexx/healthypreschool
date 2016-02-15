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
  <li class="active">ลงทะเบียนเจ้าหน้าที่ครูโรงเรียนอนุบาล</li>
</ul>
    <div id="data">
    	<div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">ค้นหาข้อมูลโรงเรียนอนุบาล</div>
    	
    	<form method="get" action="users/register_center_school">
	    	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	    		<?//=form_dropdown('nursery_category_id',get_option('id','title','nursery_categories'),@$_GET['nursery_category_id'],'','--- เลือกคำนำหน้า ---');?>
	    		<input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อโรงเรียน" style="width:280px;"/>
	    		
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
	ผลการค้นหาพบทั้งหมด <?=$count->total?> แห่ง
        <div style="float:right; padding:10px 0;">
        	<a href="users/register_center_school_form"><div class="btn">ลงทะเบียนโรงเรียนใหม่</div></a>
        </div>
    	<table class="table">
        <tr>
	        <th>ลำดับ</th>
	        <th>ชื่อโรงเรียน</th>
	        <th>ที่อยู่</th>
	        <!-- <th>ปีที่เข้าร่วม</th>
	        <th>หัวหน้าศูนย์</th> -->
	        <th></th>
        </tr>
        <?php foreach($nurseries as $key=>$nursery):?>
        	<tr>
		        <td><?$_GET['page'] = (@$_GET['page'] == "")?"1":@$_GET['page'];?><?=($key+1)+(20 * (@$_GET['page'] - 1));?></td>
		        <td><?//=$nursery->title?><?=$nursery->name?></td>
		        <td style="white-space: nowrap; overflow: hidden; text-overflow:ellipsis;">ต.<?=$nursery->district_name?> อ.<?=$nursery->amphur_name?> จ.<?=$nursery->province_name?></td>
		        <!-- <td><?=$nursery->year?></td>
		        <td>
		        	<?php if($nursery->p_title == "นาย"):?>
		        		<img class="icon-boy" src="themes/hps/images/boy.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
		        	<?php else:?>
		        		<img class="icon-girl" src="themes/hps/images/girl.png" rel="tooltip" data-placement="top" data-original-title="<?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?>">
		        	<?php endif;?>
		        </td> -->
		        <td>
		        	<!-- <a href="users/register_center_form/<?=$nursery->id?>" class="btn btn-mini">ลงทะเบียน</a> -->
		        	<?=chk_center_status($nursery->id)?>
		        </td>
	        </tr>
		<?php endforeach;?>
        </table>
        <?php echo $pagination; ?>
<?php endif;?>
	</div>