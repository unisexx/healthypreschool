<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script language="javascript">
$(function(){
    $("#forget").validate({
    rules: 
    {
        email: 
        { 
            required: true,
            email: true
            //remote: "users/check_email"
        },
        captcha:
        {
            required: true,
            remote: "users/check_captcha"
        }
    },
    messages:
    {
        email: 
        { 
            required: "กรุณากรอกอีเมล์",
            email: "กรุณากรอกอีเมล์ให้ถูกต้อง"
            //remote: "อีเมล์นี้ไม่สามารถใช้งานได้"
        },
        captcha:
        {
            required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพ",
            remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพ"
        }
    }
    });
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ลืมรหัสผ่าน</li>
</ul>

<h1>ลืมรหัสผ่าน</h1>
<br>

<div class="row">
    <div class="span8">
        <form id="forget" class="form-horizontal" method="post" action="users/forget_pass_save">
            <div class="control-group">
                <label class="control-label" for="inputEmail">อีเมล์</label>
                <div class="controls">
                  <input type="text" name="email" id="inputEmail" placeholder="อีเมล์">
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="inputCaptcha">รหัสลับ</label>
                <div class="controls">
                  <img src="users/captcha" /><Br>
                  <input type="text" name="captcha" id="inputCaptcha" placeholder="รหัสลับ">
                </div>
            </div>
            <div class="control-group">
                <div class="controls">
                  <button type="submit" class="btn btn-small btn-info">ลืมรหัสผ่าน</button>
                </div>
            </div>
        </form>
    </div>
</div>