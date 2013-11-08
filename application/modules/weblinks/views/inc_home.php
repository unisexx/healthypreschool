<div class="weblink-blg">
	<div id="icon_link"></div>
    <ul class="menu">
    	<?php foreach($weblinks as $row):?>
		<li><a href="<?=$row->url?>" target="_blank"><?=lang_decode($row->title,'th')?></a></li>
  		<?php endforeach;?>
  	</ul>
  	<br clear="all">
</div>