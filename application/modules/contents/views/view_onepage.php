<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><?=$type_name?></li>
</ul>
<h1><?=lang_decode($content->title)?></h1>
<?php if($content->image != ""):?>
	<div style="text-align: center; margin:15px auto;"><img src="uploads/content/<?=$content->image?>"></div>
<?php endif;?>
<div><?=$content->detail?></div>