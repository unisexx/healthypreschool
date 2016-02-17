<style>
	table th{width:150px;}
</style>
<form method="post" action="nurseries/save_status" enctype="multipart/form-data">
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
	
	<fieldset style="border:1px dashed #ccc; padding:10px;">
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
		      		$year = $nursery->year; // ปีที่เข้าร่วม
					$start_year = $year > 2554 ? $year : 2554;
					$end_year = date("Y") + 543;
					for($start=$start_year;$start<=$end_year;$start++){
		      			$arr[$start] = 'ผ่านเกณฑ์ปี '.$start; 
					}
		      	?>
		      	<?=form_dropdown('approve_year',$arr,$nursery->approve_year,'','ไม่ผ่านเกณฑ์ ');?>
		      	<input type="hidden" name="id" value="<?=$nursery->id?>">
		      </td>
			</tr>
			<tr>
				<th>หมดอายุ</th>
				<td>
					<?if($nursery->status == 1){echo $nursery->approve_year + 3;}?>
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
	</fieldset>
  </div>
</form>
