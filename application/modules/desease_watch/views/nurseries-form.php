<style>
#frmnursery th{width:214px !important;}
#frmnursery th, #frmnursery th a {
    background-color: #f1f1f1 !important;
    color:#000 !important;
}
</style>
<form id="frmnursery" method="post" action="desease_watch/nurseries_save">

        <div id="data">
            <div style="font-size:14px; font-weight:700; padding-bottom:10px; color:#3C3">เพิ่มข้อมูลศูนย์เด็กเล็กปลอดโรค</div>
    <!--search-->
        <fieldset style="border:1px dashed #ccc; padding:10px; margin-bottom:10px;">
        <legend style="padding:0 5px; font-size:14px; font-weight:700; color:#666;">ข้อมูลศูนย์เด็กเล็ก</legend>
            <table class="table">
                <tr>
                    <th>สคร.<strong> <span class="TxtRed">*</span></strong></th>
                    <td>
                        <?php get_area_dropdown();?>                        
                    </td>
                </tr>
                <tr>
                    <th>ประเภท <strong> <span class="TxtRed">*</span></strong></th>
                    <td>
                        <select name="nursery_type" required="required">
                            <option value="1">ศูนย์เด็กเล็ก</option>
                            <option value="2">โรงเรียนอนุบาล</option>
                        </select>                   
                    </td>
                </tr>
                <tr>
                  <th>ชื่อศูนย์เด็กเล็ก/โรงเรียนอนุบาล<strong> <span class="TxtRed">*</span></strong></th>
                  <td><input type="text" name="name" value="" id="textfield"  style="width:350px;"/></td>
                </tr>
                 <tr>
                  <th>เลขที่<strong> <span class="TxtRed">*</span></strong></th>
                  <td><input type="text" name="number" value="" id="textfield2" style="width:50px;" /></td>
                </tr>
                 <tr>
                   <th>หมู่<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input type="text" name="moo" value="" id="textfield3" /></td>
                 </tr>
                 <tr>
                   <th>จังหวัด<strong> <span class="TxtRed">*</span></strong></th>
                   <td id="province">
                    <?php get_province_dropdown('','');?>
                    </td>
                 </tr>
                 <tr>
                   <th>อำเภอ<strong> <span class="TxtRed">*</span></strong></th>
                   <td id="amphur">
                    <?php if(user_login()->user_type_id == 7 or  user_login()->user_type_id == 8):?>
                        <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6): //เจ้าหน้าที่เขต?>
                            <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.$nursery->province_id.' order by id asc'),$nursery->amphur_id,'','--- เลือกอำเภอ ---');?>
                        <?php elseif(user_login()->user_type_id == 7): //เจ้าหน้าที่จังหวัด?>
                            <?=form_dropdown('amphur_id',get_option('id','amphur_name','amphures','where province_id = '.user_login()->province_id.' order by id asc'),$nursery->amphur_id,'','--- เลือกอำเภอ ---');?>
                        <?php elseif(user_login()->user_type_id == 8): //เจ้าหน้าที่อำเภอ?>
                            <input type="text" value="<?=user_login()->amphur->amphur_name?>" disabled>
                            <input type="hidden" name="amphur_id" value="<?=user_login()->amphur_id?>">
                        <?php endif;?></td>
                    <?php endif;?>
                 </tr>
                 <tr>
                   <th>ตำบล<strong> <span class="TxtRed">*</span></strong></th>
                   <td id="district">
                    <?php if(user_login()->user_type_id == 8):?>
                        <?php if(user_login()->user_type_id == 1 or user_login()->user_type_id == 6 or user_login()->user_type_id == 7):?>
                            <?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.$nursery->amphur_id.' order by id asc'),$nursery->district_id,'','--- เลือกตำบล ---');?>
                        <?php elseif(user_login()->user_type_id == 8):?><?=form_dropdown('district_id',get_option('id','district_name','districts','where amphur_id = '.user_login()->amphur_id.' order by id asc'),$nursery->district_id,'','--- เลือกตำบล ---');?>
                        <?php endif;?>
                    <?php endif;?>
                    </td>
                 </tr>
                 <tr>
                   <th>รหัสไปรษณีย์<strong> <span class="TxtRed">*</span></strong></th>
                   <td><input name="code" type="text" value="" id="code" size="10" /></td>
                 </tr>
                 <tr>
                    <th>สังกัด</th>
                    <td>
                        <input type="radio" name="under" value="อบต." > อบต.
                        <input type="radio" name="under" value="เทศบาล" > เทศบาล
                        <input type="radio" name="under" value="เอกชน" > เอกชน
                        <input type="radio" name="under" value="อื่นๆ" > อื่นๆ
                        <input type="input" name="under_other" value="">
                    </td>
                 </tr>
                 <tr>
                    <th>รหัสลับ <span class="TxtRed">*</span></th>
                    <td>
                        <img src="users/captcha" /><Br>
                        <input class="input-small" type="text" name="captcha" id="inputCaptcha" required="required" placeholder="รหัสลับ">
                    </td>
                 </tr>
            </table>
          </fieldset>
          <div style="margin-left:25%; padding-top:10px;"><input class="btn btn_register" type="button" value=" ลงทะเบียน " /></div>
    </div>
