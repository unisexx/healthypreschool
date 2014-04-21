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
    			<option value="form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=$row->id?>&month=<?=@$_GET['month']?>&year=<?=@$_GET['year']?>" <?=($_GET['classroom_id']==$row->id)?"selected":"";?>><?=$row->room_name?></option>
    		<?php endforeach;?>
    	</select>
    </td>
  </tr>
</table>
<br />


<?if($_GET['classroom_id'] != ""):?>
<form method="post" action="diseases/save">
<table width="98%&quot;" border="0" align="center" cellpadding="0"  class="table1">
  <tr bgcolor="#cce5fe">
    <td width="2%" rowspan="2" align="center"><b>ลำดับ</b></td>
    <td width="13%" rowspan="2" align="center"><b>ชื่อ - สกุล เด็ก</b></td>
    <td colspan="31" align="center">
    	
      <div style="float:left; margin-left:650px;">ประจำเดือน</div>
    <div style="float:left; margin-left:10px;">
    		<?php $arrayMonth = array('1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน', '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม', '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม',);?>
        	<select name="room3" id="room3" style="margin-bottom:5px;" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
            <option selected="selected">เลือกเดือน</option>
            <?for($i=1;$i<=12;$i++):?>
            	<option value="form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=$i?>&year=<?=@$_GET['year']?>" <?=($_GET['month']==$i)?"selected":"";?>><?=$arrayMonth[$i]?></option>
            <?endfor;?>
          </select>
        </div>
      <div style="float:left; margin-left:10px;">พ.ศ.</div>
  <div style="float:left; margin-left:10px;">
        	<select name="year" id="room2" style="margin-bottom:5px;" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
            <option>เลือกปี</option>
            <?php
            	$firstYear = (int)date('Y') + 533;
				$lastYear = $firstYear + 20;
				for($i=$firstYear;$i<=$lastYear;$i++):
			?>
				<option value="form?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=@$_GET['month']?>&year=<?=$i?>" <?=($_GET['year']==$i)?"selected":"";?>><?=$i?></option>
			<?endfor;?>
            </select>
        </div>
    </td>
  </tr>
  <tr bgcolor="#cce5fe">
  	<?for($i=1;$i<=31;$i++):?>
  	<td width="2%" align="center"><?=$i?></td>
  	<?endfor;?>
  </tr>
  <?foreach($childs as $key=>$row):?>
  <tr>
  	<td align="center" valign="top" ><?=$key+1?></td>
    <td valign="top"><?=$row->title?> <?=$row->child_name?></td>
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
		$CI =& get_instance();
		$data['disease'] = $CI->db->query($sql);
    ?>
    <td align="center">
    	<select name="c1[]" style="margin-bottom:5px;">
    	  <option value="-">-</option>
    	  <option value="C">C</option>
    	  <option value="H">H</option>
    	  <option value="D">D</option>
    </select>
    	<select name="c2[]" style="margin-bottom:5px;">
    	  <option value="-">-</option>
    	  <option value="0">0</option>
    	  <option value="1">1</option>
    	  <option value="2">2</option>
</select>
    	<select name="c3[]" style="margin-bottom:5px;">
    	  <option value="-">-</option>
    	  <option value="x">x</option>
    	  <option value="/">/</option>
        </select>
    	<select name="c4[]" style="margin-bottom:5px;">
    	  <option value="-">-</option>
    	  <option value="0">O</option>
        </select>
    	<select name="c5[]" style="margin-bottom:5px;">
    	  <option value="-">-</option>
    	  <option value="*">*</option>
        </select>
        <input type="hidden" name="nursery_id[]" value="<?=$_GET['nursery_id']?>">
        <input type="hidden" name="classroom_id[]" value="<?=$_GET['classroom_id']?>">
        <input type="hidden" name="classroom_detail_id[]" value="<?=$row->id?>">
        <input type="hidden" name="day[]" value="<?=$i?>">
        <input type="hidden" name="month[]" value="<?=$_GET['month']?>">
        <input type="hidden" name="year[]" value="<?=$_GET['year']?>">
    </td>
  	<?endfor;?>
  </tr>
  <?endforeach;?>
  <tr>
</table>

<input type="submit" value="บันทึก">
</form>
<?endif;?>