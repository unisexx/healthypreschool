<div class="galleries">
	<ul class="breadcrumb">
	  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
	  <li class="active">ภาพกิจกรรม</li>
	</ul>
	<img src="themes/hps/images/title_gallery.png" width="698" height="47">
	<div class="header-bar">
		<h1>ภาพกิจกรรม</h1>
	</div>
	<div class="row" style="padding-bottom:10px;">
		<?php
			foreach ($categories as $category):
		?>
		<div class="span2">
			<a href="galleries/view/<?php echo $category->id?>"><span class="clip_image"></span><?php echo thumb("uploads/albums/".$category->id."/".$category->picture->order_by("id","random")->get()->image,130,90,0,"alt='image' title='$category->name' class='img-polaroid' style='margin-bottom:10px;'");?></a>
            <div class="txtgallery" style="text-align: center;">
            	<?php echo $category->name?><br>
				(<?php echo $category->picture->result_count()?> รูป)
            </div>
		</div>
		<?php endforeach; ?>
	</div>
</div>