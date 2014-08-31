<script type="text/javascript">
$(document).ready(function(){
    $('select[name=province_id]').live('change',function(){
    	if($('select[name=user_type_id]').val() == 8){
    		$('.loading').show();
	    	$('select[name=amphur_id]').remove();
	    	$.post('officers/get_amphur',{
	    		province_id : $(this).val()
	    	},function(data){
				$('.amphur').html(data);
				$('.loading').hide();
			});
    	}
    });
    
    <?php if(user_login()->user_type_id == 1):?>
    $("select[name=province_id]").live("change",function(){
		$.post('nurseries/get_amphur',{
				'province_id' : $(this).val()
			},function(data){
				$(".amphur").html(data);
			});
	});
	
	$("select[name=amphur_id]").live("change",function(){
		$.post('nurseries/get_district',{
				'amphur_id' : $(this).val()
			},function(data){
				$(".district").html(data);
			});
	});
	<?php endif;?>
    
    <?php if(@$_GET['user_type_id'] == 6):?>
    	$.post('officers/get_area',{
    		area_id : '<?php echo @$_GET['area_id']?>'
    	},function(data){
			$('.area').html(data);
			$('.loading').hide();
		});
    <?php endif;?>
    
    <?php if(@$_GET['user_type_id'] == 7):?>
    	$.post('officers/get_province',{
    		province_id : '<?php echo @$_GET['province_id']?>'
    	},function(data){
			$('.province').html(data);
			$('.loading').hide();
		});
    <?php endif;?>
    
    <?php if(@$_GET['user_type_id'] == 8):?>
    $.post('officers/get_province',{
    		province_id : '<?php echo @$_GET['province_id']?>'
    	},function(data){
			$('.province').html(data);
			$('.loading').hide();
		});
		
    	$.post('officers/get_amphur',{
    		province_id : '<?php echo @$_GET['province_id']?>',
    		amphur_id : '<?php echo @$_GET['amphur_id']?>'
    	},function(data){
			$('.amphur').html(data);
			$('.loading').hide();
		});
    <?php endif;?>
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">เจ้าหน้าที่ศูนย์เด็กเล็ก</li>
</ul>

<form method="get" action="staffs">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<input type="text" name="search" value="<?=@$_GET['search']?>" placeholder="ค้นหาชื่อ, อีเมล์">
	<input type="text" name="nursery_name" value="<?=@$_GET['nursery_name']?>" placeholder="ค้นหาศูนย์เด็กเล็ก">
	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
		<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	<?php endif;?>
	
	<?php if(user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
   		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	<?php endif;?>
	  
	<?php if(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	<?php endif;?>
	
	<span class="area"></span>
	<span class="province"></span>
	<span class="amphur">
		<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
			<?php if(@$_GET['province_id']):?>
				<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures where province_id = '.@$_GET['province_id']),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
			<?php endif;?>
		<?php endif;?>
	</span>
	<span class="district">
		<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกตำบล?>
			<?php if(@$_GET['amphur_id']):?>
			<?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.@$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
			<?php endif;?>
		<?php endif;?>
	</span>
	
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>
    	
<div style="margin-bottom: 10px;">
	พบเจ้าหน้าที่ทั้งหมด <span class="badge badge-success"><?=$users->paged->total_rows;?></span>
</div>
    	
<!-- <div style="float: right; margin-bottom:5px;">
	<a class="btn btn-mini btn-info" href="staff/form">เพิ่มเจ้าหน้าที่ศูนย์</a> | <a class="btn btn-mini btn-info" href="#">เพิ่มเจ้าหน้าที่ครู</a>
</div> -->
<table class="table">
    <tr>
        <th>ลำดับ</th>
        <th>สถานะเจ้าหน้าที่</th>
        <th>อีเมล์</th>
        <th>ชื่อ - นามสกุล</th>
        <th>เจ้าหน้าที่ศูนย์เด็กเล็ก</th>
        <!-- <th>ที่อยู่</th> -->
        <!-- <th>อำเภอ</th>
        <th>ตำบล</th> -->
        <th>วันที่สมัคร</th>
        <th width="90">
        	<!-- <a class="btn btn-mini btn-info" href="staffs/adform">เพิ่มเจ้าหน้าที่</a> -->
        </th>
    </tr>
    <?php foreach($users as $key=>$user):?>
        <tr>
            <td><?=($key+1)+$users->paged->current_row?></td>
            <td><?=($user->user_type_id == 9)? 'เจ้าหน้าที่ศูนย์' : 'เจ้าหน้าที่ครู' ;?></td>
            <td><?=$user->email?></td>
            <td><?=$user->name?></td>
            <td>
            	<?=$user->nursery->nursery_category->title?><?=$user->nursery->name?><br>
            	จ.<?=$user->nursery->province->name?><br>อ.<?=$user->nursery->amphur->amphur_name?><br>ต.<?=$user->nursery->district->district_name?>
            </td>
            <!-- <td>จ.<?=$user->nursery->province->name?><br>อ.<?=$user->nursery->amphur->amphur_name?><br>ต.<?=$user->nursery->district->district_name?></td> -->
            <!-- <td><?=$user->nursery->amphur->amphur_name?></td>
            <td><?=$user->nursery->district->district_name?></td> -->
            <td><?=mysql_to_th($user->created)?></td>
            <td>
            	<a class="btn btn-mini" href="staffs/form/<?=$user->nursery_id?>">เพิ่มเจ้าหน้าที่ครู</a>
                <a class="btn btn-mini" href="staffs/form/<?=$user->nursery_id?>/<?=$user->id?>">แก้ไข</a>
                <a class="btn btn-mini" href="staffs/delete/<?=$user->id?>" style="width:27px;" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
            </td>
        </tr>
    <?php endforeach;?>
</table>

<?=$users->pagination();?>

<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
    <div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
    <div class="modal-body-form"></div>
  </div>
</div>