<div id="breadcrumb"><ul><li><a href="">หน้าแรก</a></li><span>»</span><li><a href="albums">ภาพกิจกรรม</a></li></ul><div class="clear"></div></div>

<h1 class="icon activity">ภาพกิจกรรม<span></span></h1>
<div class="box">
<div class="view album">
	<ul>
		<?php foreach($category_albums as $category_album): ?>
		<li>
			<a href="albums/index/<?php echo $category_album->id ?>">
				<img src="uploads/albums/<?php echo $category_album->album->id ?>/thumbnail/<?php echo $category_album->album->picture->image ?>" />
				<div><?php echo $category_album->name ?> <span class="num">(<?php echo $category_album->album->count() ?> อัลบั้ม)</span></div>
			</a>
		</li>
		<?php echo alternator('','<div class="clear"></div>') ?>
		<?php endforeach; ?>
		<div class="clear"></div>
	</ul>
	<?php echo $category_albums->pagination()?>
</div>

</div>