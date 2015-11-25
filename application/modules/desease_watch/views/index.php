<!-- Header. -->
<ul class="breadcrumb">
      <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
      <li class="active">การเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</li>
</ul>


<!-- Search box. -->
<div id="data">
      <div style="font-size:14px;  font-weight:700; padding-bottom:10px; color:#3C3">การเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</div>
      <form method="get" action="">
            <div style="padding:10px; border:1px solid #ccc; margin-bottom:10px; line-height:50px;">
            	  <div style="width:150px;display:inline;float:left;">                  
				  <label for="province_id">จังหวัด</label>
                  <?php 
                  	if($current_user->user_type_id >= 7){
                  		$ext_condition = ' WHERE id = '.$current_user->province_id;
					}
                  	echo form_dropdown('province_id',get_option('id','name','provinces',@$ext_condition.' order by name asc'),@$_GET['province_id'],' style="width:150px;"','--- เลือกจังหวัด ---') 
                  ?>
                  </div>
                  <div style="width:250px;display:inline;float:left;">
				  <label for="amphur_id">อำเภอ</label>
                  <span id="amphur">
                        <?php if(@$_GET['province_id']):?>                        	
                        	<?php
                        	$ext_condition = 'where province_id = '.$_GET['province_id'];
                        	if($current_user->user_type_id >= 8){
		                  		$ext_condition .= ' AND id = '.$current_user->amphur_id;
							}
                        	?>
                              <?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures',$ext_condition.' order by amphur_name asc'),@$_GET['amphur_id'],'style="width:250px;"','--- เลือกอำเภอ ---') ?>
                        <?php endif;?>
                  </span>
				  </div>
				  <div style="width:150px;display:inline;">
				  <label for="district_id">ตำบล</label>
                  <span id="district">
                        <?php if(@$_GET['amphur_id']){?> 
	                        	<?php
	                        	$ext_condition = 'where province_id = '.$_GET['province_id'].' and amphur_id = '.$_GET['amphur_id'];
	                        	if($current_user->user_type_id > 8){
			                  		$ext_condition .= ' AND id = '.$current_user->district_id;
								}
	                        	?>
                              <?php echo form_dropdown('district_id',get_option('id','district_name','districts',$ext_condition.' order by district_name asc'),@$_GET['district_id'],'style="width:250px;"','--- เลือกตำบล ---') ?>
                        <?php }else { ?> 
                        <select name="district_id" disabled="disabled">
                        	<option value="">แสดงทั้งหมด</option>
                        </select>
                        <?php } ?>
                  </span>
				  </div>
				  <div style="display:block;height:15px;">&nbsp;</div>
				  <label for="name" style="margin-bottom:0px;">ชื่อศูนย์เด็กเล็ก</label>
				  <input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;"/>
                  <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
            </div>
      </form>
</div>


<!-- list content. -->
<?php echo $list->pagination(); ?>
<table class="table">
      <thead>
            <tr> <td colspan='6'> <?php echo anchor('desease_watch/form', 'เพิ่มข้อมูลการเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล', 'class="btn btn-default pull-right"'); ?> </td> </tr>
            <tr>
                  <th style='width:35px;'>ลำดับ</th>
                  <th style='width:90px;'>วันที่บันทึก</th>
                  <th style='width:90px;'>จังหวัด</th>
                  <th>โรค</th>
                  <th style='width:90px;'>หมายเลขศูนย์</th>
                  <th>ชื่อโรงเรียน</th>
            </tr>
      </thead>
      <tbody>
            <?php
                  if(empty($list->paged->total_rows)) {
                        echo '<tr><td colspan="6" style="text-align:center; color:#aaa;">ไม่พบข้อมูล</td></tr>';
                  }
                  foreach($list as $item):?>
                        <tr>
                              <td><?php echo ++$no; ?></td>
                              <td><?php echo mysql_to_th($item->created_date); ?></td>
                              <td><?php echo (empty($item->nursery->province->name))?'-':$item->nursery->province->name; ?></td>
                              <d><?php echo @$diseaseText[$item->disease]; ?></td>
                              <td><?php echo (empty( $item->nursery->code))?'-': $item->nursery->code; ?></td>
                              <td><?php echo (empty($item->nursery->name))?'ไม่ระบุชื่อโรงเรียน':$item->nursery->name; ?></td>
                        </tr>
                  <?php endforeach;
            ?>
      </tbody>
</table>


<!-- Script -->
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