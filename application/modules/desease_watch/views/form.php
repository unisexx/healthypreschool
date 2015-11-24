<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<script type="text/javascript">
      $(function(){
            //Modal (Nurseries_list) 
            $('#btnCallNurseriesList').on('click', function(){
                  $.get('desease_watch/nurseries_list', function(data){
                        $('#nurseries_list').find('div.modal-body').html(data);
                  });
            });
            $('#btnNurserySubmitSearch').live('click', function(){
                  name = $('#nurseries_list').find('div.modal-body').find('[name=name]').val();
                  province_id = $('#nurseries_list').find('div.modal-body').find('[name=province_id] option:selected').val();
                  amphur_id = $('#nurseries_list').find('div.modal-body').find('[name=amphur_id] option:selected').val();
                  district_id = $('#nurseries_list').find('div.modal-body').find('[name=district_id] option:selected').val();
                  //alert(province_id);
                  
                  $('#nurseries_list').find('div.modal-body').html("<div style='text-align:center; color:#aaa;'>Loading...</div>");
                  
                  $.get('desease_watch/nurseries_list', {
                        name : name,
                        province_id : province_id,
                        amphur_id : amphur_id,
                        district_id : district_id
                  }, function(data){
                        $('#nurseries_list').find('div.modal-body').html(data);
                  });
                  /**/
            });
            
            $('#nurseries_list .btnSelectNursery').live('click', function(){
                  id = $(this).attr('rel');
                  code = $(this).attr('code');
                  name = $(this).parent().parent().find('.listName').html();
                  province = $(this).parent().parent().find('.listProvince').html();
                  amphur = $(this).parent().parent().find('.listAmphur').html();
                  district = $(this).parent().parent().find('.listDistrict').html();
                  
                  $('[name=nurseries_id]').val(id);
                  $('#nurseryCode').val(code);
                  $('#nurseryName').val(name);
                  $('#nurseryProvince').val(province);
                  $('#nurseryAmphur').val(amphur);
                  $('#nurseryDistrict').val(district);
                                    
                  $('#nurseries_list').modal('hide')
            });
            
            $('#btnCallNurseriesList').attr('disabled', false).attr('data-toggle', 'modal');
            
            
            //datepiceker
            $('.datepicker').css({ width:"80px" }).datepicker({  
                    dateFormat: 'dd/mm/yy',  
                    //showOn: 'button',  
            //      buttonImage: 'http://jqueryui.com/demos/datepicker/images/calendar.gif',  
                    buttonImageOnly: false,  
                    dayNamesMin: ['อา', 'จ', 'อ', 'พ', 'พฤ', 'ศ', 'ส'],   
                    monthNamesShort: ['มกราคม','กุมภาพันธ์','มีนาคม','เมษายน','พฤษภาคม','มิถุนายน','กรกฎาคม','สิงหาคม','กันยายน','ตุลาคม','พฤศจิกายน','ธันวาคม'],  
                    changeMonth: true,  
                    changeYear: true,  
                    beforeShow:function(){    
                        if($(this).val()!=""){  
                            var arrayDate=$(this).val().split("-");       
                            arrayDate[2]=parseInt(arrayDate[2])-543;  
                            $(this).val(arrayDate[0]+"-"+arrayDate[1]+"-"+arrayDate[2]);  
                        }  
                        setTimeout(function(){  
                            $.each($(".ui-datepicker-year option"),function(j,k){  
                                var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;  
                                $(".ui-datepicker-year option").eq(j).text(textYear);  
                            });               
                        },50);  
                    },  
                    onChangeMonthYear: function(){  
                        setTimeout(function(){  
                            $.each($(".ui-datepicker-year option"),function(j,k){  
                                var textYear=parseInt($(".ui-datepicker-year option").eq(j).val())+543;  
                                $(".ui-datepicker-year option").eq(j).text(textYear);  
                            });               
                        },50);        
                    },  
                    onClose:function(){  
                        if($(this).val()!="" && $(this).val()==dateBefore){           
                            var arrayDate=dateBefore.split("/");  
                            arrayDate[2]=parseInt(arrayDate[2])+543;  
                            $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);      
                        }         
                    },  
                    onSelect: function(dateText, inst){   
                        dateBefore=$(this).val();  
                        var arrayDate=dateText.split("/");  
                        arrayDate[2]=parseInt(arrayDate[2])+543;  
                        $(this).val(arrayDate[0]+"/"+arrayDate[1]+"/"+arrayDate[2]);  
                    }     
              
              });
       });
</script>

<!-- Modal -->
<div id="nurseries_list" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true">
      <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h3 id="myModalLabel">ค้นหารายชื่อศูนย์เด็กเล็กและโรงเรียนอนุบาล</h3>
      </div>
      <div class="modal-body">
            <p>Loading....</p>
      </div>
      <div class="modal-footer">
            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
            <!-- <button class="btn btn-primary">Save changes</button> -->
      </div>
</div>



<style media="screen">
      .tblForm tr th {
            text-align:left;
            padding-bottom:10px;
      }
      .tblForm tr td {
            padding-left:20px;
            padding-bottom:30px;
      }
</style>

<!-- Header. -->
<ul class="breadcrumb">
      <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
      <li><a href="desease_watch">การเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</a> <span class="divider">/</span></li>
      <li class="active">แบบฟอร์มเพิ่มข้อมูล</li>
