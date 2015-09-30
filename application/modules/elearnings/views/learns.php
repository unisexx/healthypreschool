<script type="text/javascript">
$(function() {
		<?php if(!is_login()): ?>
	$("#saturday").hide();
	<?php endif; ?>
});
</script>
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">บทเรียน E-learning</li>
</ul>

<iframe name="FRAME2" src="<?=base_url();?>media/swf/flash_content.html" frameborder="0" width="760" height="570"></iframe>