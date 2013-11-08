<div id="breadcrumb"><ul>
	<li><a href="home/<?php echo $theme->slug ?>"><?php echo $theme->name ?></a></li><span>»</span>
	<li><a href="albums/index/<?php echo $theme->slug ?>">ภาพกิจกรรม</a></li><span>»</span>
	<li><a href="albums/view/<?php echo $album->id ?>"><?php echo $album->name ?></a></li>
	</ul>
	<div class="clear"></div>
</div>
<div class="box">
	<h1 class="blue">
		<img src="uploads/icon/head/activity.png" />
		<span><?php echo $album->name ?></span>
		<div class="corner_left"></div>
		<div class="corner_right"></div>
	</h1>
<div class="view album">
	<ul>
		<?php foreach($album->picture as $picture): ?>
		<li>
			<a href="uploads/albums/<?php echo $album->id ?>/<?php echo $picture->image ?>" rel="lightbox[album]">
				<img src="uploads/albums/<?php echo $album->id ?>/thumbnail/<?php echo $picture->image ?>" />
			</a>
		</li>
		<?php echo alternator('','<div class="clear"></div>') ?>
		<?php endforeach; ?>
		<div class="clear"></div>
	</ul>
</div>

</div>