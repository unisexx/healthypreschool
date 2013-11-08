<div id="breadcrumb"><ul><li><a href="home/<?php echo $category->slug ?>"><?php echo $category->name ?></a></li><span>»</span><li><a href="albums/index/<?php echo $category->slug ?>">ภาพกิจกรรม</a></li></ul><div class="clear"></div></div>
<div class="box">
	<h1 class="blue">
		<img src="uploads/icon/head/activity.png" />
		<span>ภาพกิจกรรม</span>
		<div class="corner_left"></div>
		<div class="corner_right"></div>
	</h1>
<div class="view album">
	<ul>
		<?php foreach($albums as $album): ?>
		<li>
			<a href="albums/view/<?php echo $album->id ?>/<?php echo $category->slug ?>">
				<img src="uploads/albums/<?php echo $album->id ?>/thumbnail/<?php echo $album->picture->image ?>" />
				<div><?php echo $album->name ?> <span class="num">(<?php echo $album->picture->count() ?> ภาพ)</span></div>
			</a>
		</li>
		<?php echo alternator('','<div class="clear"></div>') ?>
		<?php endforeach; ?>
		<div class="clear"></div>
	</ul>
	<?php echo $albums->pagination()?>
</div>

</div>