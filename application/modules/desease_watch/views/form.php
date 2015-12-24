<!-- Css -->
<style media="screen">
	.tblForm tr th {
		text-align: left;
		padding-bottom: 10px;
	}
	.tblForm tr td {
		padding-left: 20px;
		padding-bottom: 30px;
	}

	/*Modal*/
	.modal {
		width: 80%;
		margin-left: -40%;
	}
	.modal-body {
		height: 100vh;
		overflow-y: auto;
	}

	/*question css*/
	.question {
		display: none;
	}
	.question input[type=checkbox] {
		disabled: disabled;
	}
	.questionChild {
		display: none;
		color: #f00;
		padding-left: 20px;
	}

	.questionParent {
		border: solid 1px #0f0;
	}
	.datepicker {
		width: 100px;
	}
</style>
<!-- load jQuery 1.4.2 -->
<script type="text/javascript" src="media/js/jquery-1.4.2.min.js"></script>

<link rel="stylesheet" href="media/js/date_input/date_input.css" type="text/css" media="screen">
<script type="text/javascript" src="media/js/date_input/jquery.date_input.min.js"></script>
<script type="text/javascript" src="media/js/date_input/jquery.date_input.th_TH.js"></script>
<script type="text/javascript">
	var jQuery_1_4_2 = $.noConflict(true);
	$(document).ready(function() {
		jQuery_1_4_2("input.datepicker").date_input();
	}); 
</script>


<!-- Navigator. -->
<ul class="breadcrumb">
      <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
      <li><a href="desease_watch">การเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</a> <span class="divider">/</span></li>
      <li class="active">แบบฟอร์ม<?php echo(empty($rs -> id)) ? 'เพิ่ม' : 'แก้ไข'; ?>ข้อมูล</li>
</ul>


<!-- Header -->
<h4>ระบบรายงานการเฝ้าระวังโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล</h4>

