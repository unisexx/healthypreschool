<style>
	table th{width:150px;}
</style>
<!-- <form method="post" action="nurseries/save_status/<?=$nursery->id?>" enctype="multipart/form-data"> -->
  	<fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">ข้อมูลศูนย์เด็กเล็ก (<?=$nursery->nursery_category->title?><?=$nursery->name?>)</legend>
	<table class="table table-condensed">
		<tr>
			<th>สคร.</th>
			<td><?=$nursery->area_id?></td>
		</tr>
		<tr>
	       <th>ปีที่เข้าร่วมโครงการ</th>
	       <td><?=$nursery->year?></td>
	     </tr>
	     <tr>
	     	<th>ชื่อศูนย์เด็กเล็ก</th>
	     	<td><?=$nursery->nursery_category->title?><?=$nursery->name?></td>
	     </tr>
	     <tr>
	      <th>ที่อยู่</th>
	      <td>เลขที่ <?=$nursery->number?> หมู่ <?=$nursery->moo?> <br>ตำบล <?=$nursery->district->district_name?> อำเภอ <?=$nursery->amphur->amphur_name?> <br>จังหวัด <?=$nursery->province->name?> <br>รหัสไปรษณีย์ <?=$nursery->code?></td>
	 	</tr>
	     <tr>
	     	<th>สังกัด</th>
	     	<td><?=$nursery->under?> <?=$nursery->under_other?></td>
	     </tr>
	</table>
	</fieldset>
	
	<fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">หัวหน้าศูนย์เด็กเล็ก</legend>
			<table class="table table-condensed">
		         <tr>
			      <th>ชื่อ</th>
			      <td><?=$nursery->p_title?><?=$nursery->p_name?> <?=$nursery->p_surname?></td>
			 	</tr>
		         <tr>
		           <th>โทรศัพท์</th>
		           <td><?=$nursery->p_tel?></td>
		         </tr>
		         <tr>
		           <th>อีเมล์</th>
		           <td><?=$nursery->p_email?></td>
		         </tr>
		    </table>
	</fieldset>
	
	<!-- <fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">ผลการประเมิน</legend>
        <table class="table table-condensed">
        	<tr>
        		<th>แบบประเมิน 35 ข้อ</th>
        		<td><a href="assessments/form?nursery_id=<?=$nursery->id?>" target="_blank">ประเมินผล</a></td>
        	</tr>
	   	    <tr>
		      <th>ผ่านเกณฑ์</th>
		      <td>
		      	<?php
		      		// กำหนดปีที่ผ่านเกณฑ์เริ่มต้นจากปีที่เข้าร่วม
		      		// $year = $nursery->year; // ปีที่เข้าร่วม
		      		$year = 2557;
					$start_year = $year > 2554 ? $year : 2554;
					$end_year = date("Y") + 543;
					for($start=$start_year;$start<=$end_year;$start++){
		      			$arr[$start] = 'ผ่านเกณฑ์ปี '.$start; 
					}
		      	?>
		      	<?=form_dropdown('approve_year',$arr,$nursery->approve_year,'','ปรับสถานะเป็นรอการประเมิน');?>
		      	<input type="hidden" name="id" value="<?=$nursery->id?>">
		      </td>
			</tr>
			<tr>
				<th>หมดอายุ</th>
				<td>
					<?if($nursery->status == 1){echo $nursery->approve_year + 2;}?>
				</td>
			</tr>
			<tr>
				<th></th>
				<td>
					<input type="submit" class="btn btn-primary btn-submit" value="บันทึก">
					<input type="button" class="btn" data-dismiss="modal" aria-hidden="true" value="ปิด">
				</td>
			</tr>
	    </table>
	</fieldset> -->
	
	<fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">ผลการประเมิน</legend>
        	<table class="table table-striped table-bordered">
			<tr>
				<th class="span1">ลำดับ</td>
				<th>ปีที่ประเมิน</th>
				<th>สถานะการประเมิน</th>
				<th>รูปแบบการประเมิน</th>
				<th>ปีที่หมดอายุ</th>
			</tr>
			<tbody id="assessmentData">
			<?foreach($assessments as $key=>$assessment):?>
			<tr>
				<td><?=$key+1?></td>
				<td><?=$assessment->approve_year?></td>
				<td><?=get_assessment_status($assessment->status)?></td>
				<td><?=get_assessment_approve_type_2($assessment->status,$assessment->approve_type,$assessment->approve_user_id,$assessment->total,$assessment->id)?></td>
				<td>
					<?
						if($assessment->status == 1){ // ถ้าผ่านเกณฑ์
							echo ($assessment->approve_year)+2;
						}
					?>
				</td>
			</tr>
			<?endforeach;?>
			</tbody>
		</table>
	</fieldset>
	
	<fieldset id="assessmentForm" style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">แบบฟอร์มประเมินผล (สำหรับเจ้าหน้าที่)</legend>
        	<table class="table table-condensed">
	         <tr>
		      <th>ปีที่ทำการประเมิน</th>
		      <td>
		      		<select name="approve_year">
		      		<?
						for ($x = (date("Y")+543); $x >= 2557; $x--) {
					    echo "<option value='$x'>$x</option>";
					} 
		      		?>
		      		</select>
		      </td>
		 	</tr>
	         <tr>
	           <th>สถานะการประเมิน</th>
	           <td>
	           		<select name="status">
	           			<option value="1">ผ่านเกณฑ์</option>
	           			<option value="2">ไม่ผ่านเกณฑ์</option>
	           			<option value="0">รอการประเมิน</option>
	           		</select>
	           </td>
	         </tr>
			 <tr>
	           <th></th>
	           <td>
	           		<input type="hidden" name="nursery_id" value="<?=$nursery->id?>">
	           		<input type="hidden" name="approve_user_id" value="<?=user_login()->id?>">
	           		<input type="hidden" name="approve_type" value="1">
	           		<input id="submitBtn" type="button" value="บันทึก" onclick="clickOffConfirmed = confirm('ยืนยันการบันทึกข้อมูล?');">
	           	</td>
	         </tr>
	    </table>
	</fieldset>
  </div>
<!-- </form> -->

<script>
$(document).ready(function(){
	$("#submitBtn").click(function(){
		if (!clickOffConfirmed) return false;
		
			var status =  $(this).closest("#assessmentForm").find("select[name=status]").val();
			var approve_year = $(this).closest("#assessmentForm").find("select[name=approve_year]").val();
			var nursery_id = $(this).closest("#assessmentForm").find("input[name=nursery_id]").val();
			var approve_user_id = $(this).closest("#assessmentForm").find("input[name=approve_user_id]").val();
			var approve_type = $(this).closest("#assessmentForm").find("input[name=approve_type]").val();
			
			$.get('ajax/officerAssessmentSubmit',{
				'status' : status,
				'approve_year' : approve_year,
				'nursery_id' : nursery_id,
				'approve_user_id' : approve_user_id,
				'approve_type' : approve_type
			},function(data){
				$("#assessmentData").html(data);
			});
		
		return true;
	});
});
</script>
