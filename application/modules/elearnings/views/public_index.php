<script type="text/javascript">
$(function() {
		<?php if(!is_login()): ?>
	$("#saturday").hide();
	<?php endif; ?>


});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">E-learning</li>
</ul>
<table class="table">
	<tr>
		<th>แบบทดสอบ</th>
		<th>จำนวนข้อที่ทำ</th>
		<!-- <th>กลุ่มงาน</th> -->
		<th>คะแนนที่ได้</th>
		<th style="text-align:center;">ผลการทดสอบ</th>
		<th></th>
	</tr>
	<?php foreach($topics as $topic): ?>
	<tr <?php echo cycle() ?>>
		<td>
			<?php echo $topic->title ?>
		</td>
		<td>
			<?php if($topic->n_answer > 0){echo $topic->n_answer.'/'.$topic->n_question;}else{echo 'รอการทดสอบ';}?>
		</td>
		<td>
			<?php 
				if($topic->n_answer == $topic->n_question)
				{
					echo $topic->score;
				}else{
					echo 'รอการทดสอบ';
				}
			?>
		</td>
		<td style="text-align:center;">
			<?php 
				if($topic->n_answer == $topic->n_question)
				{
					
					echo  $status = $topic->score >= $topic->pass ? "ผ่าน" : "ไม่ผ่าน";
				}else{
					echo 'รอการทดสอบ';
				}
			?>
		</td>
		<td>
			<?php
			if($topic->n_answer == $topic->n_question && $topic->score < $topic->pass){
			?>
			<a href="elearnings/reset/<?php echo $topic->topic_id;?>" class="btn btn-small btn-danger">ทำใหม่อีกครั้ง</a>
			<?php }else if($topic->n_answer != $topic->n_question && $topic->n_answer > 0){ ?>
			<a href="elearnings/testing/<?php echo $topic->topic_id;?>" class="btn btn-small btn-info">ทำแบบทดสอบต่อ</a>
			<?php } ?> 
			<?php if($topic->n_answer < 1){ ?>
			<a href="elearnings/testing/<?php echo $topic->topic_id;?>" class="btn btn-small btn-primary">เริ่มทำแบบทดสอบ</a>
			<?php } ?>
		</td>
	</tr>
	<?php endforeach; ?>
</table>
<a href="#"class="btn btn-large btn-success">พิมพ์ใบประกาศนียบัตร</a>
