<div class="galleries">
	<ul class="breadcrumb">
	  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
	  <li><a href="galleries">ภาพกิจกรรม</a> <span class="divider">/</span></li>
	  <li class="active"><?=$galleries->album->name?></li>
	</ul>
	<img src="themes/hps/images/title_gallery.png" width="698" height="47">
	<div class="header-bar">
		<h1><?=$galleries->album->name?></h1>
	</div>
	<div id="boxphoto" class="row">
			<?php foreach ($galleries as $gallery):?>
			<div class="span2" style="margin-bottom: 5px;">
				<a rel="lightbox[xxx]" href="uploads/albums/<?=$gallery->album->id?>/<?=$gallery->image?>"><?php echo thumb('uploads/albums/'.$gallery->album->id."/".$gallery->image,130,90,0,'style="" class="img-polaroid" title="'.$gallery->title.'" alt="'.$gallery->title.'"');?></a>
	            <div class="txtgallery" style="text-align: center;"><?php echo $gallery->title?></div>
			</div>
			<?php endforeach;?>
		<div class="clear"></div>
		<?php echo $galleries->pagination()?>
	</div>
</div>