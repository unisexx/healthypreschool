<script type="text/javascript">
	$(function() {
		<?php if(!is_login()): ?>
			$("#saturday").hide();
	<?php endif; ?>});
</script>
<?
$percent = $topic -> n_answer < 1 || $topic -> n_question < 1 ? 0 : $topic -> n_answer / $topic -> n_question * 100;
?>
<h3>
	ผลการทดสอบ : <?php echo $topic -> title; ?>
</h3>
<div>
	
	<br>
	<div align="center" style="width:100%;padding:50px 0px;text-align:center;border:2px dashed #F4F4F4;background:#fffee6;">	
	<h4>คะแนนของคุณคือ   <?php echo $topic -> score; ?> คะแนน</h4>
	<h4><?php echo $status = $topic -> score >= $topic -> pass ? "ยินดีด้วยค่ะ คุณ <span style=\"color:green;\">ผ่าน</span> การทดสอบครั้งนี้ค่ะ" : "ขอแสดงความเสียใจ คุณ <span style=\"color:red;\">ไม่ผ่าน</span>  การทดสอบครั้งนี้ค่ะ"; ?></h4>
	</div>	
</div>
<br>
<div align="center">
<?php
if ($topic -> score < $topic -> pass) {
	echo '<a href="elearnings/reset/' . $topic -> topic_id . '" class="btn btn-small btn-danger">ทำใหม่อีกครั้ง</a>';
}
echo '<a href="elearnings/testing_index" class="btn btn-small btn-primary">กลับไปหน้ารายการ</a>';
?>
</div>