</ul>


<h4>ระบบรายงานการเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</h4>
<div style="text-align:center;">
      <div href="#nurseries_list" role='button' id='btnCallNurseriesList' class='btn btn-primary' disabled="disabled">ค้นหา</div>
</div>

<form action='desease_watch/save' method='post'>
      <table class='tblForm'>
            <tr><th> 1. รายชื่อศูนย์เด็กเล็กและโรงเรียนอนุบาล </th></tr>
            <tr>
                  <td>
                        <input type="hidden" name="nurseries_id" value="">
                        <div>
                              <input type="text" id='nurseryCode' disabled="disabled" style='width:85px;' value="" placeholder="หมายเลขศูนย์">
                              <input type="text" id="nurseryName" disabled="disabled" value="" placeholder="ชื่อศูนย์เด็กเล็ก">
                        </div>
                              
                        <div style='margin-top:10px;'>
                              <input type="text" id='nurseryProvince' disabled="disabled" style='width:150px;' value="" placeholder="จังหวัด">
                              <input type="text" id='nurseryAmphur' disabled="disabled" style='width:150px;' value="" placeholder="อำเภอ">
                              <input type="text" id='nurseryDistrict' disabled="disabled" style='width:150px;' value="" placeholder="ตำบล">
                        </div>
                  </td>
            </tr>
            
            
            <tr><th> 2. วัน/เดือน/ปี ที่บันทึก </th></tr>
            <tr>
                  <td><?php echo mysql_to_th(date('Y-m-d')); ?></td>
            </tr>
            
            
            <tr><th> 3. เด็กป่วยโรค </th></tr>
            <tr>
                  <td> <?php echo form_dropdown('disease', array(''=>'--กรุณาเลือกโรค--', 1 => 'โรค มือ เท้า ปาก', 2 => 'โรคอีสุกอีใส', 3 => 'โรคไข้หวัด/ไข้หวัดใหญ่', 4 => 'โรคอุจจาระร่วง')); ?> </td>
            </tr>
            
            
            <tr><th> 4. วันที่เริ่มมีเด็กป่วย ระยะแรก </th> </tr>
            <tr>
                  <td>
                        วันที่เริ่ม <input type="text" name="start_date" class='datepicker' value="">
                        วันที่สิ้นสุด <input type="text" name="end_date" class='datepicker' value="">
                  </td>
            </tr>
            
            
            <tr><th> 5. รวมจำนวนเด็กป่วย </th></tr>
            <tr>
                  <td>
                        จำนวนเด็กป่วย <input type="text" style='width:40px;' name="total_amount" value=""> คน 
                        ชาย  <input type="text" style='width:40px;' name="boy_amount" value=""> คน 
                        หญิง  <input type="text" style='width:40px;' name="girl_amount" value=""> คน 
                  </td>
            </tr>
            
            
            <tr><th> 6. อายุระหว่าง </th></tr>
            <tr>
                  <td> 
                        <input type="text" style='width:35px;' name="age_duration_start" maxlength="2"> ปี - 
                        <input type="text" style='width:35px;' name="age_duration_end" maxlength="2"> ปี
                  </td>
            </tr>
            
            
            <tr><th> 7. มาตรการที่ได้ดำเนินการป้องกันควบคุมโรคในศูนย์เด็กเล็กและโรงเรียนอนุบาล สามารถเลือกได้มากกว่า 1 ข้อ </th></tr>
            <tr>
                  <td>
                        <div style='font-weight:bold;'>7.1 การคัดกรองเด็ก</div>
                        <ul>
                              <li><input type='checkbox' name='measure_filter_1'> คัดกรองเด็กป่วยทุกวัน</li>
                              <li><input type='checkbox' name='measure_filter_2'> แยกเด็กป่วย (เน้นให้ผู้ปกครองนำเด็กกลับบ้าน)</li>
                        </ul>
                        
                        <div style='font-weight:bold;'>7.2 การทำความสะอาด</div>
                        <ul>
                              <li><input type='checkbox' name='measure_clean_1'> ห้องเรียน/ห้องกิจกรรมต่าง ๆ</li>
                              <li><input type='checkbox' name='measure_clean_2'> ของเล่น/สื่อการเรียนการสอนต่าง ๆ</li>
                              <li><input type='checkbox' name='measure_clean_3'> อุปกรณ์เครื่องใช้ (แก้วน้ำ/ผ้าเช็ดมือ/ผ้าเช็ดหน้า ฯลฯ)</li>
                              <li><input type='checkbox' name='measure_clean_4'> อุปกรณ์เครื่องนอน (หมอน/ผ้าหุ่ม/ที่นอน)</li>
                              <li><input type='checkbox' name='measure_clean_5'> ห้องครัว/ห้องรับประทานอาหาร</li>
                              <li><input type='checkbox' name='measure_clean_6'> ห้องน้ำ/ห้องส้วม</li>
                        </ul>
                  </td>
            </tr>
      </table>
      <div style='text-align:center;'>
            <button type="submit" class='btn btn-primary'>บันทึกข้อมูล</button> 
            <a href="desease_watch" class="btn btn-danger">ย้อนกลับ</a>
      </div>
</form>