<style>
	table th{width:150px;}
</style>
<form method="post" action="nurseries/save_status">
  	<fieldset style="border:1px dashed #ccc; padding:10px;">
	        <legend style="color:#01a8d2 !important; padding:0 5px; font-size:14px; font-weight:700; color:#666; margin:0px; border-bottom: none !important;">ข้อมูลศูนย์เด็กเล็ก (<?=$nursery->nursery_category->title?><?=$nursery->name?>)</legend>
	<table class="table table-condensed">
		<tr>
			<th>สคร.</th>
			<td><?=$nursery->area->area_name?></td>
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
		      <th>ผลการประเมิน</th>
		      <td>
		      	<?if($nursery->status == 0):?>
	        		<?if($nursery->assessment->total != 0):?>
	        			<span style="color:#D14">ไม่ผ่านเกณฑ์ <br>(<?=$nursery->assessment->total?> คะแนน)</span>
	        		<?else:?>
	        			รอการประเมิน
	        		<?endif;?>
	        	<?else:?>
	        		<span style="color:teal">
	        		ผ่านเกณฑ์ <br>
	        		<?if($nursery->approve_year != 0):?>
	        			(พ.ศ. <?=$nursery->approve_year?>)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=$nursery->approve_year + 3?></span>
	        		<?else:?>
	        			(<?=$nursery->assessment->total?> คะแนน)<br>
	        			<span style="color:#d14;">หมดอายุปี <?=date("Y", strtotime($nursery->approve_date)) + 546;?></span>
	        		<?endif;?>
	        		
	        		</span>
	        	<?endif;?>
		      </td>
			</tr>
	    </table>
	</fieldset>
  </div>
</form>
