<h1>รายงาน E-learning</h1>
<div class="search">
	<form class="form-inline" method="get">
		<table class="form">
			<tr>
				<td>
					<?php echo form_dropdown('topic_id',get_option('id','title','question_topics where status = "approve" order by orderlist'),@$_GET['topic_id'],' required ','--- เลือกแบบทดสอบ ---');?>
					<?php echo form_dropdown('status',array('1'=>'ไม่ผ่าน','2'=>'ผ่าน'),@$_GET['status'],'','--- เลือกสถานะการทดสอบ ---');?>
					<?php //echo form_dropdown('date_status',array('1'=>'เริ่มทำแบบทดสอบ','2'=>'ทำแบบทดสอบเสร็จ'),@$_GET['date_status'],'','--- เลือกช่วงเวลา ---');?>
					<input type="text" name="start_date" value="<?php echo @$_GET['start_date'];?>" class="datepicker" placeholder="ช่วงเวลาที่ทดสอบ (เริ่มต้น)" />
					<input type="text" name="end_date" value="<?php echo @$_GET['end_date'];?>" class="datepicker" placeholder="ช่วงเวลาที่ทดสอบ (สิ้นสุด)" />
				</td>
			</tr>
			<tr>
				<td>
				<?//=form_dropdown('user_type_id',get_option('id','name','user_types'),@$_GET['user_type_id'],'','--- เลือกประเภทผู้ใช้งาน ---');?>
					<input type="text" name="search" value="<?=@$_GET['search']?>" placeholder="ชื่อผู้ทดสอบ">
					
				<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
					<?=form_dropdown('user_type_id',get_option('id','name','user_types'),@$_GET['user_type_id'],'class="input-xlarge"','--- เลือกประเภทผู้ทดสอบ ---');?>
				<?php endif;?>
				</td>
			</tr>
			<tr>
				<td>
				<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
				    <?php echo form_dropdown('area_id',get_option('id','area_name','areas','order by id asc'),@$_GET['area_id'],' id="area" ','--- เลือกเขตสคร  ---') ?>
				    <span id="province">
					<?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
					</span>
				<?php endif;?>
				
				<?php if(user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
				    <span id="province">
			   		<?php echo form_dropdown('province_id',get_option('id','name','provinces','where area_id = '.user_login()->area_id.' order by name asc'),@$_GET['province_id'],'','--- เลือกจังหวัด ---') ?>
			   		</span>
				<?php endif;?>
				  
				<?php if(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
				    <span id="amphur">
					<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
					</span>
				<?php endif;?>
												
				
					<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกจังหวัด?>
					    <span class="amphur">
						<?php if(@$_GET['province_id']):?>
							<?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures where province_id = '.@$_GET['province_id']),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');?>
						<?php endif;?>
						</span>
					<?php endif;?>
								
					<?php if(user_login()->user_type_id == 1): //แอดมินเห็นทุกตำบล?>
					    <span class="district">
						<?php if(@$_GET['amphur_id']):?>
						<?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.@$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');?>
						<?php endif;?>
						</span>
					<?php endif;?>				
				</td>
			</tr>
			<tr>
				<td><input class="btn" type="submit" value="ค้นหา" /></td>
			</tr>
		</table>
	</form>
</div>

<?php if(@$_GET):?>
<table class="table table-striped">
	<tr>
		<th>ลำดับ</th>
		<th>USERID</th>
		<th>ชื่อ</th>
		<th>ประเภทผู้ใช้</th>
		<th>เขตสคร.</th>
		<th>จังหวัด</th>
		<th>อำเภอ</th>
		<th>ตำบล</th>
		<th>ศูนย์เด็กเล็ก/โรงเรียนอนุบาล</th>
		<th>แบบทดสอบ</th>
		<th>ผ่านเกณฑ์</th>
		<th>ทำได้</th>
		<th>สถานะ</th>
		<th>วันที่ทำ</th>
	</tr>
	<?
	$i=0;
	foreach($reports as $row):
	$i++;
	?>
	<tr>
	    <td><?php echo $i;?></td>
	    <td><?php echo $row->user_id;?></td>
		<td><?=$row->name?></td>
		<td><?=$row->user_type_name?></td>
		<td><?=$row->area_name?></td>
		<td><?=$row->province_name?></td>
		<td><?=$row->amphur_name?></td>
		<td><?=$row->district_name?></td>
		<td><?=$row->nursery_name?></td>
		<td><?=$row->topic_title?></td>
		<td><?=$row->pass?></td>
		<td><?=$row->n_user_score?></td>
		<td><?=$row->n_user_score >= $row->pass ? "ผ่าน" : "ไม่ผ่าน";?></td>
		<td><?=mysql_to_th($row->update_date,'S',TRUE);?></td>
	</tr>
	<?endforeach;?>
</table>
<?php //echo $reports->pagination()?>
<?php endif;?>
<script type="text/javascript">
$(document).ready(function(){
    
    $("select[name='area_id']").live("change",function(){
        $.post('ajax/get_province',{
                'area_id' : $(this).val(),
                'mode':'all'
            },function(data){
                $("#province").html(data);
        });

        $.post('ajax/get_amphur',{
                'province_id' : '',
                'mode':'all'
            },function(data){
                $("#amphur").html(data);
            });

        $.post('ajax/get_district',{
                'amphur_id' : '',
                'mode':'all'
            },function(data){
                $("#district").html(data);
            });
    });
    
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