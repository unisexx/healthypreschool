<script type="text/javascript">
$(function() {
		<?php if(!is_login()): ?>
	$("#saturday").hide();
	<?php endif; ?>

	$("#btn_save").click(function(){
		var selected_value = $('input[name=answer_id]:checked', 'body').val();
		var question_id = $('input[name=question_id]').val();
		var topic_id = $('input[name=topic_id]').val();
		if(selected_value){
			$.post('elearnings/save',{
				'topic_id' : topic_id,
				'question_id' : question_id,
				'answer_id' : selected_value,
			},function(data){
				$("#dv_question").html(data);												
			});	
		}else{
			alert('กรุณาเลือกคำตอบ');
		}
	})
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span> <a href="elearnings">E-Learning</a></li>
  <li class="active">/ <?php echo $topic->title;?></li>
</ul>
<?
$percent = $topic->n_answer < 1  || $topic->n_question < 1 ? 0 : $topic->n_answer / $topic->n_question * 100;
?>
<h3>
	<?php echo $topic->title;?>
</h3>
<div id="dv_question">
	<div class="progress progress-success progress-striped">
	  <div class="bar" style="width: <?php echo number_format($percent,0);?>%">
	  	<?php echo number_format($topic->n_answer,0);?> / <? echo number_format($topic->n_question,0);?>
	  </div>
	</div>
	<div align="center" style="width:100%;padding:10px 0px;padding-left:5px;text-align:left;border:2px dashed #F4F4F4;background:#fffee6;">
		<h4 style="padding-left:20px;">ข้อที่ <?php echo $topic->n_answer+1;?>. <?php echo $question->question;?></h4>
			<ul>
				<? foreach($answers as $answer): ?>
				<li>
					<input type="radio" name="answer_id" value="<?php echo $answer->id;?>"><?php echo $answer->name;?>			
				</li>
				<? endforeach;?>
			</ul>
	</div>
	<br>
	<div align="center" style="color:red;">*** สำหรับผู้ทดสอบ สามารถ ปิดหน้าเว็บไซต์ และกลับมาทำแบบทดสอบในครั้งต่อไปได้ จนกว่าจะผ่านแบบทดสอบ  ***</div>
	<br>
	<div style="margin:0 auto;" align="center">
		<input type="hidden" name="question_id" value="<?php echo $question->id;?>">
		<input type="hidden" name="topic_id" value="<?php echo $topic->topic_id;?>">
		<input type="button" id="btn_save" class='btn btn-primary' value="ยืนยันคำตอบ">
	</div>
</div>