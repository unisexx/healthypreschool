<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><?=$type_name?></li>
</ul>
<?=$header_img?>
<?php foreach($contents as $key=>$row):?>
	<a href="contents/view/informations/<?=$row->id?>">
		<div class="index-blk">		
			<?=thumb('uploads/content/'.$row->image,153,108,1,'class="imgNews"')?> <span class="textNews"><?=$row->title?></span>
	    	<p><?=strip_tags($row->detail)?></p>
	    </div>
    </a>
<?php endforeach;?>
<?php echo $contents->pagination();?>