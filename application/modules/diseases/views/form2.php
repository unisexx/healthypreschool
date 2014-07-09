<!-- <style type="text/css">
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
</style> -->
<style type="text/css">
@media print
{    
    .no-print, .no-print *
    {
        display: none !important;
    }
}
.hover { background-color: #eee; cursor:pointer;}
table{border-collapse: collapse;width:100%;}
.table3 td,.table3 th{border: 1px solid #ccc;}
.table2 tr{background-color:#f1f1f1;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$(".table3").delegate('td','mouseover mouseleave', function(e) {
		    if (e.type == 'mouseover') {
		      $(this).parent().addClass("hover");
		      $("colgroup").eq($(this).index()).addClass("hover");
		    }
		    else {
		      $(this).parent().removeClass("hover");
		      $("colgroup").eq($(this).index()).removeClass("hover");
		    }
		});
		
		$(".openmodal").live("click",function(){
			$('.loader').show();
			$.get('diseases/get_disease_form',{
				'nursery_name'			: $('input[name=room]').val(),
				'classroom_name' 		: $("select[name=classroom_id] option:selected").html(),
				'child_name'			: $(this).closest('tr').find('th:eq(1)').text(),
				'nursery_id' 			: $(this).find('.h_nursery_id').val(),
				'classroom_id' 			: $(this).find('.h_classroom_id').val(),
				'classroom_detail_id' 	: $(this).find('.h_classroom_detail_id').val(),
				'day' 					: $(this).find('.h_day').val(),
				'month' 				: $(this).find('.h_month').val(),
				'year' 					: $(this).find('.h_year').val(),
				'user_id' 				: $(this).find('.h_user_id').val(),
				'id' 					: $(this).find('.h_id').val()
			},function(data){
				$('.modal-body-form').html(data);
				$('.loader').hide();
			});
		});
	});
	
	function myFunction() {
	    window.print();
	    return false;
	}
</script>


<div class="title">ข้อมูลแบบคัดกรองโรค (เพิ่ม / แก้ไข)</div>

<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0"  bgcolor="#F5F5F5" class="table2">
  <tr>
    <td width="44%" align="right">ชื่อศูนย์</td>
    <td width="56%"><input name="room" type="text" id="room" value="<?=user_login()->nursery->nursery_category->title?><?=user_login()->nursery->name?>" size="50" readonly/></td>
  </tr>
  <tr>
    <td align="right">เลือกห้องเรียน / ชั้นเรียน</td>
    <td>
    	<select name="classroom_id" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
    		<option value="">เลือกห้องเรียน / ชั้นเรียน</option>
    		<?php foreach($classrooms as $row):?>
    			<option value="diseases/form2?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=$row->id?>&month=<?=@$_GET['month']?>&year=<?=@$_GET['year']?>" <?=($_GET['classroom_id']==$row->id)?"selected":"";?>><?=$row->room_name?></option>
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
        	<option value="diseases/form2?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=$i?>&year=<?=@$_GET['year']?>" <?=($_GET['month']==$i)?"selected":"";?>><?=$arrayMonth[$i]?></option>
        <?endfor;?>
        </select>
		  
		  พ.ศ. <select name="year" id="room2" style="margin-bottom:5px;" onchange="window.open(this.options[this.selectedIndex].value,'_self')">
	            <option>เลือกปี</option>
	            <?php
	            	$firstYear = (int)date('Y') + 533;
					$lastYear = $firstYear + 20;
					for($i=$firstYear;$i<=$lastYear;$i++):
				?>
					<option value="diseases/form2?nursery_id=<?=@$_GET['nursery_id']?>&classroom_id=<?=@$_GET['classroom_id']?>&month=<?=@$_GET['month']?>&year=<?=$i?>" <?=($_GET['year']==$i)?"selected":"";?>><?=$i?></option>
				<?endfor;?>
	            </select>
  	</td>
  </tr>
<?endif;?>  

</table>
<br />


<?if($_GET['classroom_id'] != ""):?>
<form method="post" action="diseases/save">
	
