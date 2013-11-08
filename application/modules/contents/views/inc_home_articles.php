<div id="article">
	<img src="themes/hps/images/title_article.png" width="698" height="47" />
	<div id="content_article">
		<ul>
	  	<?php foreach($contents as $row):?>
	  		<li><a href="contents/view/articles/<?=$row->id?>"><?=$row->title?></a></li>
	  	<?php endforeach;?>
		</ul>
	</div>
</div><a href="contents/more/articles" class="btn_readAll">&nbsp;</a>
<div class="clr"></div><br>