<script type="text/javascript">
	$(function() {
	hide_preload();	
	<?php if(!is_login()): ?>
			$("#saturday").hide();
	<?php endif; ?>
		$("#btn_save").click(function(){
		  //show_preload();			
		});
	});
	function hide_preload(){
		$("#loader-wrapper").hide();
	}
	function show_preload(){
		$("#loader-wrapper").show();
	}
</script>
<form method="post" enctype="multipart/form-data" onsubmit="return confirm('ยืนยันคำตอบ?')" action="elearnings/testing_save_all/<?php echo $topic->topic_id;?>">
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span> <a href="elearnings">E-Learning</a></li>
  <li class="active">/ <?php echo $topic -> title; ?></li>
</ul>
<?
$percent = $topic -> n_answer < 1 || $topic -> n_question < 1 ? 0 : $topic -> n_answer / $topic -> n_question * 100;
?>
<h3>
	<?php echo $topic -> title; ?>
</h3>
<?php
    $i=0; 
    foreach($question as $q):
        $i++;
?>
<div id="dv_question">
	<div align="center" style="width:100%;padding:10px 0px;padding-left:5px;text-align:left;border:2px dashed #F4F4F4;background:#fffee6;">
		<h4 style="padding-left:20px;font-size:14px !important;">
		    ข้อที่ <?php echo $i; ?>. <?php echo $q -> question; ?>
		  <input type="hidden" name="question_id[]" value="<?php echo $q -> id; ?>"> 
		</h4>
			<ul>
				<? 
				$answers = $this -> db -> query("select * from question_choices WHERE questionaire_id = " . $q -> id . " ORDER BY RAND() ") -> result();
				foreach($answers as $answer): 
				?>
				<li style="list-style-type: none;">
					<input type="radio" required="required" name="<?php echo $q->id;?>_answer_id" value="<?php echo $answer -> id; ?>"><?php echo $answer -> name; ?>			
				</li>
				<? endforeach; ?>
			</ul>
	</div>	
</div>
<?php endforeach;?>
<br>
<div style="margin:0 auto;" align="center">
    <input type="hidden" name="topic_id" value="<?php echo $topic->topic_id;?>">
    <input type="submit" id="btn_save" class='btn btn-primary' value="ยืนยันคำตอบ">
    <a href="elearnings/testing_index" onclick="return confirm('กลับไปหน้ารายการทดสอบ?')" class="btn btn-default">ย้อนกลับ</a>
</div>
</form>
<div id="loader-wrapper">
	<div id="loader">
		<ul class="spinner">
		    <li></li>
		    <li></li>
		    <li></li>
		    <li></li>
		</ul>
	</div>
</div>