<div class="outer">
  <div class="inner">
  	
		<table class="table3">
			<?for($i=1;$i<=35;$i++):?>
		  	<colgroup></colgroup>
		  	<?endfor;?>
		  <thead>
			  <tr bgcolor="#cce5fe">
			    <th rowspan="2" align="center"><b>ลำดับ</b></th>
			    <th rowspan="2" align="center"><b>ชื่อ - สกุล เด็ก</b></th>
			  </tr>
			  <tr bgcolor="#cce5fe">
			  	<?for($i=1;$i<=31;$i++):?>
			  	<th align="center" <?=date('j') == $i && date('m') == $_GET['month'] ? "style='background:#A2B1BF'" : "" ;?>><?=$i?></th>
			  	<?endfor;?>
			  </tr>
		  </thead>
		  <tbody>
			  <?foreach($childs as $key=>$row):?>
			  <tr>
			  	<th valign="top" ><?=$key+1?></th>
			    <th><?=$row->title?> <?=$row->child_name?></th>
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
			    <td class="openmodal" href="#myModal" role="button" data-toggle="modal" align="center" title="<?=$row->title?> <?=$row->child_name?> : วันที่ <?=$i?> <?=$arrayMonth[$_GET['month']]?> <?=$_GET['year']?>">
			    	<span class="c<?=$row->id?>_d<?=$i?>">
			    		<?=$disease->c1?><?=$disease->c2?><?=$disease->c3?><?=$disease->c4?><?=$disease->c5?>
			    	</span>
			    	<!-- <?=$sql?>
			    	<?=$disease->id?> -->
			    	<!-- <select name="c1[]" style="margin-bottom:5px;">
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
			    	</select> -->
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
			        <input class="h_nursery_id" type="hidden" name="nursery_id[]" value="<?=$_GET['nursery_id']?>">
			        <input class="h_classroom_id" type="hidden" name="classroom_id[]" value="<?=$_GET['classroom_id']?>">
			        <input class="h_classroom_detail_id" type="hidden" name="classroom_detail_id[]" value="<?=$row->id?>">
			        <input class="h_day" type="hidden" name="day[]" value="<?=$i?>">
			        <input class="h_month" type="hidden" name="month[]" value="<?=$_GET['month']?>">
			        <input class="h_year" type="hidden" name="year[]" value="<?=$_GET['year']?>">
			        <input class="h_id" type="hidden" name="id[]" value="<?=@$disease->id?>">
			        <input class="h_user_id" type="hidden" name="user_id[]" value="<?=user_login()->id?>">
			    </td>
			  	<?endfor;?>
			  </tr>
			  <?endforeach;?>
			  <tr>
		  </tbody>
		</table>
		
	</div>
</div>

<div style="text-align: center; padding:5px;">
	<!-- <input type="submit" value=" บันทึก ">  -->
	<a class="no-print" href="diseases"><input type="button" value=" กลับหน้าหลัก "></a>
	<input class="no-print" type="button" value=" พิมพ์หน้านี้ " onclick="myFunction()">
</div>
</form>

<div style="float: left; width: 550px;">
<h4>หมายเหตุ : สัญลักษณ์ในการบันทึกข้อมูล</h4>
<ol>
	<li>โรคที่พบบ่อย : หวัด = C, มือ เท้า ปาก = H, อุจจาระร่วงเฉียบพลัน = D, ไข้ = F</li>
	<li>การแยกเด็กป่วย : ไม่มีการแยกนอนแยกเล่น = 0, แยกนอน = 1, แยกเล่น = 2</li>
	<li>ไม่มาเรียนให้ทำเครื่องหมาย x หากหยุดเรียนให้ใส่สัญลักษณ์โรค /</li>
	<li>กรณีเด็กได้ยารักษามาจากบ้าน O</li>
	<li>กรณีมีคนที่บ้านป่วยด้วยโรคเดียวกันก่อนเด็กป่วย ให้ทำเครื่องหมาย *</li>
</ol>
</div>

<div style="float: left;">
<p><b>หวัด</b> หมายถึง มีไข้ต่ำๆร่วมกับ น้ำมูกไหล หรือไอ หรือคัดจมูก จาก อาจมีอาการเจ็บคอเล็กน้อย<br><b>มือ เท้า ปาก</b> หมายถึง มีอาการไข้ เบื่ออาหาร อ่อนเพลีย ร่วมกับมีจุดหรือตุ่มแดงอักเสบที่ลิ้น เหงือก และกระพุ้งแก้ม หรือพบตุ่มหรือผื่นนูนหรือตุ่มพองใส บริเวณรอบๆ อักเสบและแดงที่ฝ่ามือฝ่าเท้า<br><b>อุจจาระร่วมเฉียบพลัน</b> หมายถึง มีอาการถ่ายอุจจาระเหลว ตั้งแต่ 3 ครั้งขึ้นไปใน 1 วัน หรือถ่ายมีมูกเลือดอย่างน้อย 1 ครั้ง หรือถ่ายเป็นน้ำจำนวนมากกว่า 1 ครั้งขึ้นไปใน 1 วัน<br><b>ไข้</b> หมายถึง ตัวร้อน อุณหภูมิร่างกายมากกว่าหรือเท่ากับ 37.5&deg;c</p>
<?endif;?>
</div>

<?//=cal_days_in_month(CAL_GREGORIAN, $_GET['month'], $_GET['year']);?>
<?//=date('m')?>


<!-- Modal -->
<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-body" style="height: 500px;">
  	<div>&nbsp;<img class="loader" src="media/images/ajax-loader.gif"></div>
  	<div class="modal-body-form"></div>
  </div>
  <!-- <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">ปิด</button>
    <button class="btn btn-primary">บันทึกข้อมูล</button>
  </div> -->
</div>