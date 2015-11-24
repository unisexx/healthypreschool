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
                        <td><?php echo $item->nursery->province->name; ?></td>
                        <td><?php echo $item->disease; ?></td>
                        <td><?php echo $item->nursery->code; ?></td>
                        <td><?php echo $item->nursery->name; ?></td>
                  </tr>
            <?php endforeach;?>
      </tbody>
</table>