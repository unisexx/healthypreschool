<h1>ออกใบประกาศนียบัตร</h1>
<div class="search">
	<form class="form-inline" method="get">
		<table class="form">
			<tr>
				<td>
					<input type="text" name="start_date" value="<?=@$_GET['date_status'] ? @$_GET['start_date'] : "" ;?>" class="datepicker" placeholder="วันที่เริ่ม" />
					<input type="text" name="end_date" value="<?=@$_GET['date_status'] ? @$_GET['end_date'] : "" ;?>" class="datepicker" placeholder="วันที่สิ้นสุด" />
				</td>
			</tr>
			<tr>
				<td>
				<?//=form_dropdown('user_type_id',get_option('id','name','user_types'),@$_GET['user_type_id'],'','--- เลือกประเภทผู้ใช้งาน ---');?>
					<input type="text" name="search" value="<?=@$_GET['search']?>" placeholder="ชื่อ">
					
				<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
					<?=form_dropdown('user_type_id',array('6'=>'เจ้าหน้าที่ประจำเขต','7'=>'เจ้าหน้าที่ประจำจังหวัด','8'=>'เจ้าหน้าที่ประจำอำเภอ','9'=>'เจ้าหน้าที่ศูนย์','10'=>'เจ้าหน้าที่ครู / ผู้ดูแลเด็ก'),@$_GET['user_type_id'],'class="input-xlarge"','--- เลือกประเภท ---');?>
				<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>
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
				</td>
			</tr>
			<tr>
				<td><input class="btn" type="submit" value="ค้นหา" /></td>
			</tr>
		</table>
	</form>
</div>

<?php echo $reports->pagination()?>
<table class="table table-striped">
	<tr>
		<th>ชื่อ</th>
		<th>วันที่ผ่านการทดสอบ</th>
		<th></th>
	</tr>
	<?foreach($reports as $row):?>
	<tr>
		<td><?=$row->name?></td>
		<td><?=thainumDigit(mysql_to_th_cert($row->update_date,"F"))?></td>
		<td><a href="elearnings/admin/certs/printcert/<?=$row->user_id?>" target="_blank"><div class="btn btn-success">พิมพ์ใบประกาศ</div></a></td>
	</tr>
	<?endforeach;?>
</table>
<?php echo $reports->pagination()?>

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
    	// $.post('officers/get_area',{
    		// area_id : '<?php echo @$_GET['area_id']?>'
    	// },function(data){
			// $('.area').html(data);
			// $('.loading').hide();
		// });
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