<style type="text/css">
table.form td {
padding:5px;
}
table.form th {
padding:5px;
text-align:right;
vertical-align:middle;
font-weight:bold;
white-space:nowrap;
}
table.form th.top {
vertical-align:top;
}
table.form input[type="text"], table.form input[type="password"] {
width:250px;
}
table.form select {
width:250px;
}
table.form textarea {
height:100px;
width:250px;
}
table.form input.full[type="text"] {
width:500px;
}
table.form textarea.full {
width:550px;
}
table.form .img {
border:1px solid #CCCCCC;
}
table.form td .cirkuitSkin td.mceToolbar {
padding:1px 0 2px;
}
</style>
<!-- Load TinyMCE -->
<script type="text/javascript" src="media/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="media/tiny_mce/tinymce.js"></script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="webboards">เว็บบอร์ด</a> <span class="divider">/</span></li>
  <li><a href="webboards/category/<?php echo $webboard_quiz->webboard_category_id?>"><?php echo $webboard_quiz->webboard_category->name?></a> <span class="divider">/</span></li>
  <li><a href="webboards/view_topic/<?php echo $webboard_quiz->id?>"><?php echo $webboard_quiz->title?></a> <span class="divider">/</span></li>
  <li class="active">แสดงความเห็น/ตอบกระทู้</li>
</ul>

<div id="webboardpage">
	<h1>แสดงความเห็น/ตอบกระทู้</h1>
	<div id="data">
				<form id="frm-post" action="webboards/save_reply/<?php echo $webboard_quiz->id?>/<?php echo $webboard_answer->id?>/<?php echo $type?>" method="post" enctype="multipart/form-data">
					<table class="form">
						<tr>
							<th>RE :</th>
							<td><strong><?php echo $webboard_quiz->title?></strong></td>
						</tr>
						<tr>
							<th></th>
							<td>
								<?php echo uppic_mce();?>
							</td>
						</tr>
						<tr>
							<th class="top"></th>
							<td>
								<textarea name="detail" class="full editor[pm]">
									<?php if ($quote_id == 0):?>
									<div><b><?php echo $webboard_quiz->user->display?> พิมพ์ว่า:</b></div>
									<div style="border:1px solid #000; width:90%; background:#eee; padding:5px;"><?php echo $webboard_quiz->detail?></div><br><br>
									<?php elseif ($quote_id > 0 && $type == "quote"):?>
									<div><b><?php echo $webboard_answer->user->display?> พิมพ์ว่า:</b></div>
									<div style="border:1px solid #000; width:90%; background:#eee; padding:5px;"><?php echo $webboard_answer->detail;?></div><br><br>
									<?php elseif ($quote_id > 0 && $type == "edit"):?>
									<?php echo $webboard_answer->detail;?>
									<?php endif;?>
								</textarea>
							</td>
						</tr>
						<?php if(empty($webboard_answer->id)): ?>
                        <tr><th>ชื่อ :</th><td><input type="text" name="author" class="textbox" <?php echo (is_login()) ? 'value="'.user()->name.'" readonly' : null ?> > 
                        <?php else: echo form_hidden('author', $webboard_answer->author); ?>
                        <?php endif; ?>
						<tr>
							<td><?php echo form_hidden('webboard_category_id',$webboard_quiz->webboard_category_id)?></td>
						</tr>
						<tr><th></th><td><img src="users/captcha" /> </td></tr>
						<tr><th>Captcha :</th><td><input type="text" name="captcha" class="textbox"> </td></tr>
						<tr><th></th><td><input type="submit" value="บันทึก"></td></tr>
					</table>
				</form>
	</div>
</div>
<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script language="javascript">
    $(function(){
        $("#frm-post").validate({
            rules: 
            {
                author: { required: true },
                captcha: { required: true, remote: "users/check_captcha" }
            },
            messages:
            {
                author: { required: "กรุณากรอกชื่อค่ะ" },
                captcha: { required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพค่ะ", remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพค่ะ" }
            }
        });
    });
</script>