<!-- Content -->
<form id="desease_watch" action='desease_watch/save' method='post'>
      <?php echo form_hidden('id', @$rs -> id); ?>
      <table class='tblForm table table-bordered'>
            <tr><th> 1. รายชื่อศูนย์เด็กเล็กและโรงเรียนอนุบาล </th></tr>
            <tr>
                  <td>
                        <input type="hidden" name="nurseries_id" value="<?php echo(empty($rs -> nurseries_id)) ? null : $rs -> nurseries_id; ?>">
                        <div>
                              <input type="text" id='nurseryCode' disabled="disabled" style='width:85px;' value="<?php echo @$rs -> nursery -> code; ?>" placeholder="หมายเลขศูนย์">
                              <input type="text" id="nurseryName" disabled="disabled" value="<?php echo @$rs -> nursery -> name; ?>" placeholder="ชื่อศูนย์เด็กเล็ก">
                              <div href="#nurseries_list" role='button' id='btnCallNurseriesList' class='btn btn-primary' disabled="disabled">ค้นหา</div>
                        </div>

                        <div style='margin-top:10px;'>
                              <input type="text" id='nurseryProvince' disabled="disabled" style='width:150px;' value="<?php echo @$rs -> nursery -> province -> name; ?>" placeholder="จังหวัด">
                              <input type="text" id='nurseryAmphur' disabled="disabled" style='width:150px;' value="<?php echo @$rs -> nursery -> amphur -> amphur_name; ?>" placeholder="อำเภอ">
                              <input type="text" id='nurseryDistrict' disabled="disabled" style='width:150px;' value="<?php echo @$rs -> nursery -> district -> district_name; ?>" placeholder="ตำบล">
                        </div>
                        
                        
                        <div class="errorPlace_nurseries_id"></div>
                  </td>
            </tr>


            <tr><th> 2. วัน/เดือน/ปี ที่บันทึก </th></tr>
            <tr> <td><?php echo mysql_to_th((empty($rs -> id)) ? date('Y-m-d') : $rs -> created_date); ?></td> </tr>


            <tr><th> 3. เด็กป่วยโรค </th></tr>
            <tr>
                  <td>
                        <?php
                        //$qList = array(''=>'--กรุณาเลือกโรค--', 1 => 'โรค มือ เท้า ปาก', 2 => 'โรคอีสุกอีใส', 3 => 'โรคไข้หวัด/ไข้หวัดใหญ่', 4 => 'โรคอุจจาระร่วง');
                        echo form_dropdown('disease', get_option('id', 'desease_name', 'desease_watch_names', ' order by id '), @$rs -> disease, '', '--กรุณาเลือกโรค--');
                        //echo form_dropdown('disease', $qList, @$rs->disease);
                        ?>

                        <div class="question" style='line-height:25px;'>
                              
                              <div class="">
                                    <span id="questionHeader" style='margin-top:10px; font-weight:bold;'></span>
                                    <span class='errorPlace_questionParent'></span>
                              </div>
                              <div id="questionChoiceArea">
                                    <?php 
                                    if(@$rs->disease!=4 && @$rs->id>0){
                                    ?>
                                    <div style='padding-left:20px;'>
        <div>
              <div><?php echo form_checkbox('qCbox_1', 1, @$q['qCbox_1'], 'class="questionParent"') . ' ไข้'; ?></div>
              <div class="questionChild">
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_1', 1, @$q['qRdo_1']); ?> ไข้ต่ำๆ (<u><</u> 38.5 องศาเซลเซียส)
                    <?php echo form_radio('qRdo_1', 2, @$q['qRdo_1']); ?> ไข้สูง (> 38.5 องศาเซลเซียส)
              </div>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_2', 1, @$q['qCbox_2'], 'class="questionParent"') . ' ไอ'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_2', 1, @$q['qRdo_2']); ?> ไอห่าง ๆ
                    <?php echo form_radio('qRdo_2', 2, @$q['qRdo_2']); ?> ไอติด ๆ - เป็นชุด ๆ
                    <?php echo form_radio('qRdo_2', 3, @$q['qRdo_2']); ?> เสียงก้อง
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_3_1', 1, @$q['qCbox_3_1']) . ' จาม'; ?>
              <?php echo form_checkbox('qCbox_3_2', 1, @$q['qCbox_3_2']) . ' คัดจมูก'; ?>
              <?php echo form_checkbox('qCbox_3_3', 1, @$q['qCbox_3_3']) . ' น้ำมูกไหล'; ?>
              <?php echo form_checkbox('qCbox_3_4', 1, @$q['qCbox_3_4']) . ' เจ็บคอ'; ?>
              <?php echo form_checkbox('qCbox_3_5', 1, @$q['qCbox_3_5']) . ' เจ็บปาก'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_4', 1, @$q['qCbox_4'], 'class="questionParent"') . ' เสมหะขาว'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_4', 1, @$q['qRdo_4']); ?> ขาวขุ่น
                    <?php echo form_radio('qRdo_4', 2, @$q['qRdo_4']); ?> เหลือง
                    <?php echo form_radio('qRdo_4', 3, @$q['qRdo_4']); ?> เลือดปน
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_5_1', 1, @$q['qCbox_5_1']) . ' หายใจเร็ว'; ?>
              <?php echo form_checkbox('qCbox_5_2', 1, @$q['qCbox_5_2']) . ' หายใจมีเสียงวี๊ด'; ?>
              <?php echo form_checkbox('qCbox_5_3', 1, @$q['qCbox_5_3']) . ' หอบ'; ?>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_6_1', 1, @$q['qCbox_6_1']) . ' หายใจลำบาก'; ?>
              <?php echo form_checkbox('qCbox_6_2', 1, @$q['qCbox_6_2']) . ' หายใจทางปาก'; ?>
              <?php echo form_checkbox('qCbox_6_3', 1, @$q['qCbox_6_3']) . ' ซี่โครงบุ๋ม'; ?>
              <?php echo form_checkbox('qCbox_6_4', 1, @$q['qCbox_6_4']) . ' ตัวเขียว'; ?>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_7_1', 1, @$q['qCbox_7_1']) . ' คลื่นไส้'; ?>
              <?php echo form_checkbox('qCbox_7_2', 1, @$q['qCbox_7_2']) . ' อาเจียน'; ?>
              <?php echo form_checkbox('qCbox_7_3', 1, @$q['qCbox_7_3']) . ' เบื่ออาหาร'; ?>
              <?php echo form_checkbox('qCbox_7_4', 1, @$q['qCbox_7_4']) . ' ไม่ดูดนม/น้ำ'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_8', 1, @$q['qCbox_8'], 'class="questionParent"') . ' ท้องเสีย'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_8', 1, @$q['qRdo_8']); ?> ถ่ายเหลว (> 3 ครั้ง/วัน)
                    <?php echo form_radio('qRdo_8', 2, @$q['qRdo_8']); ?> ถ่ายเป็นน้ำปริมาณมาก
                    <?php echo form_radio('qRdo_8', 3, @$q['qRdo_8']); ?> ถ่ายเป็นมูก/เลือด
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_9_1', 1, @$q['qCbox_9_1']) . ' ปวดศรีษะ'; ?>
              <?php echo form_checkbox('qCbox_9_2', 1, @$q['qCbox_9_2']) . ' ปวดกล้ามเนื้อ'; ?>
              <?php echo form_checkbox('qCbox_9_3', 1, @$q['qCbox_9_3']) . ' ปวดตา'; ?>
              <?php echo form_checkbox('qCbox_9_4', 1, @$q['qCbox_9_4']) . ' ปวดหน้าผาก/จมูก'; ?>
              <?php echo form_checkbox('qCbox_9_5', 1, @$q['qCbox_9_5']) . ' ปวดหู'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_10_1', 1, @$q['qCbox_10_1'], 'class="questionParent"') . ' แผล หรือ ' . form_checkbox('qCbox_10_2', 1, @$q['qCbox_10_2'], 'class="questionParent"') . ' ผื่น/ตุ่มแดง'; ?></div>
              <div class='questionChild'>
                    <div>
                          <div>ลักษณะที่พบ</div>
                          <?php echo form_radio('qRdo_10_1', 1, @$q['qRdo_10_1']); ?> ตุ่มน้ำใส
                          <?php echo form_radio('qRdo_10_1', 2, @$q['qRdo_10_1']); ?> ตุ่มน้ำขุ่น/เป็นหนอง
                    </div>
                    <div>
                          <div>บริเวณที่พบ</div>
                          <?php echo form_radio('qRdo_10_2', 1, @$q['qRdo_10_2']); ?> กระพุ้งแก้ม
                          <?php echo form_radio('qRdo_10_2', 2, @$q['qRdo_10_2']); ?> เพดาน
                          <?php echo form_radio('qRdo_10_2', 3, @$q['qRdo_10_2']); ?> เหงือก
                          <?php echo form_radio('qRdo_10_2', 4, @$q['qRdo_10_2']); ?> ลิ้น
                          <?php echo form_radio('qRdo_10_2', 5, @$q['qRdo_10_2']); ?> มุมปาก
                          <?php echo form_radio('qRdo_10_2', 6, @$q['qRdo_10_2']); ?> ริมฝีปาก
                          <?php echo form_radio('qRdo_10_2', 7, @$q['qRdo_10_2']); ?> ฝ่ามือ
                          <?php echo form_radio('qRdo_10_2', 8, @$q['qRdo_10_2']); ?> ฝ่าเท้า
                          <?php echo form_radio('qRdo_10_2', 9, @$q['qRdo_10_2']); ?> นิ้วมือ
                          <?php echo form_radio('qRdo_10_2', 10, @$q['qRdo_10_2']); ?> หัวเข่า
                          <?php echo form_radio('qRdo_10_2', 11, @$q['qRdo_10_2']); ?> ข้อศอก
                          <?php echo form_radio('qRdo_10_2', 12, @$q['qRdo_10_2']); ?> ลำตัว
                          <?php echo form_radio('qRdo_10_2', 13, @$q['qRdo_10_2']); ?> แขน
                          <?php echo form_radio('qRdo_10_2', 14, @$q['qRdo_10_2']); ?> ขา
                    </div>
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_11_1', 1, @$q['qCbox_11_1']) . ' ซึม'; ?>
              <?php echo form_checkbox('qCbox_11_2', 2, @$q['qCbox_11_2']) . ' ตาเหม่อ/ลอย'; ?>
              <?php echo form_checkbox('qCbox_11_3', 3, @$q['qCbox_11_3']) . ' กระสับกระส่าย'; ?>
              <?php echo form_checkbox('qCbox_11_4', 4, @$q['qCbox_11_4']) . ' ชัก/เกร็ง'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_12', 1, @$q['qCbox_12'], 'class="questionParent"') . ' กล้ามเนื้ออ่อนแรง/อัมพาต'; ?></div>
              <div class='questionChild'>
                    บริเวณที่พบ
                    <?php echo form_radio('qRdo_11', 1, @$q['qRdo_11']); ?> แขนและขาทั้ง 2 ข้าง
                    <?php echo form_radio('qRdo_11', 2, @$q['qRdo_11']); ?> แขนทั้ง 2 ข้าง
                    <?php echo form_radio('qRdo_11', 3, @$q['qRdo_11']); ?> ขาทั้ง 2 ข้าง
                    <?php echo form_radio('qRdo_11', 4, @$q['qRdo_11']); ?> แขนซ้าย
                    <?php echo form_radio('qRdo_11', 5, @$q['qRdo_11']); ?> แขนขวา
                    <?php echo form_radio('qRdo_11', 6, @$q['qRdo_11']); ?> ซีกซ้าย
                    <?php echo form_radio('qRdo_11', 7, @$q['qRdo_11']); ?> ซีกขวา
              </div>
        </div>
