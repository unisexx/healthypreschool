<script type="text/javascript">
$(document).ready(function(){
	$("select[name=user_type_id]").change(function(){
        //alert( this.value );
        switch(this.value)
        {
			case '6':
   				$('.loading').show();
   				$('select[name=province_id],select[name=amphur_id]').remove();
   				$.post('officers/get_area',function(data){
   					$('.area').html(data);
   					$('.loading').hide();
   				});
			break;
			case '7':
				$('.loading').show();
				$('select[name=area_id],select[name=amphur_id]').remove();
   				$.post('officers/get_province',function(data){
   					$('.province').html(data);
   					$('.loading').hide();
   				});
			break;
			case '8':
				$('.loading').show();
				$('select[name=area_id],select[name=province_id]').remove();
				$.post('officers/get_province',function(data){
   					$('.province').html(data);
   					$('.loading').hide();
   				});
   				$.post('officers/get_amphur',function(data){
   					$('.amphur').html(data);
   					$('.loading').hide();
   				});
			break;
			default:
				$('select[name=area_id],select[name=province_id],select[name=amphur_id]').remove();
			break;
        }
    });

    // $('select[name=area_id]').live('change',function(){
    	// $('.loading').show();
    	// $('select[name=province_id],select[name=amphur_id]').remove();
    	// $.post('officers/get_province',{
    		// area_id : $(this).val()
    	// },function(data){
			// $('.province').html(data);
			// $('.loading').hide();
		// });
    // });


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
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">เจ้าหน้าที่สาธารณะสุข</li>
</ul>

<form method="get" action="officers">
	<div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
	<input type="text" name="name" value="<?=@$_GET['name']?>" placeholder="ค้นหาชื่อ,อีเมล์">

	<?=form_dropdown('m_status',array('active'=>'เปิด','deactive'=>'ปิด'),@$_GET['m_status'],'','--- เลือกสถานะ ---');?>
	

	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
		<?=form_dropdown('user_type_id',array('6'=>'เจ้าหน้าที่ประจำเขต','7'=>'เจ้าหน้าที่ประจำจังหวัด','8'=>'เจ้าหน้าที่ประจำอำเภอ'),@$_GET['user_type_id'],'class="input-xlarge"','--- เลือกประเภทเจ้าหน้าที่ ---');?>
	<?php elseif(user_login()->user_type_id == 6):?>
		<?=form_dropdown('user_type_id',array('7'=>'เจ้าหน้าที่ประจำจังหวัด','8'=>'เจ้าหน้าที่ประจำอำเภอ'),@$_GET['user_type_id'],'class="input-xlarge"','--- เลือกประเภทเจ้าหน้าที่ ---');?>
	<?php endif;?>

	<!-- <?php if(user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
   		<?php echo form_dropdown('province_id',get_option('id','name','v_provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
	<?php endif;?> -->

	<?php if(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	<?php endif;?>

	<span class="area"></span>
	<span class="province"></span>
	<span class="amphur"></span>

	<!-- <?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
	<span id="area" <?=(@$_GET['area_id'] == "" and @$_GET['user_type_id'] != 6)?"style='display:none;'":"";?>>
		<?=form_dropdown('area_id',array('1'=>'สคร.1','2'=>'สคร.2','3'=>'สคร.3','4'=>'สคร.4','5'=>'สคร.5','6'=>'สคร.6','7'=>'สคร.7','8'=>'สคร.8','9'=>'สคร.9','10'=>'สคร.10','11'=>'สคร.11','12'=>'สคร.12'),@$_GET['area_id'],'class="input-xlarge"','--- เลือกสคร. ---');?>
	</span>
	<?php endif;?>


	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
		<span id="province" <?=(@$_GET['province_id'] == "" and @$_GET['user_type_id'] != 7)?"style='display:none;'":"";?>>
   			<?php echo form_dropdown('province_id',get_option('id','name','provinces'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
   		</span>
   	<?php elseif(user_login()->user_type_id == 6): //เจ้าหน้าที่ประจำศูนย์ สคร.?>
   		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
   	<?php endif;?>


	<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกอำเภอ?>
		<span id="amphur" <?=(@$_GET['amphur_id'] == "" and @$_GET['user_type_id'] != 8)?"style='display:none;'":"";?>>
		<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
		</span>
	<?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
	    <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
	<?php endif;?>
	-->

	<!-- <?php get_area_dropdown(@$_GET['area_id']);?>
	<span id="province">
	<?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
	</span>
	<span id="amphur">
	<?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
	</span> -->
	
		<input type="hidden" name="search" value="1">
      <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
      <img class="loading" style="display: none;" src="media/images/ajax-loader.gif">
	</div>
</form>



<?if(@$_GET['search']==1): //ถ้ามีการกดปุ่มค้นหาให้แสดงข้อมูล?>



<div style="margin-bottom: 10px;">
	พบเจ้าหน้าที่ทั้งหมด <a href="nurseries/register?status=1"> <span class="badge badge-success"><?=$users->paged->total_rows;?></span></a>
</div>

<div class="pull-right" style="margin-bottom: 10px;">
	<a class="btn btn-primary" href="officers/form">เพิ่มเจ้าหน้าที่</a>
</div>

<table class="table">
    <tr>
        <th>ลำดับ</th>
        <th>สถานะ</th>
        <th>ชื่อ - นามสกุล</th>
        <th>เบอร์โทรศัพท์</th>
        <th>ประเภท</th>
        <th>พื้นที่</th>
        <th>วันที่สมัคร</th>
        <th width="80">จัดการ</th>
    </tr>
    <?php foreach($users as $key=>$user):?>
        <tr>
            <td><?=($key+1)+$users->paged->current_row?></td>
            <td><?=($user->m_status == 'active')?'<div class="label label-info">เปิด</div>':'<div class="label">ปิด</div>';?></td>
            <td><?=$user->name?></td>
            <td><?=$user->phone?></td>
            <td><?=$user->user_type->name?></td>
            <td>
                <?php
                    if($user->user_type_id == 6){
                        echo $user->area->area_name;
                    }elseif($user->user_type_id == 7){
                        echo $user->province->name;
                    }elseif($user->user_type_id == 8){
                        echo $user->amphur->amphur_name.' / '.$user->amphur->province->name;
                    }
                ?>
            </td>
            <td><?=mysql_to_th($user->created)?></td>
            <td>
                <a class="btn btn-mini" href="officers/form/<?=$user->id?>">แก้ไข</a>
                <a class="btn btn-mini" href="officers/delete/<?=$user->id?>" onclick="return confirm('<?php echo lang('notice_confirm_delete');?>')">ลบ</a>
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



<?endif;?>