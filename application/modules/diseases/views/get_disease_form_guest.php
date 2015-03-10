<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม', ); ?>

<!-- <form id="diseaseform" method="post" action="disease/save_disease"> -->
  	<fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">ฟอร์มแบบคัดกรองโรค</legend>
	<table class="table table-condensed">
		<tr>
			<th style="width: 245px;">ชื่อศูนย์</th>
			<td><?=$_GET['nursery_name'] ?></td>
		</tr>
		<tr>
	       <th>ห้องเรียน / ชั้นเรียน</th>
	       <td><?=$_GET['classroom_name'] ?></td>
		</tr>
		<tr>
	     	<th>วันที่</th>
	     	<td><?=$_GET['day'] ?> <?=$arrayMonth[$_GET['month']] ?> พ.ศ. <?=$_GET['year'] ?></td>
		</tr>
		<tr>
	     	<th>ชื่อ นามสกุลเด็ก</th>
	     	<td><?=$_GET['child_name'] ?></td>
		</tr>
		<tr>
			<th>โรคที่พบบ่อย</th>
			<td>
				<select name="c1">
					<option value="C" <?=$disease -> c1 == 'C' ? "selected" : ""; ?>>หวัด</option>
					<option value="H" <?=$disease -> c1 == 'H' ? "selected" : ""; ?>>มือ เท้า ปาก</option>
					<option value="D" <?=$disease -> c1 == 'D' ? "selected" : ""; ?>>อุจจาระร่วง</option>
					<option value="F" <?=$disease -> c1 == 'F' ? "selected" : ""; ?>>ไข้</option>
					<option value="R" <?=$disease -> c1 == 'R' ? "selected" : ""; ?>>ไข้ออกผื่น</option>
					<option value="O" <?=$disease -> c1 == 'O' ? "selected" : ""; ?>>อื่นๆ</option>
				</select>
				<input class="other" type="text" name="other" value="<?=$disease -> other ?>" placeholder="ระบุโรคอื่นๆ">
			</td>
		</tr>
		<tr>
			<th>สถานะเด็กป่วย</th>
			<td>
				<select name="c3">
					<option value="/" <?=$disease -> c3 == '/' ? "selected" : ""; ?>>มาเรียน</option>
					<option value="x" <?=$disease -> c3 == 'x' ? "selected" : ""; ?>>หยุดเรียน</option>
				</select>
			</td>
		</tr>
		<tr class="trc2">
			<th>การแยกเด็กป่วย</th>
			<td>
				<select name="c2">
					<option value="0" <?=$disease -> c2 == '0' ? "selected" : ""; ?>>ไม่มีการแยกนอนแยกเล่น</option>
					<option value="1" <?=$disease -> c2 == '1' ? "selected" : ""; ?>>แยกนอน</option>
					<option value="2" <?=$disease -> c2 == '2' ? "selected" : ""; ?>>แยกเล่น</option>
				</select>
			</td>
		</tr>
		<!-- <tr class="trc4">
			<th>การรับยา</th>
			<td>
				<select name="c4">
					<option value="">ไม่ได้รับยามาจากบ้าน</option>
					<option value="O" <?=$disease -> c4 == 'O' ? "selected" : ""; ?>>ได้รับยามาจากบ้าน</option>
				</select>
			</td>
		</tr> -->
		<tr>
			<th>กรณีมีคนที่บ้านป่วยเป็นโรคเดียวกัน</th>
			<td>
				<select name="c5">
					<option value="">ไม่มี</option>
					<option value="*" <?=$disease -> c5 == '*' ? "selected" : ""; ?>>มี</option>
				</select>
			</td>
		</tr>
		<!-- <tr>
			<th></th>
			<td>
				<input type="hidden" name="id" value="<?=$disease->id?>">
				<input type="hidden" name="nursery_id" value="<?=$_GET['nursery_id']?>">
				<input type="hidden" name="classroom_id" value="<?=$_GET['classroom_id']?>">
				<input type="hidden" name="classroom_detail_id" value="<?=$_GET['classroom_detail_id']?>">
				<input type="hidden" name="year" value="<?=$_GET['year']?>">
				<input type="hidden" name="month" value="<?=$_GET['month']?>">
				<input type="hidden" name="day" value="<?=$_GET['day']?>">
				<input type="hidden" name="user_id" value="<?=$_GET['user_id']?>">
				<input id="submitform" type="button" value="บันทึกข้อมูล" data-dismiss="modal" aria-hidden="true">
			</td>
		</tr> -->
	</table>
	</fieldset>
	
  </div>
<!-- </form> -->

<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
	$('#submitform').click(function() {
		var children_id = $('input[name=classroom_detail_id]').val();
		var day = $('input[name=day]').val();

		$.get('diseases/save_disease?' + $('#diseaseform').serialize(), function(data) {
			$('.c' + children_id + '_d' + day).html(data);
		});
	});

	if($("select[name=c1] option:selected").val() == 'O'){
		$('.other').show();
	}else{
		$('.other').hide();
	}
	
	$('select[name=c1]').change(function() {
		if ($(this).val() == "O") {
			$('.other').show();
		} else {
			$('.other').hide();
		}
	});
	
	$('select[name=c3]').change(function() {
		if ($(this).val() == "/") {
			$('.trc2').show();
		} else {
			$('.trc2').hide();
		}
	});
});
</script>