</div>
                                    <?php
                                    }else if(@$rs->disease==4 && @$rs->id>0){
                                    ?>
<div style='padding-left:20px;'>
        <div>
              <div><?php echo form_checkbox('qCbox_8', 1, @$q['qCbox_8'], 'class="questionParent"') . ' ท้องเสีย'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_8', 1, @$q['qRdo_8']); ?> ถ่ายเหลว (> 3 ครั้ง/วัน)
                    <?php echo form_radio('qRdo_8', 2, @$q['qRdo_8']); ?> ถ่ายเป็นน้ำปริมาณมาก
                    <?php echo form_radio('qRdo_8', 3, @$q['qRdo_8']); ?> ถ่ายเป็นมูก/เลือด
                    
                    <div>ลักษณะอุจจาระ</div>
                    <?php echo form_radio('qRdo_8_1', 1, @$q['qRdo_8_1']); ?> มีสีเหลือง
                    <?php echo form_radio('qRdo_8_1', 2, @$q['qRdo_8_1']); ?> ขาว
                    <?php echo form_radio('qRdo_8_1', 3, @$q['qRdo_8_1']); ?> มูกเลือด
                    <?php echo form_radio('qRdo_8_1', 3, @$q['qRdo_8_1']); ?> ดำ
                    
                    <div>ลักษณะกลิ่นอุจจาระ</div>
                    <?php echo form_radio('qRdo_8_2', 1, @$q['qRdo_8_2']); ?> ไม่มีกลิ่นเหม็น
                    <?php echo form_radio('qRdo_8_2', 2, @$q['qRdo_8_2']); ?> เหม็นเปรี้ยว
                    <?php echo form_radio('qRdo_8_2', 3, @$q['qRdo_8_2']); ?> เหม็นคาว
                    <?php echo form_radio('qRdo_8_2', 3, @$q['qRdo_8_2']); ?> เหม็นเน่า
              </div>
        </div>        

        <div>
              <?php echo form_checkbox('qCbox_7_1', 1, @$q['qCbox_7_1']) . ' คลื่นไส้'; ?>
              <?php echo form_checkbox('qCbox_7_2', 1, @$q['qCbox_7_2']) . ' อาเจียน'; ?>
              <?php echo form_checkbox('qCbox_7_3', 1, @$q['qCbox_7_3']) . ' เบื่ออาหาร'; ?>
              <?php echo form_checkbox('qCbox_7_4', 1, @$q['qCbox_7_4']) . ' ไม่ดูดนม/น้ำ'; ?>
        </div>   
        
        <div>
              <?php echo form_checkbox('qCbox_7_5', 1, @$q['qCbox_7_5']) . ' กระหายน้ำ'; ?>
              <?php echo form_checkbox('qCbox_7_6', 1, @$q['qCbox_7_6']) . ' ปากแห้ง'; ?>
              <?php echo form_checkbox('qCbox_7_7', 1, @$q['qCbox_7_7']) . ' ผิวหนังเหี่ยว/ย่น'; ?>
              <?php echo form_checkbox('qCbox_7_8', 1, @$q['qCbox_7_8']) . ' ตาโหล่'; ?>
              <?php echo form_checkbox('qCbox_7_9', 1, @$q['qCbox_7_9']) . ' กระหม่อมบุ๋ม'; ?>
        </div>  
        
        <div>
              <?php echo form_checkbox('qCbox_9_6', 1, @$q['qCbox_9_6']) . ' ปวดท้อง'; ?>
              <?php echo form_checkbox('qCbox_9_1', 1, @$q['qCbox_9_1']) . ' ปวดศรีษะ'; ?>
              <?php echo form_checkbox('qCbox_9_2', 1, @$q['qCbox_9_2']) . ' ปวดกล้ามเนื้อ'; ?>
              <?php echo form_checkbox('qCbox_9_3', 1, @$q['qCbox_9_3']) . ' ปวดตา'; ?>
              <?php echo form_checkbox('qCbox_9_4', 1, @$q['qCbox_9_4']) . ' ปวดหน้าผาก/จมูก'; ?>
              <?php echo form_checkbox('qCbox_9_5', 1, @$q['qCbox_9_5']) . ' ปวดหู'; ?>
        </div>
        
        <div>
              <?php echo form_checkbox('qCbox_11_1', 1, @$q['qCbox_11_1']) . ' ซึม'; ?>
              <?php echo form_checkbox('qCbox_11_2', 2, @$q['qCbox_11_2']) . ' ตาเหม่อ/ลอย'; ?>
              <?php echo form_checkbox('qCbox_11_3', 3, @$q['qCbox_11_3']) . ' กระสับกระส่าย'; ?>
              <?php echo form_checkbox('qCbox_11_4', 4, @$q['qCbox_11_4']) . ' ชัก/เกร็ง'; ?>
        </div>
    
        <div>
              <div><?php echo form_checkbox('qCbox_1', 1, @$q['qCbox_1'], 'class="questionParent"') . ' ไข้'; ?></div>
              <div class="questionChild">
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_1', 1, @$q['qRdo_1']); ?> ไข้ต่ำๆ (<u><</u> 38.5 องศาเซลเซียส)
                    <?php echo form_radio('qRdo_1', 2, @$q['qRdo_1']); ?> ไข้สูง (> 38.5 องศาเซลเซียส)
              </div>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_2', 1, @$q['qCbox_2'], 'class="questionParent"') . ' ไอ'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_2', 1, @$q['qRdo_2']); ?> ไอห่าง ๆ
                    <?php echo form_radio('qRdo_2', 2, @$q['qRdo_2']); ?> ไอติด ๆ - เป็นชุด ๆ
                    <?php echo form_radio('qRdo_2', 3, @$q['qRdo_2']); ?> เสียงก้อง
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_3_1', 1, @$q['qCbox_3_1']) . ' จาม'; ?>
              <?php echo form_checkbox('qCbox_3_2', 1, @$q['qCbox_3_2']) . ' คัดจมูก'; ?>
              <?php echo form_checkbox('qCbox_3_3', 1, @$q['qCbox_3_3']) . ' น้ำมูกไหล'; ?>
              <?php echo form_checkbox('qCbox_3_4', 1, @$q['qCbox_3_4']) . ' เจ็บคอ'; ?>
              <?php echo form_checkbox('qCbox_3_5', 1, @$q['qCbox_3_5']) . ' เจ็บปาก'; ?>
              <?php echo form_checkbox('qCbox_3_6', 1, @$q['qCbox_3_6']) . ' น้ำลายไหล'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_4', 1, @$q['qCbox_4'], 'class="questionParent"') . ' เสมหะขาว'; ?></div>
              <div class='questionChild'>
                    <div>ลักษณะที่พบ</div>
                    <?php echo form_radio('qRdo_4', 1, @$q['qRdo_4']); ?> ขาวขุ่น
                    <?php echo form_radio('qRdo_4', 2, @$q['qRdo_4']); ?> เหลือง
                    <?php echo form_radio('qRdo_4', 3, @$q['qRdo_4']); ?> เลือดปน
              </div>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_5_1', 1, @$q['qCbox_5_1']) . ' หายใจเร็ว'; ?>
              <?php echo form_checkbox('qCbox_5_2', 1, @$q['qCbox_5_2']) . ' หายใจมีเสียงวี๊ด'; ?>
              <?php echo form_checkbox('qCbox_5_3', 1, @$q['qCbox_5_3']) . ' หอบ'; ?>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_6_1', 1, @$q['qCbox_6_1']) . ' หายใจลำบาก'; ?>
              <?php echo form_checkbox('qCbox_6_2', 1, @$q['qCbox_6_2']) . ' หายใจทางปาก'; ?>
              <?php echo form_checkbox('qCbox_6_3', 1, @$q['qCbox_6_3']) . ' ซี่โครงบุ๋ม'; ?>
              <?php echo form_checkbox('qCbox_6_4', 1, @$q['qCbox_6_4']) . ' ตัวเขียว'; ?>
        </div>
       
