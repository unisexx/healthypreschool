<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
	<?php if(!is_login()): ?>
	$("#menu").hide();
	$("#form-body").css('height',$(window).height()-50);
	$(window).resize(function(){
        var h = $(window).height();
        var w = $(window).width();
        $("#form-body").css('height',$(window).height()-50);
    });
	<?php else: ?>
	$("#form-body").css('height',$(window).height()-202);
    $(window).resize(function(){
        var h = $(window).height();
        var w = $(window).width();
        $("#form-body").css('height',$(window).height()-202);
    });
	<?php endif; ?>
});
</script>
<form action="docs/publics/questionaire_save" method="post">
<div class="command">
	<div class="left">
		<h1>แบบสอบถาม - <?php echo $topic->title ?></h1>
	</div>
	<div class="right">
		<input type="submit" value="บันทึก" />
	</div>
	<div class="clear"></div>
</div>
<div id="form-body" style="overflow:auto;" >
	<div class="form-inner">
		<h2>คำชี้แจง</h2>
		<p class="detail"><?php echo nl2br($topic->detail) ?></p>
		<ul id="sortable">
			<?php foreach($topic->questionaire->order_by('sequence')->get() as $key => $question): ?>
			<?php question_form2($question,$key) ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
</form>