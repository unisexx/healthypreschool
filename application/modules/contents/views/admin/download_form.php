<!-- Load TinyMCE -->
<script type="text/javascript" src="media/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript" src="media/tiny_mce/config.js"></script>
<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
<script type="text/javascript">
tiny('detail');
$(document).ready(function(){
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
<h1><?=$type_name?></h1>
<form id="frmMain" action="contents/admin/contents/save/<?=$type?>/<?php echo $content->id ?>" method="post" enctype="multipart/form-data" >
	
<table class="form">
	<!-- <tr>
		<th></th>
		<td>
			<?php if($content->image != ""):?><?php echo thumb("uploads/content/".$content->image,115,77,1);?><?php endif;?>
		</td>
	</tr>
	<tr><th>รูปภาพ :</th><td><input type="file" name="image" /></td></tr>
	<?php if($type == 'inspect' or $type == 'project' or $type == 'outstand' or $type == 'pratice' or $type == 'meeting' or $type == 'seat' or $type == 'inspect_int' or $type == 'stat' or $type == 'support' or $type == 'km'):?>
	<tr><th>หมวดหมู่ :</th><td><?php echo form_dropdown('category_id',$content->category->get_option(),$content->category_id,'');?></td></tr>
	<?php endif;?> -->
	<tr>
		<th>หัวข้อ :</th>
		<td>
			<input type="text" name="title" rel="th" value="<?php echo lang_decode($content->title,'th')?>" class="input-xxlarge" />
		</td>
	</tr>
	<!-- <tr>
		<th>รายละเอียด :</th>
		<td>
			<div rel="th"><textarea name="detail" class="full tinymce"><?php echo lang_decode($content->detail,'th')?></textarea></div>
		</td>
	</tr>
	<tr>
        <th></th>
        <td><input class="addpage" type="button" value=" เพิ่มไฟล์แนบ "/></td>
    </tr> -->
    <!-- <?php if($content->id):?>
    <?php foreach($attachs as $row):?>
        <tr>
            <th>ไฟล์แนบ :</th>
            <td>
                <input type="hidden" name="attach_id[]" value="<?=$row->id?>">
                <input type="text" name="file_name[]" placeholder="ชื่อไฟล์" value="<?=$row->file_name?>">
                <input type="text" name="file[]" value="<?=$row->file?>"/><input type="button" name="browse" value="เลือกไฟล์" onclick="browser($(this).prev(),'files')" />
                <span class="btn delfile">x</span>
            </td>
        </tr>
    <?php endforeach;?>
    <?php endif;?> -->
	<tr>
		<th>ไฟล์แนบ :</th>
		<td>
		    <!-- <input type="text" name="file_name[]" placeholder="ชื่อไฟล์" value=""> -->
		    <div class="input-append">
		    <input type="hidden" name="attach_id[]" value="<?=@$row->id?>">
		    <input class="input-xxlarge" type="text" name="file[]" value="<?=@$attachs->file?>"/> <input class="btn" type="button" name="browse" value="เลือกไฟล์" onclick="browser($(this).prev(),'files')" />
		    </div>
		</td>
	</tr>
	<tr><th></th><td><input class="btn btn-primary" type="submit" value="บันทึก" /> <?php echo form_back() ?></td></tr>
</table>
<?php echo form_referer() ?>
</form>