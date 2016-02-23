<div style='padding-left:20px;'>
		<div>
			<div>ระบุชื่อโรค <input type="text" name="other_desease" value="<?php echo @$rs->other_desease;?>" required="required"></div>
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
              <?php echo form_checkbox('qCbox_3_1', 1, @$q['qCbox_3_1'], 'class="questionRequire"') . ' จาม'; ?>
              <?php echo form_checkbox('qCbox_3_2', 1, @$q['qCbox_3_2'], 'class="questionRequire"') . ' คัดจมูก'; ?>
              <?php echo form_checkbox('qCbox_3_3', 1, @$q['qCbox_3_3'], 'class="questionRequire"') . ' น้ำมูกไหล'; ?>
              <?php echo form_checkbox('qCbox_3_4', 1, @$q['qCbox_3_4'], 'class="questionRequire"') . ' เจ็บคอ'; ?>
              <?php echo form_checkbox('qCbox_3_5', 1, @$q['qCbox_3_5'], 'class="questionRequire"') . ' เจ็บปาก'; ?>
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
              <?php echo form_checkbox('qCbox_5_1', 1, @$q['qCbox_5_1'], 'class="questionRequire"') . ' หายใจเร็ว'; ?>
              <?php echo form_checkbox('qCbox_5_2', 1, @$q['qCbox_5_2'], 'class="questionRequire"') . ' หายใจมีเสียงวี๊ด'; ?>
              <?php echo form_checkbox('qCbox_5_3', 1, @$q['qCbox_5_3'], 'class="questionRequire"') . ' หอบ'; ?>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_6_1', 1, @$q['qCbox_6_1'], 'class="questionRequire"') . ' หายใจลำบาก'; ?>
              <?php echo form_checkbox('qCbox_6_2', 1, @$q['qCbox_6_2'], 'class="questionRequire"') . ' หายใจทางปาก'; ?>
              <?php echo form_checkbox('qCbox_6_3', 1, @$q['qCbox_6_3'], 'class="questionRequire"') . ' ซี่โครงบุ๋ม'; ?>
              <?php echo form_checkbox('qCbox_6_4', 1, @$q['qCbox_6_4'], 'class="questionRequire"') . ' ตัวเขียว'; ?>
        </div>

        <div>
              <?php echo form_checkbox('qCbox_7_1', 1, @$q['qCbox_7_1'], 'class="questionRequire"') . ' คลื่นไส้'; ?>
              <?php echo form_checkbox('qCbox_7_2', 1, @$q['qCbox_7_2'], 'class="questionRequire"') . ' อาเจียน'; ?>
              <?php echo form_checkbox('qCbox_7_3', 1, @$q['qCbox_7_3'], 'class="questionRequire"') . ' เบื่ออาหาร'; ?>
              <?php echo form_checkbox('qCbox_7_4', 1, @$q['qCbox_7_4'], 'class="questionRequire"') . ' ไม่ดูดนม/น้ำ'; ?>
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
              <?php echo form_checkbox('qCbox_9_1', 1, @$q['qCbox_9_1'], 'class="questionRequire"') . ' ปวดศรีษะ'; ?>
              <?php echo form_checkbox('qCbox_9_2', 1, @$q['qCbox_9_2'], 'class="questionRequire"') . ' ปวดกล้ามเนื้อ'; ?>
              <?php echo form_checkbox('qCbox_9_3', 1, @$q['qCbox_9_3'], 'class="questionRequire"') . ' ปวดตา'; ?>
              <?php echo form_checkbox('qCbox_9_4', 1, @$q['qCbox_9_4'], 'class="questionRequire"') . ' ปวดหน้าผาก/จมูก'; ?>
              <?php echo form_checkbox('qCbox_9_5', 1, @$q['qCbox_9_5'], 'class="questionRequire"') . ' ปวดหู'; ?>
        </div>

        <div>
              <div><?php echo form_checkbox('qCbox_10_2', 1, @$q['qCbox_10_2'], 'class="questionParent"') . ' ผื่น/ตุ่ม /แผล'; ?></div>
              <div class='questionChild'>
                    <div>
                          <div>ลักษณะที่พบ</div>
                          <?php echo form_radio('qRdo_10_1', 3, @$q['qRdo_10_1']); ?> ตุ่มแดง
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
              <?php echo form_checkbox('qCbox_11_1', 1, @$q['qCbox_11_1'], 'class="questionRequire"') . ' ซึม'; ?>
              <?php echo form_checkbox('qCbox_11_2', 2, @$q['qCbox_11_2'], 'class="questionRequire"') . ' ตาเหม่อ/ลอย'; ?>
              <?php echo form_checkbox('qCbox_11_3', 3, @$q['qCbox_11_3'], 'class="questionRequire"') . ' กระสับกระส่าย'; ?>
              <?php echo form_checkbox('qCbox_11_4', 4, @$q['qCbox_11_4'], 'class="questionRequire"') . ' ชัก/เกร็ง'; ?>
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
/*
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
    */
</script>
