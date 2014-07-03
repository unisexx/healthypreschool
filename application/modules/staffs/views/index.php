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
	
	<?=form_dropdown('m_status',array('active'=>'เปิด','deactive'=>'ปิด'),@$_GET['m_status'],'','--- เลือกสถานะ ---');?>
	
	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
		<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	<?php endif;?>
	
	<input type="text" name="name" value="<?=@$_GET['name']?>" placeholder="ค้นหาชื่อ">
	
	<?php if(user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
   		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	<?php endif;?>
	  
	<?php if(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	<?php endif;?>
	
	<span class="area"></span>
	<span class="province"></span>
	<span class="amphur"></span>
	
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>
    	
    	
<table class="table">
    <tr>
        <th>ลำดับ</th>
        <th>สถานะ</th>
        <th>อีเมล์</th>
        <th>ชื่อ - นามสกุล</th>
        <th>เจ้าหน้าที่ศูนย์เด็กเล็ก</th>
        <th>จังหวัด</th>
        <th>อำเภอ</th>
        <th>ตำบล</th>
        <th>วันที่สมัคร</th>
        <th width="80">
        	<!-- <a class="btn btn-mini btn-info" href="staff/form">เพิ่มเจ้าหน้าที่</a> -->
        </th>
    </tr>
    <?php foreach($users as $key=>$user):?>
        <tr>
            <td><?=($key+1)+$users->paged->current_row?></td>
            <td><?=($user->m_status == 'active')?'<div class="label label-info">เปิด</div>':'<div class="label">ปิด</div>';?></td>
            <td><?=$user->email?></td>
            <td><?=$user->name?></td>
            <td><?=$user->nursery->nursery_category->title?><?=$user->nursery->name?></td>
            <td><?=$user->nursery->province->name?></td>
            <td><?=$user->nursery->amphur->amphur_name?></td>
            <td><?=$user->nursery->district->district_name?></td>
            <td><?=mysql_to_th($user->created)?></td>
            <td>
                <a class="btn btn-mini" href="staffs/form/<?=$user->id?>">แก้ไข</a>
                <a class="btn btn-mini" href="staffs/delete/<?=$user->id?>" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
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