<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><?=$type_name?></li>
</ul>
<?=$header_img?>
<?php foreach($contents as $key=>$row):?>
	<a href="contents/view/vdos/<?=$row->id?>">
		<div class="span2 vid-blklist">		
			<?=YoutubeIframe2Thumb($row->vdo_script,140,120)?> <span class="textNews"><?=$row->title?></span>
	    </div>
    </a>
<?php endforeach;?>
<?php echo $contents->pagination();?>