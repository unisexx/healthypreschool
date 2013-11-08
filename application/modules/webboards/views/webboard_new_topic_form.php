<style type="text/css">
table.form td {
padding:5px;
}
table.form th {
padding:5px;
text-align:right;
vertical-align:middle;
white-space:nowrap;
}
table.form th.top {
vertical-align:top;
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
width:840px;
}
table.form .img {
border:1px solid #CCCCCC;
}
table.form td .cirkuitSkin td.mceToolbar {
padding:1px 0 2px;
}
</style>

<script type="text/javascript">
	$(function(){
		$('.addvote').click(function(){
			$('<tr><th></th><td>ตัวเลือก : <input type="text" name="name[]" class="text small" /></td></tr>').insertBefore($('.textarea'));
			return false;
		});
	});
</script>

<!-- Load TinyMCE -->
<script type="text/javascript" src="media/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="media/tiny_mce/tinymce.js"></script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="webboards">เว็บบอร์ด</a> <span class="divider">/</span></li>
  <li><a href="webboards/category/<?php echo $categories->id?>"><?php echo lang_decode($categories->name,'')?></a> <span class="divider">/</span></li>
  <li class="active">ตั้งกระทู้ใหม่</li>
</ul>


<div id="webboardpage">
	<h1>ตั้งกระทู้ใหม่</h1>
	<div id="data">
				<form id="frm-post" action="webboards/save/<?php echo $categories->id?>/<?php echo $webboard_quizs->id?>" method="post">
					<table class="form">
						<tr>
							<th>หัวข้อ :</th>
							<td><?php echo form_input('title',$webboard_quizs->title,'style="width:400px;"')?>
							<?php if($topic_type == 'vote'):?>
							<input class="btn addvote" type="button" value="+ เพิ่มตัวเลือกโหวต"></td>
							<?php endif;?>
						</tr>
						<?php if($topic_type == 'vote'):?>
						
						<?php foreach($webboard_quizs->webboard_polldetail as $item): ?>
						<tr><th></th><td>ตัวเลือก : <input type="text" name="name[]" value="<?php echo $item->name ?>" class="text small" /> <a class="btn" href="webboards/delete_poll_choice/<?php echo $item->id?>" class="btn" onclick="return confirm('ต้องการลบตัวเลือกนี้?')">ลบ</a><input type="hidden" name="detail_id[]" value="<?php echo $item->id ?>" /></td></tr>
						<?php endforeach; ?>
			
						<tr><th></th><td>ตัวเลือก : <input type="text" name="name[]" class="text small" /></td></tr>
						<?php endif;?>
						<tr>
							<th></th>
							<td>
								<?php echo uppic_mce();?>
							</td>
						</tr>
						<tr class="textarea">
							<th class="top">เนื้อหา :</th>
							<td>
								<textarea name="detail" cols="20" class="editor[pm]"><?php echo $webboard_quizs->detail?></textarea>
								<?php echo form_hidden('webboard_category_id',$categories->id)?>
								<?php echo form_hidden('type',$topic_type)?>
							</td>
						</tr>
						<?php if(empty($item)): ?>
						<tr><th>ชื่อ :</th><td><input type="text" name="author" class="textbox" <?php echo (is_login()) ? 'value="'.user()->name.'" readonly' : null ?> > 
					    <?php else: echo form_hidden('author', $item->author); ?>
					    <?php endif; ?>
						</td></tr>
						<tr><th></th><td><img src="users/captcha" /> </td></tr>
						<tr><th>รหัสลับ :</th><td><input type="text" name="captcha" class="input-small"> </td></tr>
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
                title: {required: true },
                author: { required: true },
                captcha: { required: true, remote: "users/check_captcha" }
            },
            messages:
            {
                title: { required: "กรุณากรอกหัวข้อค่ะ" },
                author: { required: "กรุณากรอกชื่อค่ะ" },
                captcha: { required: "กรุณากรอกตัวอักษรตัวที่เห็นในภาพค่ะ", remote: "กรุณากรอกตัวอักษรให้ตรงกับภาพค่ะ" }
            }
        });
    });
</script>