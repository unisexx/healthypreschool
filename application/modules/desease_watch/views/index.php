<!-- Header. -->
<ul class="breadcrumb">
      <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
      <li class="active">ข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ</li>
</ul>


<!-- Search box. -->
<div id="data">
      <h4>ข้อมูลเหตุการณ์การเฝ้าระวังโรคติดต่อ</h4>
      <form method="get" action="">
            <div style="padding:10px; border:1px solid #ccc; margin-bottom:10px; line-height:50px;">
                  <label for="disease" style="margin-bottom:0px;">โรค</label>
                  <?php echo form_dropdown('disease', get_option('id', 'desease_name', 'desease_watch_names', ' order by id '), @$_GET['disease'], '', '--แสดงทั้งหมด--');?>
                  <div style="display:block;height:15px;">&nbsp;</div>
            	  <div style="width:150px;display:inline;float:left;">
    				  <label for="area_id">เขตสคร.</label>
                      <?php get_area_dropdown(@$_GET['area_id']);?>
                  </div>
            	  <div style="width:150px;display:inline;float:left;">
    				  <label for="province_id">จังหวัด</label>
    				  <span id="province">
                      <?php get_province_dropdown(@$_GET['area_id'],@$_GET['province_id']);?>
                      </span>
                  </div>
                  <div style="width:220px;display:inline;float:left;">
				  <label for="amphur_id">อำเภอ</label>
                  <span id="amphur">
                  <?php get_amphur_dropdown(@$_GET['province_id'],@$_GET['amphur_id']);?>
                  </span>
				  </div>
				  <div style="width:150px;display:inline;">
				  <label for="district_id">ตำบล</label>
                  <span id="district">
                  <?php get_district_dropdown(@$_GET['amphur_id'],@$_GET['district_id']);?>
                  </span>
				  </div>
				  <div style="display:block;height:15px;">&nbsp;</div>
				  <div style="width:250px;display:inline;float:left;">
    				  <label for="name" style="margin-bottom:0px;">พื้นที่ที่เกิดโรค</label>
    				  <select name="place_type" class="form-control">
                            <option value="">-- ระบุแหล่งเกิดโรค --</option>
                            <option value="2" <?php echo $selected = @$_GET['place_type'] == 2 ? 'selected="selected"' : '';?>>พื้นที่ชุมชน</option>
                            <option value="1" <?php echo $selected = @$_GET['place_type'] == 1 ? 'selected="selected"' : '';?>>ศูนย์เด็กเล็ก/โรงเรียนอนุบาล</option>
                      </select>
                  </div>
                  <div style="width:350px;display:inline;float:left;">
				    <label for="name" style="margin-bottom:0px;">ชื่อศูนย์เด็กเล็ก</label>
				    <input name="name" type="text" value="<?=@$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:280px;"/>
				  </div>
				  <div style="display:block;height:15px;">&nbsp;</div>
				  <br>
                    <input class="btn btn-primary" type="submit" value=" ค้นหา " style="margin-bottom: 10px;">
            </div>
      </form>
</div>


<!-- list content. -->
<?php echo $list->pagination(); ?>
<div style="float:right;">
<?php echo anchor('desease_watch/form', 'เพิ่มข้อมูลการเฝ้าระวังโรคติดต่อ', 'class="btn btn-primary pull-right"'); ?>
</div>
<table class="table table-bordered table-hover">
      <thead>
            <tr>
                  <th style='width:35px;'>ลำดับ</th>
                  <th>โรค</th>
                  <th style='width:90px;'>วันที่บันทึก</th>
                  <th style='width:90px;'>จังหวัด</th>
                  <th style='width:90px;'>พื้นที่</th>
                  <th>ชื่อโรงเรียน</th>
                  <th>จัดการข้อมูล</th>
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
                              <td>
                                  <?php
                                    $desease_name = new Desease_Watch_name($item->disease);
                                    echo $desease_name->desease_name;
                                  ?>
                              </td>
                              <td><?php echo mysql_to_th($item->created_date); ?></td>
                              <td><?php echo (empty($item->province->name))?'-':$item->province->name; ?></td>
                              <td>
                                  <?php
                                       switch($item->place_type):
                                           case 1:
                                               echo 'ศูนย์เด็กเล็ก/โรงเรียนอนุบาล';
                                               break;
                                           case 2:
                                               echo 'พื้นที่ชุมชน';
                                           break;
                                           default:
                                               echo '-';
                                           break;
                                       endswitch;
                                  ?>
                              </td>
                              <td>
                                  <?php
                                    if($item->place_type == 1){
                                        $school_name = (empty( $item->nursery->code))? 'รหัส : -<br>': 'รหัส  : '.$item->nursery->code.'<br>';
                                        //$school_name.= $school_name!='' ? ' : ' : '';
                                        $school_name.= (empty($item->nursery->name))?'':$item->nursery->name;
                                        echo $school_name;
                                    }
                                  ?>
                              </td>
                              <td>
                                    <?php
                                          echo anchor('desease_watch/form/'.$item->id, 'แก้ไข', 'class="btn btn-sm btn-warning"').' ';
                                          echo anchor('desease_watch/delete/'.$item->id, 'ลบ', 'class="btn btn-sm btn-danger" onclick="if(!confirm(\'กรุณายืนยันการลบข้อมูล\')) return false;"');
                                    ?>
                              </td>
                        </tr>
                  <?php endforeach;
            ?>
      </tbody>
</table>


<!-- Script -->
<script type="text/javascript">
      $(document).ready(function(){
      	$("select[name='area_id']").live("change",function(){
      		$.post('ajax/get_province',{
      				'area_id' : $(this).val()
      			},function(data){
      				$("#province").html(data);
      			});
      	});
      	$("select[name='province_id']").live("change",function(){
      		$.post('ajax/get_amphur',{
      				'province_id' : $(this).val()
      			},function(data){
      				$("#amphur").html(data);
      			});
      	});

      	$("select[name='amphur_id']").live("change",function(){
      		$.post('ajax/get_district',{
      				'amphur_id' : $(this).val()
      			},function(data){
      				$("#district").html(data);
      			});
      	});
      });
</script>
