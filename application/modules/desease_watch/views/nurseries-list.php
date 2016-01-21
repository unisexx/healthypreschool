<style media="screen">
      .searchBox { display:inline-block; margin-right:10px; min-width:220px; }
      .searchLabel { font-weight:bold; }
</style>

<div id="data">
      <!-- <div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">ค้นหาข้อมูลรายชื่อศูนย์เด็กเล็กและโรงเรียนอนุบาล</div> -->

      <form id="formSearch" method="get" action="">
            <div style="padding:10px; border:1px solid #ccc; margin-bottom:10px;">
      
                  <div style='margin:10px 0;'>
                        <span class="searchBox">
                              <div class='searchLabel'>จังหวัด</div>
                              <div id="province_search">
                              <?php 
			                  	if($current_user->user_type_id >= 7){
			                  		$ext_condition = ' WHERE id = '.$current_user->province_id;
								}
			                  	echo form_dropdown('province_id',get_option('id','name','provinces',@$ext_condition.' order by name asc'),@$_GET['province_id'],' style="width:150px;"','--- เลือกจังหวัด ---') 
			                  ?>
			                  </div>
                        </span>
                        
                        <span class="searchBox">
                              <div class='searchLabel'>อำเภอ</div>
                              <div id="amphur_search">
                                    <?php if(@$_GET['province_id']):?>                        	
			                        	<?php
			                        	$ext_condition = 'where province_id = '.$_GET['province_id'];
			                        	if($current_user->user_type_id >= 8){
					                  		$ext_condition .= ' AND id = '.$current_user->amphur_id;
										}
			                        	?>
			                              <?php echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures',$ext_condition.' order by amphur_name asc'),@$_GET['amphur_id'],'style="width:250px;"','--- เลือกอำเภอ ---') ?>
			                        <?php endif;?>
                              </div>
                        </span>
                        
                        <span class="searchBox">
                              <div class='searchLabel'>ตำบล</div>
                              <div id="district_search">
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
                              </div>
                        </span>
                  </div>
                  
                  <div style='margin:10px 0;'>
                        <div class="searchLabel">คำค้น</div>
                        <input name="name" type="text" value="<?php echo @$_GET['name']?>" placeholder="ชื่อศูนย์เด็กเล็ก" style="width:675px;"/>
                  </div>
                  <button type="button" class="btn btn-primary" id="btnNurserySubmitSearch">ค้นหา</button>
            </div>
      </form>
 </div>


<?php if(!empty($_GET) && @$_GET['search']!='') { ?>
      <table class='table'>
            <thead>
                  <tr>
                        <th>ลำดับ</th>
                        <th>ชื่อศูนย์พัฒนาเด็กเล็ก</th>
                        <th>ที่อยู่</th>
                        <th>ปีที่เข้าร่วม</th>
                        <th>หัวหน้าศูนย์</th>
                        <th>ผลการประเมิน</th>
                        <th></th>
                  </tr>
            </thead>
            <tbody>
                  <?php 
                        if(empty($list)) { 
                              echo '<tr><td colspan="7" style="text-align:center; color:#aaa;">';
                                    echo (empty($_GET['name']) && empty($_GET['province_id']) && empty($_GET['amphur_id']) && empty($_GET['district_id']))?'กรุณาระบุข้อมูลสำหรับการค้นหา':'ไม่พบข้อมูล';
                              echo '</td></tr>';
                        } else {
                              foreach($list as $item) {
                                    // หัวหน้าศูนย์
                                    $chifeDevCen = ($item->p_title == 'นาย')?'boy':'girl';
                                    $chifeDevCen = '<img class="icon-'.$chifeDevCen.'" src="themes/hps/images/'.$chifeDevCen.'.png" rel="tooltip" data-placement="top" data-original-title="'.$item->p_title.$item->p_name.' '.$item->p_surname.'">';
                                    
                                    echo '<tr>';
                                          echo '<td>'.(++$no).'</td>';
                                          echo '<td class="listName">'.$item->name.'</td>';
                                          echo '<td>';
                                                echo 'ต.<span class="listDistrict">'.$item->district_name.'</span><br>';
                                                echo 'อ.<span class="listAmphur">'.$item->amphur_name.'</span><br>';
                                                echo 'จ.<span class="listProvince">'.$item->province_name.'</span>';
                                          echo '</td>';
                                          echo '<td>'.$item->year.'</td>';
                                          echo '<td>'.$chifeDevCen.'</td>';
                                          echo '<td>'.$item->status.'</td>';
                                          echo '<td><button class="btn btn-default btnSelectNursery" code="'.$item->code.'" rel="'.$item->id.'">เลือก</button></td>';
                                    echo '</tr>';
                              }
                        }
                  ?>
            </tbody>
      </table>
<?php } ?>


<script type="text/javascript">
      $(document).ready(function(){
            loadSearch = {
                  loadAmphur:function(){
                        $('#amphur_search').html('<select disabled="disabled"><option value="">Loading...</option></select>');

                        $.get('desease_watch/get_amphur', {
                              province_id:$('#province_search>select[name=province_id] option:selected').val()
                        }, function(data){
                              $('#amphur_search').html(data);
                        });
                  },
                  loadDistrict:function(){
                        $('#district_search').html('<select disabled="disabled"><option value="">Loading...</option></select>');
                        
                        $.get('desease_watch/get_district', {
                              amphur_id:$('#amphur_search>select[name=amphur_id] option:selected').val()
                        }, function(data){
                              $('#district_search').html(data);
                        });
                  }
            };
            
            
      	$("select[name='province_id']").live("change",function(){
                  loadSearch.loadAmphur();
                  loadSearch.loadDistrict();
      	});
            
            $("select[name='amphur_id']").live("change",function(){
                  loadSearch.loadDistrict();
      	});
      });
</script>