
<div class="title">ข้อมูลแบบคัดกรองโรค (เพิ่ม / แก้ไข)</div>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"  bgcolor="#F5F5F5" class="table2">
  <tr>
    <td width="44%" align="right">ชื่อศูนย์</td>
    <td width="56%"><input name="room" type="text" id="room" value="<?=user_login()->nursery->nursery_category->title?><?=user_login()->nursery->name?>" size="50" /></td>
  </tr>
  <tr>
    <td align="right">เลือกห้องเรียน / ชั้นเรียน</td>
    <td>
    	<select name="classroom_id" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
    		<option value="">เลือกห้องเรียน / ชั้นเรียน</option>
    		<?php foreach($classrooms as $row):?>
    			<option value="diseases/form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=$row->id?>&month=<?=@$_GET['month']?>&year=<?=@$_GET['year']?>" <?=($_GET['classroom_id']==$row->id)?"selected":"";?>><?=$row->room_name?></option>
    		<?php endforeach;?>
    	</select>
    </td>
  </tr>

<?if($_GET['classroom_id']):?>
  <tr>
  	<td align="right">ประจำเดือน</td>
  	<td>
		<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>
    	<select name="room3" id="room3" style="margin-bottom:5px;" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
        <option selected="selected">เลือกเดือน</option>
        <?for($i=1;$i<=12;$i++):?>
        	<option value="diseases/form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=$i?>&year=<?=@$_GET['year']?>" <?=($_GET['month']==$i)?"selected":"";?>><?=$arrayMonth[$i]?></option>
        <?endfor;?>
        </select>
		  
		  พ.ศ. <select name="year" id="room2" style="margin-bottom:5px;" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
	            <option>เลือกปี</option>
	            <?php
	            	$firstYear = (int)date('Y') + 533;
					$lastYear = $firstYear + 20;
					for($i=$firstYear;$i<=$lastYear;$i++):
				?>
					<option value="diseases/form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=@$_GET['month']?>&year=<?=$i?>" <?=($_GET['year']==$i)?"selected":"";?>><?=$i?></option>
				<?endfor;?>
	            </select>
  	</td>
  </tr>
<?endif;?>  

</table>
<br />


<style type="text/css">
table {
  table-layout: fixed; 
  *margin-left: -240px;/*ie7*/
}
td, th {
  vertical-align: top;
  /*border-top: 1px solid #ccc;*/
  padding:10px;
}
th {
  position:absolute;
  *position: relative; /*ie7*/
  left:0; 
  width:220px;
  border-top: 1px solid #ccc;
  margin-top:-3px;
}
.outer {position:relative}
.inner {
  overflow-x:scroll;
  overflow-y:visible;
  width:80%; 
  margin-left:240px;
}
</style>

<?if($_GET['classroom_id'] != ""):?>
<form method="post" action="diseases/save">
	