</div>                                    
                                    <?
                                    }
                                    ?>
                              </div>
                              
                        </div>

                  </td>
            </tr>


            <tr><th> 4. วันที่เริ่มมีเด็กป่วย ระยะแรก </th> </tr>
            <tr>
                  <td>
                        วันที่เริ่ม <input type="text" name="start_date" class='datepicker' value="<?php echo(@!strtotime($rs -> start_date)) ? null : DB2Date($rs -> start_date, false); ?>">
                        วันที่สิ้นสุด <input type="text" name="end_date" class='datepicker' value="<?php echo(@!strtotime($rs -> end_date)) ? null : DB2Date($rs -> end_date, false); ?>">
                        <div class="errorPlace_duration_date"></div>
                  </td>
            </tr>


            <tr><th> 5. รวมจำนวนเด็กป่วย </th></tr>
            <tr>
                  <td>
                                                                        จำนวนเด็กป่วย 
                                                                        ชาย  <input type="text" class="number" style="width:40px;text-align:right;" name="boy_amount" value="<?php echo(empty($rs -> boy_amount)) ? null : $rs -> boy_amount; ?>"> คน
                                                                        หญิง  <input type="text" class="number" style='width:40px;text-align:right;' name="girl_amount" value="<?php echo(empty($rs -> girl_amount)) ? null : $rs -> girl_amount; ?>"> คน
                                                                        รวม <input type="text" readonly="readonly" style='width:40px;text-align:right;' name="total_amount" value="<?php echo(empty($rs -> total_amount)) ? null : $rs -> total_amount; ?>"> คน                        
                        <div class="errorPlace_amount"></div>
                  </td>
            </tr>


            <tr><th> 6. อายุระหว่าง </th></tr>
            <tr>
                  <td>
                        <input type="text" class="number" style="text-align:center;width:25px;" name="age_duration_start" value='<?php echo(empty($rs -> age_duration_start)) ? null : $rs -> age_duration_start; ?>'  maxlength="2"> 
                                                                        ปี
                        <input type="text" class="number" style="text-align:center;width:25px;" name="age_month_duration_start" value='<?php echo(empty($rs -> age_month_duration_start)) ? null : $rs -> age_month_duration_start; ?>'  maxlength="2"> 
                                                                        เดือน
                                                                          ถึง
                        <input type="text" class="number" style="text-align:center;width:25px;" name="age_duration_end" value='<?php echo(empty($rs -> age_duration_end)) ? null : $rs -> age_duration_end; ?>' maxlength="2"> 
                                                                        ปี
                        <input type="text" class="number" style="text-align:center;width:25px;" name="age_month_duration_start" value='<?php echo(empty($rs -> age_month_duration_end)) ? null : $rs -> age_month_duration_end; ?>'  maxlength="2"> 
                                                                        เดือน                                                                        
                        <div class="errorPlace_ageDuration"></div>
                  </td>
            </tr>


            <tr><th> 7. มาตรการที่ได้ดำเนินการป้องกันควบคุมโรคในศูนย์เด็กเล็กและโรงเรียนอนุบาล (สามารถเลือกได้มากกว่า 1 ข้อ) </th></tr>
            <tr>
                  <td>
                        <div style='font-weight:bold;'>7.1 การคัดกรองเด็ก <span class='errorPlace_measureFilter'></span></div>
                        <ul>
                              <li><?php echo form_checkbox('measure_filter_1', 1, @$rs -> measure_filter_1, 'class="measure_filter"'); ?> คัดกรองเด็กป่วยทุกวัน</li>
                              <li><?php echo form_checkbox('measure_filter_2', 1, @$rs -> measure_filter_2, 'class="measure_filter"'); ?> แยกเด็กป่วย (เน้นให้ผู้ปกครองนำเด็กกลับบ้าน)</li>
                        </ul>

                        <div style='font-weight:bold;'>7.2 การทำความสะอาด <span class='errorPlace_measureClean'></span></div>
                        <ul>
                              <li><?php echo form_checkbox('measure_clean_1', 1, @$rs -> measure_clean_1, 'class="measure_clean"'); ?> ห้องเรียน/ห้องกิจกรรมต่าง ๆ</li>
                              <li><?php echo form_checkbox('measure_clean_2', 1, @$rs -> measure_clean_2, 'class="measure_clean"'); ?> ของเล่น/สื่อการเรียนการสอนต่าง ๆ</li>
                              <li><?php echo form_checkbox('measure_clean_3', 1, @$rs -> measure_clean_3, 'class="measure_clean"'); ?> อุปกรณ์เครื่องใช้ (แก้วน้ำ/ผ้าเช็ดมือ/ผ้าเช็ดหน้า ฯลฯ)</li>
                              <li><?php echo form_checkbox('measure_clean_4', 1, @$rs -> measure_clean_4, 'class="measure_clean"'); ?> อุปกรณ์เครื่องนอน (หมอน/ผ้าหุ่ม/ที่นอน)</li>
                              <li><?php echo form_checkbox('measure_clean_5', 1, @$rs -> measure_clean_5, 'class="measure_clean"'); ?> ห้องครัว/ห้องรับประทานอาหาร</li>
                              <li><?php echo form_checkbox('measure_clean_6', 1, @$rs -> measure_clean_6, 'class="measure_clean"'); ?> ห้องน้ำ/ห้องส้วม</li>
                        </ul>
                        <div style='font-weight:bold;'>7.3 ผู้มีส่วนเกี่ยวข้อง <span class='errorPlace_measurePerson'></span></div>
                        <ul>
                              <li><?php echo form_checkbox('measure_person_1', 1, @$rs -> measure_person_1, 'class="measure_person"'); ?> เจ้าหน้าที่สาธารณสุข</li>
                              <li><?php echo form_checkbox('measure_person_2', 1, @$rs -> measure_person_2, 'class="measure_person"'); ?> นายก อบต./เทศมนตรี</li>
                              <li><?php echo form_checkbox('measure_person_3', 1, @$rs -> measure_person_3, 'class="measure_person"'); ?> ผู้ปกครอง</li>
                              <li>
                                  <?php echo form_checkbox('measure_person_4', 1, @$rs -> measure_person_4, 'class="measure_person"'); ?> อื่น ๆ
                                  <input type="text" name="measure_person_4_desc" value="<?php echo @$rs->measure_person_4_desc;?>"> 
                              </li>
                        </ul>
                  </td>
            </tr>            
      </table>
      <div style='text-align:center;'>
            <button type="submit" class='btn btn-primary'>บันทึกข้อมูล</button>
            <a href="desease_watch" class="btn btn-danger">ย้อนกลับ</a>
      </div>
