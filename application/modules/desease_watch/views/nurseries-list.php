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
                              <?php echo form_dropdown('province_id',get_option('id','name','provinces','order by name asc'),@$_GET['province_id'],false,'--- เลือกจังหวัด ---') ?>
                        </span>
                        
                        <span class="searchBox">
                              <div class='searchLabel'>อำเภอ</div>
                              <div id="amphur">
                                    <?php 
                                          if(@$_GET['province_id']):
                                                echo form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$_GET['province_id'].' order by amphur_name asc'),@$_GET['amphur_id'],'','--- เลือกอำเภอ ---');
                                          else :
                                                echo form_dropdown('amphur_id', array(), false, 'disabled="disabled"', '---กรุณาเลือกข้อมูลจังหวัด---');
                                          endif;
                                    ?>
                              </div>
                        </span>
                        
                        <span class="searchBox">
                              <div class='searchLabel'>ตำบล</div>
                              <div id="district">
                                    <?php 
                                          if(@$_GET['amphur_id']):
                                                echo form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$_GET['amphur_id'].' order by district_name asc'),@$_GET['district_id'],'','--- เลือกตำบล ---');
                                          else :
                                                echo form_dropdown('district_id', array(), false, 'disabled="disabled"', '---กรุณาเลือกข้อมูลอำเภอ---');
                                          endif;
                                    ?>
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


<?php if(!empty($_GET)) { ?>
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
                        $('#amphur').html('<select disabled="disabled"><option value="">Loading...</option></select>');

                        $.get('desease_watch/get_amphur', {
                              province_id:$('[name=province_id] option:selected').val()
                        }, function(data){
                              $('#amphur').html(data);
                        });
                  },
                  loadDistrict:function(){
                        $('#district').html('<select disabled="disabled"><option value="">Loading...</option></select>');
                        
                        $.get('desease_watch/get_district', {
                              amphur_id:$('[name=amphur_id] option:selected').val()
                        }, function(data){
                              $('#district').html(data);
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