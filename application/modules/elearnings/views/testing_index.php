<script type="text/javascript">
	$(function() {<?php if(!is_login()): ?>$("#saturday").hide();<?php endif; ?>});</script>
<ul class="breadcrumb">
	<li>
		<a href="home">หน้าแรก</a><span class="divider">/</span>
	</li>
	<li class="active">
		แบบทดสอบ E-learning
	</li>
</ul>
<table class="table table-bordered table-hover">
	<tr>
		<th style="text-align:center;background:#fffee6;">แบบทดสอบ</th>
		<th style="text-align:center;background:#fffee6;">จำนวนข้อที่ทำ</th>
		<th style="text-align:center;background:#fffee6;">คะแนนที่ได้</th>
		<th style="text-align:center;background:#fffee6;">ผลการทดสอบ</th>
		<th></th>
	</tr>
	<?php foreach($topics as $topic):
	?>
	<tr <?php echo cycle() ?>>
		<td><?php echo $topic->title
		?></td>
		<td style="text-align:center;"><?php
			if ($topic -> n_answer > 0) {echo $topic -> n_answer . '/' . $topic -> n_question;
			} else {echo 'รอการทดสอบ';
			}
		?></td>
		<td style="text-align:center;"><?php
		if ($topic -> n_answer == $topic -> n_question) {
			echo $topic -> score;
		} else {
			echo 'รอการทดสอบ';
		}
		?></td>
		<td style="text-align:center;"><?php
		if ($topic -> n_answer == $topic -> n_question) {

			echo $status = $topic -> score >= $topic -> pass ? "ผ่าน" : "ไม่ผ่าน";
		} else {
			echo 'รอการทดสอบ';
		}
		?></td>
		<td style="text-align:center;"><?php if($topic->set_final == 0 || ($topic->set_final == 1 && $pass_all_status == TRUE)){
		?>
		<?php
if($topic->n_answer == $topic->n_question && $topic->score < $topic->pass){
		?>
		<a href="elearnings/reset/<?php echo $topic -> topic_id; ?>" class="btn btn-small btn-danger">ทำใหม่อีกครั้ง</a><?php }else if($topic->n_answer != $topic->n_question && $topic->n_answer > 0){ ?>
		<a href="elearnings/testing/<?php echo $topic -> topic_id; ?>" class="btn btn-small btn-info">ทำแบบทดสอบต่อ</a><?php } ?>
		<?php if($topic->n_answer < 1){
		?>
		<a href="elearnings/testing/<?php echo $topic -> topic_id; ?>" class="btn btn-small btn-primary">เริ่มทำแบบทดสอบ</a><?php } ?>
		<?php } ?></td>
	</tr>
	<?php endforeach; ?>
</table>
<div align="center" style="color:red;">
	*** ผู้ทำแบบทดสอบจะต้องทำแบบทดสอบระหว่างเรียน ผ่านทั้งหมด จึงจะทำแบบทดสอบท้ายบทเรียนได้ ***
</div>
<hr>
<?php if($pass_final_status == TRUE){ ?>
<div style="margin:0 auto;width:100%;padding:10px 15px;text-align:center;">
	<h4>คุณทำแบบทดสอบหลังเรียนผ่านแล้ว  สามารถพิมพ์ใบประกาศนียบัตรได้ที่ปุ่มด้านล่าง</h4>	
	<a href="elearnings/cert" target="_blank" class="btn btn-large btn-success">พิมพ์ใบประกาศนียบัตร</a>
</div>
<?php } ?>
