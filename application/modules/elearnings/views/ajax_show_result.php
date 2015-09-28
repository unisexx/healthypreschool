<script type="text/javascript">
$(function() {
		<?php if(!is_login()): ?>
	$("#saturday").hide();
	<?php endif; ?>

});
</script>
<?
$percent = $topic->n_answer < 1  || $topic->n_question < 1 ? 0 : $topic->n_answer / $topic->n_question * 100;
?>
<h3>
	ผลการทดสอบ 
</h3>
<div>
	<h4>คะแนนของคุณคือ   <?php echo $topic->score;?> คะแนน</h4>
	<h4><?php echo  $status = $topic->score >= $topic->pass ? "ผ่าน" : "ไม่ผ่าน";?></h4>	
</div>
<div align="center">
<?php
if($topic->score < $topic->pass)
{
	echo '<a href="elearnings/reset/'.$topic->topic_id.'" class="btn btn-small btn-danger">ทำใหม่อีกครั้ง</a>';
}
	echo '<a href="elearnings/index" class="btn btn-small btn-primary">กลับไปหน้ารายการ</a>';
?>
</div>