</form>
<script type="text/javascript">
$(document).ready(function(){    
    $("#frmnursery").find("select[name='area_id']").live("change",function(){        
        $.post('ajax/get_province',{
                'area_id' : $(this).val()
            },function(data){
                $("#frmnursery").find("#province").html(data);
            });
    });
    $("#frmnursery").find("select[name='province_id']").live("change",function(){
        $.post('ajax/get_amphur',{
                'province_id' : $(this).val()
            },function(data){
                $("#frmnursery").find("#amphur").html(data);
            });
    });

    $("#frmnursery").find("select[name='amphur_id']").live("change",function(){
        $.post('ajax/get_district',{
                'amphur_id' : $(this).val()
            },function(data){
                $("#frmnursery").find("#district").html(data);
            });
    });
    
    $("#frmnursery").validate({
        onkeyup: false,
        onclick: false,
    rules: 
    {
        name: 
        { 
            required: true
            //remote: "nurseries/check_name"
        },
        area_id: 
        { 
            required: true
        },
        /*nursery_category_id: 
        { 
            required: true
        },*/
        number: 
        { 
            required: true
        },
        moo:
        {
            required: true
        },
        province_id:
        {
            required: true
        },
        amphur_id:
        {
            required: true
        },
        district_id:
        {
            required: true
        },
        code:
        {
            required: true
        },
        p_title:
        {
            required: true
        },
        p_name:
        {
            required: true
        },
        p_surname:
        {
            required: true
        },
        p_tel:
        {
            required: true
        },
        p_email:
        {
            required: true
        },
        captcha:
        {
            required: true,
            remote: "users/check_captcha"
        }
    },
    messages:
    {
        name:
        {
            required: "กรุณากรอกชื่อศูนย์เด็กเล็กค่ะ"
            //remote: "ชื่อศูนย์เด็กเล็กนี้มีแล้วค่ะ"
        },
        area_id:
        {
            required: "กรุณาเลือกสคร.ค่ะ"
        },
        /*nursery_category_id:
        {
            required: "กรุณาเลือกคำนำหน้าค่ะ"
        },*/
        number:
        {
            required: "กรุณากรอกเลขที่ค่ะ"
        },
        moo:
        {
            required: "กรุณากรอกหมู่ค่ะ"
        },
        province_id:
        {
            required: "กรุณากรอกจังหวัดค่ะ"
        },
        amphur_id:
        {
            required: "กรุณากรอกอำเภอค่ะ"
        },
        district_id:
        {
            required: "กรุณากรอกตำบลค่ะ"
        },
        code:
        {
            required: "กรุณากรอกรหัสไปรษณีย์ค่ะ"
        },
        p_title:
        {
            required: "กรุณากรอกคำนำหน้าค่ะ"
        },
        p_name:
        {
            required: "กรุณากรอกชื่อค่ะ"
        },
        p_surname:
        {
            required: "กรุณากรอกนามสกุลค่ะ"
        },
        p_tel:
        {
            required: "กรุณากรอกโทรศัพท์ค่ะ"
        },
        p_email:
        {
            required: "กรุณากรอกอีเมล์ค่ะ"
        },
        captcha:
        {
            required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพ",
            remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพ"
        }
    }
    });
    
    $(".btn_register").click(function(){
        var name = $('input[name=name]').val();
        var province_name = $('select[name="province_id"] option:selected').text();
        var amphur_name = $('select[name="province_id"] option:selected').text();
        var district_name = $('select[name="district_id"] option:selected').text();
        
        $.get('nurseries/check_name',{
            'name' : $('input[name=name]').val(),
            'district_id' : $('select[name=district_id]').val()
        },function(data){
            if(data == "false"){
                alert("มีชื่อศูนย์เด็กเล็ก"+name+"\nจังหวัด"+province_name+"\nอำเภอ"+amphur_name+"\nตำบล"+district_name+"\nอยู่ในระบบแล้ว");
            }else{                
                $.ajax({
                    url: "ajax/save_nurseries",
                    type: "post",
                    data: $('#frmnursery').serialize(),
                    success: function(data) {
                        if(data > 0){
                            $('[name=nurseries_id]').val(data);
                            $('#nurseryCode').val($("#frmnursery").find('[name=code]').val());
                            $('#nurseryName').val($("#frmnursery").find('[name=name]').val());
                            $('#nurseryProvince').val($("#frmnursery").find('select[name=province_id] option:selected').text());
                            $('#nurseryAmphur').val($("#frmnursery").find('select[name=amphur_id] option:selected').text());
                            $('#nurseryDistrict').val($("#frmnursery").find('select[name=district_id] option:selected').text());      
                            $('#nurseries_list').modal('hide')
                        }
                    }
                });                                               
            }
        });
    });
    
});
</script>