<!-- Load TinyMCE -->
<script type="text/javascript" src="media/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="media/tiny_mce/config.js"></script>
<script type="text/javascript">
	tiny('detail');
	
	$(document).ready(function(){
		var formId = $("#form-id").val() - 2;
		$("#horri_menu ul li:eq("+formId+")").addClass("active");
		
		$(".addpage").click(function(){
	        var $tr    = $(this).closest("tr").next("tr");
	        var $clone = $tr.clone();
	        $clone.find(':text').val('');
	        $clone.find('input[type=hidden]').val('');
	        $clone.find('span').hide();
	        $(".form tr:last").before($clone);
	    });
	    
	    $(".delfile").click(function(){
	        var ans = confirm("ต้องการลบไฟล์นี้");
	        if(ans){
	            var id = $(this).closest('tr').find("input[type=hidden]").val();
	            $.post('contents/admin/contents/delfile', {
	                "id":id
	            });
	            $(this).closest("tr").fadeOut();
	        }
	    });
	});
</script>
<h1>เกี่ยวกับองค์กร</h1>
<?php include "_menu.php";?>

<table class="list">
	<tr>
		<th>รายละเอียด
	</tr>
</table>
<br>
<form method="post" action="abouts/admin/abouts/save/<?php echo $this->uri->segment(5)?>" id="frm">
<table class="form tab">
	<tr>
	<tr><td></td></tr>
	<tr>
		<td>
		<div><textarea name="detail" class="full tinymce"><?php echo $about->detail?></textarea></div>
		</td>
	</tr>
	<tr>
        <td><input class="addpage" type="button" value=" เพิ่มไฟล์แนบ "/></td>
    </tr>
	<?php if($about->id):?>
    <?php foreach($attachs as $row):?>
        <tr>
            <td>
                <input type="hidden" name="attach_id[]" value="<?=$row->id?>">
                <input type="text" name="file_name[]" placeholder="ชื่อไฟล์" value="<?=$row->file_name?>">
                <input type="text" name="file[]" placeholder="ไฟล์แนบ" value="<?=$row->file?>"/><input type="button" name="browse" value="เลือกไฟล์" onclick="browser($(this).prev(),'files')" />
                <span class="btn delfile">x</span>
            </td>
        </tr>
    <?php endforeach;?>
    <?php endif;?>
	<tr>
		<td>
		    <input type="text" name="file_name[]" placeholder="ชื่อไฟล์" value="">
		    <input type="text" name="file[]" placeholder="ไฟล์แนบ" value=""/><input type="button" name="browse" value="เลือกไฟล์" onclick="browser($(this).prev(),'files')" />
		</td>
	</tr>
	<tr>
		<td>
			<input id="form-id" type="hidden" name="id" value="<?php echo $this->uri->segment(5)?>">
			<?php if(permission('abouts', 'update')):?>
				<?php echo form_submit('',lang('btn_submit'))?>
			<?php endif;?>
		</td>
	</tr>
</table>
</form>