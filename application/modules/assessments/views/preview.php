<style type="text/css">
@charset "utf-8";
/*
Design by http://www.favouritedesign.com
*/
/*body { margin:0; padding:0; width:100%; color:#5e5e5e; font:normal 14px/1.5em "Liberation sans", Arial, Helvetica, sans-serif; background:#fff;}*/


.clr { clear:both; padding:0; margin:0; width:100%; font-size:0px; line-height:0px;}
p { margin:8px 0; padding:0 0 8px;}
a {text-decoration:none; color:#0575d4;}
a:hover {color:#0190fe;}


/* table */
.table1 {border-spacing:2px;  border:1px solid #ccc; }
.table1 tr td {padding:5px; border-bottom:1px solid #ccc;}

.table2 {line-height:20px; }
.table2 tr td {padding:10px; border-bottom:2px solid #fff;}

.title {font-size:16px; font-weight:bold; color:#3067aa; margin:20px 0 10px 25px;}

/* officer */
.officer {float:left; width:700px; margin:10px auto 10px auto; height:33px; }
.officer ul { list-style:none; padding-left:20px; margin:0; width:700px; float:left;}
.officer ul li {display:block;  padding:0; padding-top:8px; float:left; text-align:center; margin-top:0px; border:none; padding-left:3px; margin-left:5px; background: url(../images/bullet_inno.png) 0px 13px no-repeat;}
.officer ul li a { display:block;  margin:0; padding-right:10px; padding-left:10px; font-size:13px;  font-weight:bold; color:#686868; text-decoration:none; text-align:center;}
.officer ul li.active a, .officer ul li a:hover{ padding:0px; padding-left:10px; padding-right:10px; margin:0; color:#4993ec}
</style>
<style type="text/css">
.point{text-align:center;}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$('input[type=radio]').click(function(){
		var point = $(this).val();
		$(this).closest('td').next('td').text(point);
		total();
		estimate();
	});
	
	
	$('.ele33 input[type=radio]').click(function(){
		var b = 0;
	    $(".ele33 input[type=radio]:checked").each(function() {
	       b += parseFloat($(this).val());
	    });
	    $('.c33point').html(b);
	    total();
	    estimate();
	});
	
});

// คำนวนคะแนน
function total(){
	$("#total").html(function() {
	    var a = 0;
	    $(".point").each(function() {
	        a += parseFloat($(this).html());
	    });
	    return a;
	});
	
	$('input[name=total]').val($("#total").html());
}

// ประเมินผล
function estimate(){
	$("#estimate").html(function() {
		var e;
	    var totalpoint = parseFloat($('#total').html());
	    if(totalpoint >= 28){
	    	e = "<span style='color:teal;'>ผ่านเกณฑ์</span>";
	    }else{
	    	e = "<span style='color:#D14;'>ไม่ผ่านเกณฑ์</span>";
	    }
	    return e;
	});
}
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">แบบประเมิน 35 ข้อ (<?=$nursery->nursery_category->title?><?=$nursery->name?>)</li>
</ul>

<p class="title"><b>ส่วนที่ 1 แบบสอบถามและตรวจสอบ การดำเนินงานป้องกันควบคุมโรคในศูนย์เด็กเล็ก</b></p>
<p class="title"><strong>คำชี้แจง</strong> ให้ผู้ประเมินสอบถามครูและผู้ดูแลเด็กในการดำเนินงานป้องกันควบคุมโรค ภายในระยะเวลา 1 ปีที่ผ่านมา และตรวจสอบเอกสาร/หลักฐานในการดำเนินงาน ตามหัวข้อการประเมินที่กำหนดให้</p>


<table width="98%" border="0" align="center" cellpadding="0"  class="table1">
  <tr  bgcolor="#cce5fe">
    <td align="center"><strong>ที่</strong></td>
    <td align="center"><strong>หัวข้อการประเมิน</strong></td>
    <td align="center"><strong>คะแนนที่ได้</strong></td>
    <td align="center"><strong>หมายเหตุ/ เหตุผลที่ไม่ผ่าน</strong></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">1.</td>
    <td bgcolor="#F5F5F5">ศูนย์เด็กเล็กมีนโยบาย หรือ แผนปฏิบัติงาน หรือโครงการประจำปีในการป้องกันควบคุมโรคติดต่อของศูนย์เด็กเล็ก
    <p><input type="radio" name="c1" value="1.00" <?=$assessment->c1 == 1.00 ? 'checked' : '' ;?>>  มีนโยบาย/แผนปฏิบัติงาน/โครงการ และมีเอกสาร/หลักฐานในการดำเนินงาน (1คะแนน)</p>
    <p><input type="radio" name="c1" value="0.50" <?=$assessment->c1 == 0.50 ? 'checked' : '' ;?>> มีนโยบาย/แผนปฏิบัติงาน/โครงการ แต่ไม่มีเอกสาร/หลักฐานในการดำเนินงาน (0.5คะแนน)</p>
    <p><input type="radio" name="c1" value="0.00" <?=$assessment->c1 == 0.00 ? 'checked' : '' ;?>> ไม่มีนโยบาย/แผนปฏิบัติงาน/โครงการ (0 คะแนน)</p></td>
    <td class="point" bgcolor="#F5F5F5"><?=number_format($assessment->c1,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c1_n"><?=$assessment->c1_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">2.</td>
    <td>ศูนย์เด็กเล็กมีการประชุมคณะกรรมการหรือคณะทำงานในเรื่อง การดูแลสุขภาพอนามัยและการพัฒนาสุขภาพของเด็ก
    <p><input type="radio" name="c2" value="1.00" <?=$assessment->c2 == 1.00 ? 'checked' : '' ;?>> ประชุม และมีรายงานการประชุม/ภาพกิจกรรม/เอกสารประกอบการประชุม (1คะแนน)</p>
    <p><input type="radio" name="c2" value="0.50" <?=$assessment->c2 == 0.50 ? 'checked' : '' ;?>> ประชุม แต่ไม่มีรายงานการประชุม/ภาพกิจกรรม/เอกสารประกอบการประชุม (0.5คะแนน)</p>
    <p><input type="radio" name="c2" value="0.00" <?=$assessment->c2 == 0.00 ? 'checked' : '' ;?>> ไม่มีการประชุม (0 คะแนน)</p></td>
    <td class="point"><?=number_format($assessment->c2,2)?></td>
    <td><textarea name="c2_n"><?=$assessment->c2_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">3.</td>
    <td bgcolor="#F5F5F5">สูนย์เด็กเล็กมีสัดส่วนครูและผู้ดูแลเด็ก โดยเฉลี่ยอย่างน้อย 1 คน ต่อเด็ก 20 คน
    <p><input type="radio" name="c3" value="1.00" <?=$assessment->c3 == 1.00 ? 'checked' : '' ;?>>  ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c3" value="0.00" <?=$assessment->c3 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>จำนวนเด็กทั้งหมด <input type="text" name="c3_1" value="<?=$assessment->c3_1?>"> คน</p>
    <p>จำนวนครูและผู้ดูแลเด็ก <input type="text" name="c3_2" value="<?=$assessment->c3_2?>"> คน</p>
    <p>คิดเป็นสัดส่วน <input type="text" name="c3_3" value="<?=$assessment->c3_3?>"> </p></td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c3,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c3_n"><?=$assessment->c3_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">4.</td>
    <td>ครูและผู้ดูแลเด็กทุกคน ได้รับการตรวจสุขภาพประจำปี หรือตรวจภาพรังสีปอดอย่างน้อยทุก 1-2 ปี
    	<p><input type="radio" name="c4" value="1.00" <?=$assessment->c4 == 1.00 ? 'checked' : '' ;?>> มีผลการตรวจสุขภาพประจำปี / ใบรับรองแพทย์ / ผลการตรวจภาพรังสีปอดครบทุกคน (1 คะแนน)</p>
    	<p><input type="radio" name="c4" value="0.00" <?=$assessment->c4 == 0.00 ? 'checked' : '' ;?>>  ไม่มีผลการตรวจสุขภาพประจำปี / ใบรับรองแพทย์ / ผลการตรวจภาพรังสีปอด หรือมีไม่ครบทุกคน (0 คะแนน)</p>
    </td>
    <td class="point"><?=number_format($assessment->c4,2)?></td>
    <td><textarea name="c4_n"><?=$assessment->c4_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">5.</td>
    <td bgcolor="#F5F5F5">ครูและผู้ดูแลเด็กทุกคนได้รับการอบรมในเรื่อง การป้องกันควบคุมโรคติดต่อที่พบบ่อยในศูนย์เด็กเล็ก จากเจ้าหน้าที่สาธารณสุข อย่างน้อยปีละ ๑ ครั้ง
    	<p><input type="radio" name="c5" value="1.00" <?=$assessment->c5 == 1.00 ? 'checked' : '' ;?>>  มีใบรับรองการอบรม / เอกสารการจัดอบรม ครบทุกคน(1 คะแนน)</p>
    	<p><input type="radio" name="c5" value="0.50" <?=$assessment->c5 == 0.50 ? 'checked' : '' ;?>> มีใบรับรองการอบรม / เอกสารการจัดอบรม อย่างน้อยร้อยละ 50 ของจำนวนครูและผู้ดูแลเด็กเล็ก แต่ไม่ครบทุกคน(0.5 คะแนน)</p>
        <p><input type="radio" name="c5" value="0.00" <?=$assessment->c5 == 0.00 ? 'checked' : '' ;?>> มีใบรับรองการอบรม / เอกสารการจัดอบรม น้อยกว่าร้อยละ 50 ของจำนวนครูและผู้ดูแลเด็กเล็ก แต่ไม่ครบทุกคน(0 คะแนน)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c5,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c5_n"><?=$assessment->c5_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">6.</td>
    <td>ถ้าท่านป่วยเป็นโรคติดเชื้อทางเดินหายใจ เช่น โรคหวัด แต่จำเป็นต้องมาปฏิบัติงาน ท่านคิดว่าจะปฏิบัติตนอย่างไร
    	<p><input type="radio" name="c6" value="1.00" <?=$assessment->c6 == 1.00 ? 'checked' : '' ;?>> ใส่หน้ากากอนามัย ตลอดเวลาการปฏิบัติงาน และล้างมือด้วยน้ำและสบู่ หรือ แอลกอฮอล์เจลทุกครั้ง หลังสัมผัสน้ำมูก น้ำลาย ก่อนและหลังดูแลเด็ก (1 คะแนน)</p>
        <p><input type="radio" name="c6" value="0.00" <?=$assessment->c6 == 0.00 ? 'checked' : '' ;?>> ไม่ได้ทำ หรือ ทำไม่ครบทั้งสองอย่าง(0 คะแนน)</p>
    </td>
    <td class="point"><?=number_format($assessment->c6,2)?></td>
    <td><textarea name="c6_n"><?=$assessment->c6_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">7.</td>
    <td bgcolor="#F5F5F5">ถ้าท่านป่วยเป็นโรคอุจจาระร่วง แต่จำเป็นต้องมาปฏิบัติงาน ท่านคิดว่าจะปฏิบัติตนอย่างไร
    	<p><input type="radio" name="c7" value="1.00" <?=$assessment->c7 == 1.00 ? 'checked' : '' ;?>> ล้างมือด้วยน้ำและสบู่ ทุกครังก่อนรับประทานอาหารและหลังการขับถ่าย (1 คะแนน)</p>
        <p><input type="radio" name="c7" value="0.00" <?=$assessment->c7 == 0.00 ? 'checked' : '' ;?>> ไม่ได้ทำ หรือ ไม่ได้ล้างมือด้วยน้ำและสบู่ทุกครั้ง (0 คะแนน)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c7,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c7_n"><?=$assessment->c7_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">8.</td>
    <td>ศูนย์เด็กเล็กมีตารางกิจกรรมให้ความรู้ เรื่อง การป้องกันควบคุมโรคติดต่อสำหรับเด็กอย่างน้อย สัปดาห์ละ 1 ครั้ง
    	<p><input type="radio" name="c8" value="1.00" <?=$assessment->c8 == 1.00 ? 'checked' : '' ;?>> มี (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c8" value="0.00" <?=$assessment->c8 == 0.00 ? 'checked' : '' ;?>> ไม่มี (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c8,2)?></td>
    <td><textarea name="c8_n"><?=$assessment->c8_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">9.</td>
    <td bgcolor="#F5F5F5">มีกิจกรรมให้เด็กล้างมือด้วยน้ำและสบู่ทุกวัน และเด็กสามารถล้างมือได้อย่างถูกต้อง ให้ครูและผู้ดูแลเด็กคัดเลือกเด็ก จำนวน 5 คน ล้างมือให้ดู
    	<p><input type="radio" name="c9" value="1.00" <?=$assessment->c9 == 1.00 ? 'checked' : '' ;?>> ล้างมือถูกต้องทุกคน (1 คะแนน)</p>
        <p><input type="radio" name="c9" value="0.00" <?=$assessment->c9 == 0.00 ? 'checked' : '' ;?>> ล้างมืไม่ถูกต้อง.....คน (0 คะแนน)</p>
        <p>(เกณฑ์ขั้นต่ำที่ต้องผ่านการประเมิน คือ ล้างบริเวณฝ่ามือ หลังมือ นิ้วหัวแม่มือ และเหนือข้อมือเล็กน้อย)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c9,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c9_n"><?=$assessment->c9_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">10.</td>
    <td>ครูและผู้ดูแลเด็กเล็กจัดทำแฟ้มประวัติสุขภาพประจำตัวเด็กทุกคนภายในศูนย์ ซึ่งประกอบด้วย แบบบันทึกประวัติการได้รับวัคซีนและแบบบันทึกปัญหาสุขภาพและการดูแลเบื้อต้นของเด็ก
    	<p><input type="radio" name="c10" value="1.00" <?=$assessment->c10 == 1.00 ? 'checked' : '' ;?>> มี (1 คะแนน)</p>
        <p><input type="radio" name="c10" value="0.00" <?=$assessment->c10 == 0.00 ? 'checked' : '' ;?>> ไม่มีแบบบันทึก / มีไม่ครบทั้งสองแบบ (0 คะแนน)</p>
    </td>
    <td class="point"><?=number_format($assessment->c10,2)?></td>
    <td><textarea name="c10_n"><?=$assessment->c10_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">11.</td>
    <td bgcolor="#F5F5F5">ครูและผู้ดูแลเด็กบันทึกอาการป่วยของเด็กในแบบคัดกรองอาการป่วยรายห้องเรียน ทุกคน ทุกวัน
    	<p><input type="radio" name="c11" value="1.00" <?=$assessment->c11 == 1.00 ? 'checked' : '' ;?>> บันทึกทุกวัน (1 คะแนน)</p>
        <p><input type="radio" name="c11" value="0.00" <?=$assessment->c11 == 0.00 ? 'checked' : '' ;?>> ไม่บันทึก / บันทึกเป็นบางวัน (0 คะแนน)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c11,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c11_n"><?=$assessment->c11_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">12.</td>
    <td>หากมีเด็กป่วยเกิดขึ้นระหว่างอยู่ในศูนย์เด็กเล็ก ท่านมีแนวทางการแยกเด็กป่วย อย่างไร
    	<p><input type="radio" name="c12" value="1.00" <?=$assessment->c12 == 1.00 ? 'checked' : '' ;?>> แยกนอนทุกครั้งโดยใช้ห้องแยก / กรณีไม่มีห้องแยก ใช้ม่านหรือฉากกั้นเป็นสัดส่วน และห่างจากเด็กอื่น อย่างน้อย 1 เมตร (1 คะแนน)</p>
        <p><input type="radio" name="c12" value="0.00" <?=$assessment->c12 == 0.00 ? 'checked' : '' ;?>> ไม่แยกนอน / แยกไม่ถูกต้อง (0 คะแนน)</p>
    	</td>
    <td class="point"><?=number_format($assessment->c12,2)?></td>
    <td><textarea name="c12_n"><?=$assessment->c12_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">13.</td>
    <td bgcolor="#F5F5F5">เด็กทุกคนมีบันทึกการได้รับวัคซีนครบถ้วนตามเกณฑ์ที่กรมควบคุมโรคกำหนดโดยสุ่มแบบบันทึกประวัติการได้รับวัคซีนของเด็ก
    	<p>- จำนวนเด็ก &lt; 50 คน สุ่ม 10 คน</p>
        <p>- จำนวนเด็ก 50-100 คน สุ่ม 20 คน</p>
        <p>- จำนวนเด็ก > 100 คน สุ่ม 30 คน</p>
        <p><input type="radio" name="c13" value="1.00" <?=$assessment->c13 == 1.00 ? 'checked' : '' ;?>> มีการบันทึกได้รับวัคซีนครบถ้วนทุกคน มากกว่ร้อยละ 90 (1 คะแนน)</p>
    	<p><input type="radio" name="c13" value="0.50" <?=$assessment->c13 == 0.50 ? 'checked' : '' ;?>> มีการบันทึก ร้อยละ 80-90 (0.5 คะแนน)</p>
        <p><input type="radio" name="c13" value="0.00" <?=$assessment->c13 == 0.00 ? 'checked' : '' ;?>> ไม่มีประวัติการได้รับวัครซีนของเด็ก หรือบันทึกน้อยกว่า ร้อยละ 80 (0 คะแนน)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c13,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c13_n"><?=$assessment->c13_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">14.</td>
    <td>ครูและผู้ดูแลเด็กจัดกิจกรรมให้ความรู้กับผู้ปกครองเรื่องโรคติดต่อที่พบบ่อยในเด็กอย่างน้อยปีละครั้ง 1 ครั้ง โดยประสานเจ้าหน้าที่จากหน่วยงานสาธารณสุข
    	<p><input type="radio" name="c14" value="1.00" <?=$assessment->c14 == 1.00 ? 'checked' : '' ;?>> มีเอกสารการจัดกิจกรรม / หนังสือขอเชิญวิทยากร / แผนกิจกรรม / ภาพถ่ายกิจกรรม (1 คะแนน)</p>
        <p><input type="radio" name="c14" value="0.00" <?=$assessment->c14 == 0.00 ? 'checked' : '' ;?>> ไม่มีหลักฐานการจัดกิจกรรม (0 คะแนน)</p>
    </td>
    <td class="point"><?=number_format($assessment->c14,2)?></td>
    <td><textarea name="c14_n"><?=$assessment->c14_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">15.</td>
    <td bgcolor="#F5F5F5">ครูแและผู้ดูแลเด็กมีการตรวจสอบคุณภาพนมก่อนให้เด็กดื่มหรือไม่ อย่างไร
    	<p><input type="radio" name="c15" value="1.00" <?=$assessment->c15 == 1.00 ? 'checked' : '' ;?>> มีการตรวจสอบนมโดยสุ่มเทใส่แก้ว สังเกตสี ตะกอน ฟอง กลิ่น และรสชาติเปลี่ยนไป (1 คะแนน)</p>
        <p><input type="radio" name="c15" value="0.50" <?=$assessment->c15 == 0.50 ? 'checked' : '' ;?>> มีการตรวจสอบนม โดยวิธีอื่นๆ (0.5 คะแนน)</p>
        <p><input type="radio" name="c15" value="0.00" <?=$assessment->c15 == 0.00 ? 'checked' : '' ;?>> ไม่มีการตรวจสอบ (0 คะแนน)</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c15,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c15_n"><?=$assessment->c15_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">16.</td>
    <td>ครูและผู้ดูแลเด็กเล็กจัดให้มีแก้วน้ำดื่มเฉพาะตัวเด็กครบทุกคน และจัดเก็บแก้วน้ำในที่สะอาด ไม่ปะปนกับของผู้อื่น และสูงจากพื้นอย่างน้อย 60 เซนติเมตร
      <p><input type="radio" name="c16" value="1.00" <?=$assessment->c16 == 1.00 ? 'checked' : '' ;?>> ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c16" value="0.00" <?=$assessment->c16 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c16,2)?></td>
    <td><textarea name="c16_n"><?=$assessment->c16_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">17.</td>
    <td bgcolor="#F5F5F5">ครูและผู้ดูแลเด็กเล็กทำความสะอาดแก้วน้ำดื่มส่วนตัวเด็กทุกวัน หรือกรณีจัดให้มีแก้วน้ำส่วนรวม เฉพาะคน เฉพาะครั้ง ควรทำความสะอาดทุกครั้งหลังใช้งาน
      <p><input type="radio" name="c17" value="1.00" <?=$assessment->c17 == 1.00 ? 'checked' : '' ;?>> ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c17" value="0.00" <?=$assessment->c17 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c17,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c17_n"><?=$assessment->c17_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">18.</td>
    <td>เครื่องนอนสะอาด ไม่มีคราบ ไม่มีกลิ่นเหม็น
      <p><input type="radio" name="c18" value="1.00" <?=$assessment->c18 == 1.00 ? 'checked' : '' ;?>> ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c18" value="0.00" <?=$assessment->c18 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c18,2)?></td>
    <td><textarea name="c18_n"><?=$assessment->c18_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">19.</td>
    <td bgcolor="#F5F5F5">สังเกตความสะอาดของเล่นเด็กทุกประเภท
    	<p><input type="radio" name="c19" value="1.00" <?=$assessment->c19 == 1.00 ? 'checked' : '' ;?>> สะอาดทุกประเภท (1 คะแนน)</p>
        <p><input type="radio" name="c19" value="0.00" <?=$assessment->c19 == 0.00 ? 'checked' : '' ;?>> ไม่สะอาดบางประเภท (0 คะแนน)</p>
        <p>เกณฑ์การประเมิน</p>
        <p>1. ของเล่นประเภทไม้หรือพลาสติก ต้องแห้ง ไม่มีรา</p>
        <p>2. ของเล่นประเภทกระดาษ ต้องไม่มีฝุ่น แห้ง ไม่มีคราบสกปรก</p>
        <p>3. ของเล่นประเภทผ้า ตุ๊กตา ต้องสะอาด แห้ง ไม่มีคราบสกปรก ไม่มีกลิ่นเหม็น</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c19,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c19_n"><?=$assessment->c19_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">20.</td>
    <td>ศูนย์เด็กเล็กจัดแบ่งพื้นที่ใช้สอยเป็นสัดส่วนตามกิจกรรม ได้แก่ ส่วนการเรียนรู้ สถานที่ประกอบอาหาร / รับประทานอาหาร ห้องนอน และห้องส้วมแยกจากกัน
      <p><input type="radio" name="c20" value="1.00" <?=$assessment->c20 == 1.00 ? 'checked' : '' ;?>> เป็นสัดส่วน (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c20" value="0.00" <?=$assessment->c20 == 0.00 ? 'checked' : '' ;?>> ไม่เป็นสัดส่วน (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c20,2)?></td>
    <td><textarea name="c20_n"><?=$assessment->c20_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">21.</td>
    <td bgcolor="#F5F5F5">ศูนย์เด็กเล็กมีพื้นที่ใช้สอย ในห้องนอน หรือห้องกิจกรรม โดยเฉลี่ยอย่างน้อย 2 ตารางเมตร ต่อเด็ก 1 คน (ประเมินจากห้องที่มีพื้นที่แออัดที่สุด)
        <p>พื้นที่ <input type="text" name="c21_1" value="<?=$assessment->c21_1?>"> ตารางเมตร</p>
        <p>จำนวนเด็ก <input type="text" name="c21_2" value="<?=$assessment->c21_2?>"> คน</p>
        <p>คิดเป็น <input type="text" name="c21_3" value="<?=$assessment->c21_3?>" ตารางเมตร/เด็ก 1 คน</p>
      <p><input type="radio" name="c21" value="1.00" <?=$assessment->c21 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c21" value="0.00" <?=$assessment->c21 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c21,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c21_n"><?=$assessment->c21_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">22.</td>
    <td>สภาพแวดล้อมภายนอกของศูนย์เด็กเล็กสะอาด เป็นระเบียบเรียบร้อย ไม่มีขยะเกลื่อนกลาด ไม่มีแหล่งเพาะพันธุ์แมลงวัน ยุง และสัตว์นำโรค
      <p><input type="radio" name="c22" value="1.00" <?=$assessment->c22 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c22" value="0.00" <?=$assessment->c22 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
      </td>
    <td class="point"><?=number_format($assessment->c22,2)?></td>
    <td><textarea name="c22_n"><?=$assessment->c22_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">23.</td>
    <td bgcolor="#F5F5F5">พื้น ผนัง และบริเวณภายในอาคาร แห้ง สะอาด ไม่มีคราบสกปรก ไม่มีกลิ่นเหม็น
      <p><input type="radio" name="c23" value="1.00" <?=$assessment->c23 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c23" value="0.00" <?=$assessment->c23 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
     </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c23,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c23_n"><?=$assessment->c23_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">24.</td>
    <td>ห้องน้ำ ห้องส้วม แห้ง สะอาด ไม่มีคราบสสกปรก ไม่มีกลิ่นเหม็น และมีอากาศถ่ายเทสะดวก
      <p><input type="radio" name="c24" value="1.00" <?=$assessment->c24 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c24" value="0.00" <?=$assessment->c24 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c24,2)?></td>
    <td><textarea name="c24_n"><?=$assessment->c24_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">25.</td>
    <td bgcolor="#F5F5F5">อ่างล้างมือ/สถานที่ล้างมือ สะอาด ไม่มีคราบสกปรก ไม่มีกลิ่นเหม็น และมีอากาศถ่ายเทสะดวก
    	<p><input type="radio" name="c25" value="1.00" <?=$assessment->c25 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c25" value="0.00" <?=$assessment->c25 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c25,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c25_n"><?=$assessment->c25_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">26.</td>
    <td>ห้องน้ำ ห้องส้วม แยกจากกัน
    	<p><input type="radio" name="c26" value="1.00" <?=$assessment->c26 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c26" value="0.00" <?=$assessment->c26 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
        </td>
    <td class="point"><?=number_format($assessment->c26,2)?></td>
    <td><textarea name="c26_n"><?=$assessment->c26_n?></textarea></td>
  </tr>
   <tr>
    <td valign="top" bgcolor="#F5F5F5">27.</td>
    <td bgcolor="#F5F5F5">จำนวนโถส้วมถ่ายอุจจาระ โดยเฉลี่ยอย่างน้อย 1 โถ ต่อเด็ก 10-12 คน
    	<p><input type="radio" name="c27" value="1.00" <?=$assessment->c27 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c27" value="0.00" <?=$assessment->c27 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c27,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c27_n"><?=$assessment->c27_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">28.</td>
    <td>จำนวนก๊อกที่ล้างมือ โดยเฉลี่ยอย่างน้อย 1 จุด ต่อ เด็ก 10 คน
        <p>จำนวนก๊อกที่ล้างมือ <input type="text" name="c28_1" value="<?=$assessment->c28_1?>"> จุด</p>
        <p>จำนวนเด็ก <input type="text" name="c28_2" value="<?=$assessment->c28_2?>"> คน</p>
        <p>เฉลี่ย <input type="text" name="c28_3" value="<?=$assessment->c28_3?>"> จุดต่อเด็ก 10 คน</p>
      <p><input type="radio" name="c28" value="1.00" <?=$assessment->c28 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c28" value="0.00" <?=$assessment->c28 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td class="point"><?=number_format($assessment->c28,2)?></td>
    <td><textarea name="c28_n"><?=$assessment->c28_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">29.</td>
    <td bgcolor="#F5F5F5">น้ำดื่ม ต้องมีคุณลักษณะดังนี้
        <ul>
        	<li>คุณภาพของน้ำดื่ม: น้ำดื่มต้องใส สะอาด น้ำไม่มีตะกอน ตะไคร่น้ำ ต้องเป็นน้ำต้มสุก หรือ น้ำที่ผ่านระบบปรับปรุงคุณภาพแล้ว เช่น น้ำกรอก ที่มีการบำรุงรักษาเครื่องกรองน้ำตามคำแนะนำของผลิตภัณฑ์นั้นๆ หรือน้ำบรรจุขวดที่ได้รับอนุญาตจากอย.</li>
            <li>ภาชนะบรรจุน้ำต้องสะอาดมีฝาปิด และก๊อกน้ำหรือทางเทรินน้ำเปิด ปิดได้ ไม่มีคราบสกปรก / ตะไคร่น้ำ และภาชนะบรรจุน้ำดื่มและแก้วน้ำดื่มอยู่สุงจากพื้นมากกว่า 60 ซม.</li>
        </ul>
      <p><input type="radio" name="c29" value="1.00" <?=$assessment->c29 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c29" value="0.00" <?=$assessment->c29 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    </td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c29,2)?></td>
    <td bgcolor="#F5F5F5"><!-- น้ำดื่มไม่สะอาด เนื่องจาก
    	<p>[ ] คุณภาพของน้ำไม่สะอาด</p>
        <p>[ ] ภาชนะบรรจุน้ำไม่สะอาด</p> -->
        <textarea name="c29_n"><?=$assessment->c29_n?></textarea>
    </td>
  </tr>
  <tr>
    <td valign="top">30.</td>
    <td>น้ำดื่มมีปริมาณไม่น้อยกว่า 500 มิลลิลิตร/คน/วัน
        
      <p><input type="radio" name="c30" value="1.00" <?=$assessment->c30 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c30" value="0.00" <?=$assessment->c30 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
      </td>
    <td class="point"><?=number_format($assessment->c30,2)?></td>
    <td><textarea name="c30_n"><?=$assessment->c30_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">31.</td>
    <td bgcolor="#F5F5F5">น้ำที่ใช้ต้องสะอาด ไม่มีกลิ่น ตะกอน แหล่งน้ำอาจมาจากน้ำประปา หรือน้ำบาดาล หรือน้ำที่สะอาดปลอดภัย ภาชนะกักเก็บน้ำต้องสะอาด มีฝาปิดมิชิด
        
      <p><input type="radio" name="c31" value="1.00" <?=$assessment->c31 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c31" value="0.00" <?=$assessment->c31 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c31,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c31_n"><?=$assessment->c31_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">32.</td>
    <td>น้ำใช้มีปริมาณเพียงพอ
        <p>- กรณีน้ำใช้จากระบบประปา ต้องมีน้ำไหลตลอดเวลา</p>
        <p>- กรณีน้ำใช้จากถังเก็บน้ำ ควรมีปริมาณโดยเฉลี่ยประมาณ 20 ลิตรต่อคนต่อวัน</p>
      <p><input type="radio" name="c32" value="1.00" <?=$assessment->c32 == 1.00 ? 'checked' : '' ;?>> ใช่ (1 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c32" value="0.00" <?=$assessment->c32 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
      </td>
    <td class="point"><?=number_format($assessment->c32,2)?></td>
    <td><textarea name="c32_n"><?=$assessment->c32_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">33.</td>
    <td bgcolor="#F5F5F5" class="ele33">ศูนย์เด็กเล็กจัดให้มีวัสดุอุปกรณ์ในการปฐมพยาบาลเบื้องต้น ครบถ้วน ดังนี้
   	  <p>1. ตู้เก็บยา / กล่องเก็บยา / ที่เก็บยาสะดวกต่อการหยิบใช้ อยู่ในที่ปลอดภัย (ควรอยู่สุงจากพื้นอย่างน้อย 1.5 เมตร หากอยู่ติดพื้นควรมีกุญแจล็อคป้องกันไม่ให้เด็กหยิบจับโดยง่าย)</p>
        <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_1" value="0.25" <?=$assessment->c33_1 == 0.25 ? 'checked' : '' ;?>> มี (0.25 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_1" value="0" <?=$assessment->c33_1 == 0 ? 'checked' : '' ;?>> ไม่มี (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>2. มียาพาราเซตามอล และน้ำเกลือแร่ (ORS) ที่ไม่หมดอายุ</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_2" value="0.25" <?=$assessment->c33_2 == 0.25 ? 'checked' : '' ;?>> มี (0.25 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_2" value="0" <?=$assessment->c33_2 == 0 ? 'checked' : '' ;?>> ไม่มี (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>3. มีชุดทำแผล (สำลี ผ้ากอต พลาสเตอร์ปิดแผล น้ำยาทำความสะอาดบาดแผล)</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_3" value="0.25" <?=$assessment->c33_3 == 0.25 ? 'checked' : '' ;?>> มี (0.25 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_3" value="0" <?=$assessment->c33_3 == 0 ? 'checked' : '' ;?>> ไม่มี (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    <p>3. มีอุปกรณ์วัดไข้</p>
    <p>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_4" value="0.25" <?=$assessment->c33_4 == 0.25 ? 'checked' : '' ;?>> มี (0.25 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c33_4" value="0" <?=$assessment->c33_4 == 0 ? 'checked' : '' ;?>> ไม่มี (0 คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p>
    
    </td>
    <td bgcolor="#F5F5F5" class="c33point point" style="text-align: center;"><?=number_format($assessment->c33_1+$assessment->c33_2+$assessment->c33_3+$assessment->c33_4,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c33_n"><?=$assessment->c33_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top">34.</td>
    <td><p>ศูนย์เด็กเล็กจัดให้มีอุปกรณ์ในการป้องกันควบคุมโรคครบถ้วน ดังนี้</p>
    <p>1. หน้ากากอนามัย และ</p>
    <p>2. สบู่/แอลกอฮอล์เจล และ</p>
    <p>3. ผ้าเช็ดมือ ผ้าเช็ดหน้าเฉพาะเด็กแต่ละคน (โดยจัดเก็บในที่สะอาดไม่อับชื้น ไม่ปนเปื้อน และซักทำความสะอาดทุกวัน)</p>
    <p><input type="radio" name="c34" value="1.00" <?=$assessment->c34 == 1.00 ? 'checked' : '' ;?>> ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c34" value="0.00" <?=$assessment->c34 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
    <td class="point"><?=number_format($assessment->c34,2)?></td>
    <td><textarea name="c34_n"><?=$assessment->c34_n?></textarea></td>
  </tr>
  <tr>
    <td valign="top" bgcolor="#F5F5F5">35.</td>
    <td bgcolor="#F5F5F5"><p>มีอุปกรณ์และสื่อต่างๆ ที่ใช้ประกอบการสอน เรื่องการป้องกันควบคุมโรคในศูนย์เด็กเล็ก</p>
    <p><input type="radio" name="c35" value="1.00" <?=$assessment->c35 == 1.00 ? 'checked' : '' ;?>> ใช่ (1คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="c35" value="0.00" <?=$assessment->c35 == 0.00 ? 'checked' : '' ;?>> ไม่ใช่ (0คะแนน)&nbsp;&nbsp;&nbsp;&nbsp;</p></td>
    <td bgcolor="#F5F5F5" class="point"><?=number_format($assessment->c35,2)?></td>
    <td bgcolor="#F5F5F5"><textarea name="c35_n"><?=$assessment->c35_n?></textarea></td>
  </tr>
  <tr>
  	<td></td>
  	<td>คะแนนรวม</td>
  	<td id="total" style="text-align: center;"><?=number_format($assessment->c1+$assessment->c2+$assessment->c3+$assessment->c4+$assessment->c5+$assessment->c6+$assessment->c7+$assessment->c8+$assessment->c9+$assessment->c10+$assessment->c11+$assessment->c12+$assessment->c13+$assessment->c14+$assessment->c15+$assessment->c16+$assessment->c17+$assessment->c18+$assessment->c19+$assessment->c20+$assessment->c21+$assessment->c22+$assessment->c23+$assessment->c24+$assessment->c25+$assessment->c26+$assessment->c27+$assessment->c28+$assessment->c29+$assessment->c30+$assessment->c31+$assessment->c32+$assessment->c33_1+$assessment->c33_2+$assessment->c33_3+$assessment->c33_4+$assessment->c34+$assessment->c35,2)?>
  	</td>
  	<td></td>
  	<td></td>
  </tr>
  <tr>
  	<td></td>
  	<td>ผลการประเมิน</td>
  	<td id="estimate" nowrap="nowrap"><?=($assessment->total >= 28)?"<span style='color:teal;'>ผ่านเกณฑ์</span>":"<span style='color:#D14;'>ไม่ผ่านเกณฑ์</span>";?></td>
  	<td></td>
  	<td></td>
  </tr>
</table>