<div class="outer">
  <div class="inner">
  	
		<table class="table1">
		  <tr bgcolor="#cce5fe">
		    <!-- <th rowspan="2" align="center"><b>ลำดับ</b></th> -->
		    <th rowspan="2" align="center"><b>ชื่อ - สกุล เด็ก</b></th>
		  </tr>
		  <tr bgcolor="#cce5fe">
		  	<td></td>
		  	<?for($i=1;$i<=31;$i++):?>
		  	<td align="center" <?=date('j') == $i && date('m') == $_GET['month'] ? "style='background:#A2B1BF'" : "" ;?>><?=$i?></td>
		  	<?endfor;?>
		  </tr>
		  <?foreach($childs as $key=>$row):?>
		  <tr>
		  	<!-- <th align="center" valign="top" ><?=$key+1?></th> -->
		    <th valign="top"><?=$row->title?> <?=$row->child_name?></th>
		    <?for($i=1;$i<=31;$i++):?>
		    <?php
		    	$sql = "select * from diseases where 
		    			nursery_id=".$_GET['nursery_id']."
		    			and classroom_id=".$_GET['classroom_id']."
		    			and classroom_detail_id=".$row->id."
		    			and day=".$i."
		    			and month=".$_GET['month']."
		    			and year=".$_GET['year']."
		    			limit 1";
				$disease = new Disease();
				$disease->query($sql);
				// $disease->check_last_query();
		    ?>
		    <td align="center">
		    	<!-- <?=$sql?>
		    	<?=$disease->id?> -->
		    	<select name="c1[]" style="margin-bottom:5px;">
		    	  <option value="-"></option>
		    	  <option value="A" <?=($disease->c1 == 'A')?'selected':'';?>>หวัด</option>
		    	  <option value="B" <?=($disease->c1 == 'C')?'selected':'';?>>ไข้หวัดใหญ่ตามฤดูกาล</option>
		    	  <option value="C" <?=($disease->c1 == 'C')?'selected':'';?>>ไข้หวัดใหญ่สายพันธุ์ใหม่ 2009</option>
		    	  <option value="D" <?=($disease->c1 == 'D')?'selected':'';?>>อุจจาระร่วงเฉียบพลัน</option>
		    	  <option value="E" <?=($disease->c1 == 'E')?'selected':'';?>>อีสุกอีใส</option>
		    	  <option value="F" <?=($disease->c1 == 'F')?'selected':'';?>>คางทูม</option>
		    	  <option value="G" <?=($disease->c1 == 'G')?'selected':'';?>>ตาแดงหรือเยื่อบุตาอักเสบ</option>
		    	  <option value="H" <?=($disease->c1 == 'H')?'selected':'';?>>พิษสุนัขบ้าหรือโรคกลัวน้ำ</option>
		    	  <option value="I" <?=($disease->c1 == 'I')?'selected':'';?>>ไข้เลือดออก</option>
		    	  <option value="J" <?=($disease->c1 == 'J')?'selected':'';?>>ผิวหนังอักเสบจากเชื้อแบคทีเรีย</option>
		    	</select>
		    	<!-- <select name="c2[]" style="margin-bottom:5px;">
		    	  <option value="-">-</option>
		    	  <option value="0" <?=($disease->c2 == '0')?'selected':'';?>>0</option>
		    	  <option value="1" <?=($disease->c2 == '1')?'selected':'';?>>1</option>
		    	  <option value="2" <?=($disease->c2 == '2')?'selected':'';?>>2</option>
		</select>
		    	<select name="c3[]" style="margin-bottom:5px;">
		    	  <option value="-">-</option>
		    	  <option value="x" <?=($disease->c3 == 'x')?'selected':'';?>>x</option>
		    	  <option value="/" <?=($disease->c3 == '/')?'selected':'';?>>/</option>
		        </select>
		    	<select name="c4[]" style="margin-bottom:5px;">
		    	  <option value="-">-</option>
		    	  <option value="0" <?=($disease->c4 == '0')?'selected':'';?>>O</option>
		        </select>
		    	<select name="c5[]" style="margin-bottom:5px;">
		    	  <option value="-">-</option>
		    	  <option value="*" <?=($disease->c5 == '*')?'selected':'';?>>*</option>
		        </select> -->
		        <input type="hidden" name="nursery_id[]" value="<?=$_GET['nursery_id']?>">
		        <input type="hidden" name="classroom_id[]" value="<?=$_GET['classroom_id']?>">
		        <input type="hidden" name="classroom_detail_id[]" value="<?=$row->id?>">
		        <input type="hidden" name="day[]" value="<?=$i?>">
		        <input type="hidden" name="month[]" value="<?=$_GET['month']?>">
		        <input type="hidden" name="year[]" value="<?=$_GET['year']?>">
		        <input type="hidden" name="id[]" value="<?=@$disease->id?>">
		    </td>
		  	<?endfor;?>
		  </tr>
		  <?endforeach;?>
		  <tr>
		</table>
		
	</div>
</div>

<div style="text-align: center; padding:5px;">
	<input type="submit" value=" บันทึก "> 
	<a href="diseases"><input type="button" value=" กลับหน้าหลัก "></a>
</div>
</form>

<!-- <h3>หมายเหตุ : สัญลักษณ์ในการบันทึกข้อมูล</h3>
<ol>
	<li>โรคที่พบบ่อย : หวัด = C, มือ เท้า ปาก = H, อุจจาระร่วงเฉียบพลัน = D</li>
	<li>การแยกเด็กป่วย : ไม่มีการแยกนอนแยกเล่น = 0, แยกนอน = 1, แยกเล่น = 2</li>
	<li>ไม่มาเรียนให้ทำเครื่องหมาย x หากหยุดเรียนให้ใส่สัญลักษณ์โรค /</li>
	<li>กรณีเด็กได้ยารักษามาจากบ้าน 0</li>
	<li>กรณีมีคนที่บ้านป่วยด้วยโรคเดียวกันก่อนเด็กป่วย ให้ทำเครื่องหมาย *</li>
</ol> -->
<?endif;?>

<?//=cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);?>
<?//=date('m')?>