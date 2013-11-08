				<div class="gallery box">
					<h1 class="blue">
						<img src="themes/default/images/icon/activity.png" />
						<span>ภาพกิจกรรม</span>
						<a class="more" href="albums/index/<?php echo $slug ?>">ดูทั้งหมด</a>
						<div class="corner_left"></div>
						<div class="corner_right"></div>
					</h1>
					<ul>
						<?php foreach($albums as $album): ?>
						<li>
						<a href="albums/view/<?php echo $album->id ?>/<?php echo $slug ?>">
						<img src="uploads/albums/<?php echo $album->id ?>/thumbnail/<?php echo $album->picture->image ?>" />
						<h2><?php echo $album->name ?></h2>
						</a>
						</li>  
						<?php endforeach; ?>
						<div class="clear"></div>
					</ul>
				</div>