</form>


<!-- Modal -->
<div id="nurseries_list" class="modal hide fade" tabindex="-1" role="dialog" aria-hidden="true" style='height:auto;'>
      <div class="modal-dialog modal-lg">
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
            
</div>




<!-- Script -->
<script src="media/js/jquery-ui-1.7.3.custom.min.js"></script>
<script type="text/javascript">
	$(function() {
		//Modal (Nurseries_list)
		$('#btnCallNurseriesList').on('click', function() {
			$.get('desease_watch/nurseries_list', function(data) {
				$('#nurseries_list').find('div.modal-body').html(data);
			});
		});
		$('#btnNurserySubmitSearch').live('click', function() {
			name = $('#nurseries_list').find('div.modal-body').find('[name=name]').val();
			province_id = $('#nurseries_list').find('div.modal-body').find('[name=province_id] option:selected').val();
			amphur_id = $('#nurseries_list').find('div.modal-body').find('[name=amphur_id] option:selected').val();
			district_id = $('#nurseries_list').find('div.modal-body').find('[name=district_id] option:selected').val();

			$('#nurseries_list').find('div.modal-body').html("<div style='text-align:center; color:#aaa;'>Loading...</div>");

			$.get('desease_watch/nurseries_list', {
				name : name,
				province_id : province_id,
				amphur_id : amphur_id,
				district_id : district_id,
				search : 'search',
			}, function(data) {
				$('#nurseries_list').find('div.modal-body').html(data);
			});
		});

		$('#nurseries_list .btnSelectNursery').live('click', function() {
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

		//question script..
		question = {
			// Begin checking.
			begin : function() {
				this.checkDisplay();
				this.childDisplayBegin();
			},
			// Question
			checkDisplay : function(clearnType) {
				// Clean checkbox, radio box
				if (clearnType) {
					$('.question input[type=checkbox], .question input[type=radio]').attr('checked', false);
					$('.question, .question .questionChild').hide();
				}

				$('#questionHeader').html($('[name=disease] option:selected').text());
				if ($('[name=disease] option:selected').val() != '') {
				   $('.question').show();					
				} else {
					$('.question').hide();
				}
			},
			// Child question
			childDisplayBegin : function() {
				for ( i = 0; i < $('.questionParent').size(); i++) {
					if ($('.questionParent').eq(i).prop('checked')) {
						this.childCheckDisplay($('.questionParent').eq(i));
					}
				}
			},
			childCheckDisplay : function(obj) {
				checked = obj.prop('checked');
				if (obj.attr('name') == 'qCbox_10_1' || obj.attr('name') == 'qCbox_10_2') {
					if ($('[name=qCbox_10_1]').attr('checked') == 'checked' || $('[name=qCbox_10_2]').attr('checked') == 'checked') {
						checked = true;
					}
				}

				if (checked) {
					obj.parent().parent().find('.questionChild').show();
				} else {
					obj.parent().parent().find('.questionChild').hide();
				}
			}
		};

		question.begin();
		$('[name=disease]').on('change', function() {			
			var disease = $('[name=disease]').val();
            $.get('desease_watch/get_question_detail', {
                disease : disease,
            }, function(data) {
                $('#questionChoiceArea').html(data);
                question.checkDisplay(true);                
            });
		});
		$('.questionParent').on('change', function() {
			question.childCheckDisplay($(this));
		});

		//Validate
		$('#desease_watch').on('submit', function() {
			status = false;

			//Question ( parent )
			for ( i = 0; i < $('.questionParent').size(); i++) {
				if ($('.questionParent').eq(i).prop('checked')) {
					status = true;
				}
			}
			if (status == 'false') {
				$('.errorPlace_questionParent').html('<label for="disease" generated="true" class="error" style="display:inline-block;">กรุณาเลือกอย่างน้อยหนึ่งข้อ</label>');
			}

			if (status == 'false') {
				return false;
			}

			//measure_filter
			for ( i = 0; i < $('.measure_filter').size(); i++) {
				if ($('.measure_filter').eq(i).prop('checked')) {
					status = true;
				}
			}
			if (status == 'false') {
				$('.errorPlace_measureFilter').html('<label for="disease" generated="true" class="error" style="display:inline-block;">กรุณาเลือกอย่างน้อยหนึ่งข้อ</label>');
			}

			//measure_clean
			for ( i = 0; i < $('.measure_clean').size(); i++) {
				if ($('.measure_clean').eq(i).prop('checked')) {
					status = true;
				}
			}
			
			//measure_person
            for ( i = 0; i < $('.measure_person').size(); i++) {
                if ($('.measure_person').eq(i).prop('checked')) {
                    status = true;
                }
            }
			if (status == 'false') {
				$('.errorPlace_measureClean').html('<label for="disease" generated="true" class="error" style="display:inline-block;">กรุณาเลือกอย่างน้อยหนึ่งข้อ</label>');
			}

			//Check status
			if (status == 'false') {
				return false;
			}
		});
	});
	//$(function(){
	    
    $("input.number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
    
    $("input[name=boy_amount],input[name=girl_amount]").keyup(function(){
        var amount = 0;
        var boy_amount = $("input[name=boy_amount]").val()=='' ? 0 : parseInt($("input[name=boy_amount]").val());
        var girl_amount = $("input[name=girl_amount]").val()=='' ? 0 : parseInt($("input[name=girl_amount]").val());
        amount = boy_amount + girl_amount;
        $("input[name=total_amount]").val(amount);
    });

	errorMsgRequired = "กรุณาระบุข้อมูลก่อนดำเนินการบันทึก";
	$('#desease_watch').validate({
		rules : {
			nurseries_id : {
				required : true
			},
			disease : {
				required : true
			},
			start_date : {
				required : true
			},
			end_date : {
				required : true
			},
			total_amount : {
				required : true
			},
			boy_amount : {
				required : true
			},
			girl_amount : {
				required : true
			},
			age_duration_start : {
				required : true
			},
			age_duration_end : {
				required : true
			},
		},
		messages : {
			nurseries_id : {
				required : errorMsgRequired
			},
			disease : {
				required : errorMsgRequired
			},
			start_date : {
				required : errorMsgRequired
			},
			end_date : {
				required : errorMsgRequired
			},
			total_amount : {
				required : errorMsgRequired
			},
			boy_amount : {
				required : errorMsgRequired
			},
			girl_amount : {
				required : errorMsgRequired
			},
			age_duration_start : {
				required : errorMsgRequired
			},
			age_duration_end : {
				required : errorMsgRequired
			},
		},
		errorPlacement : function(error, element) {
			if (element.attr("name") == "nurseries_id") {
				error.insertAfter(".errorPlace_nurseries_id");
			} else if (element.attr("name") == "start_date" || element.attr("name") == "end_date") {
				$('.errorPlace_duration_date').html('<label for="disease" generated="true" class="error" style="display: block;">' + errorMsgRequired + '</label>');
			} else if (element.attr("name") == "total_amount" || element.attr("name") == "boy_amount" || element.attr("name") == "girl_amount") {
				$('.errorPlace_amount').html('<label for="disease" generated="true" class="error" style="display: block;">' + errorMsgRequired + '</label>');
			} else if (element.attr("name") == "age_duration_start" || element.attr("name") == "age_duration_end") {
				$('.errorPlace_ageDuration').html('<label for="disease" generated="true" class="error" style="display: block;">' + errorMsgRequired + '</label>');
			} else {//
				error.insertAfter(element);
			}
		}
	}); 
</script>
