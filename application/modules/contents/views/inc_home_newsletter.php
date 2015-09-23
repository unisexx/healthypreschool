<div id="vdo">
	<img src="themes/hps/images/title_situation.png" width="698" height="47" />
	<div id="contentNews">
    	<ul class="listNews">
    		<?php foreach($contents as $row):?>
    			<li><a href="contents/view/informations/<?=$row->id?>" target="_blank"><span class="date"><?=mysql_to_th($row->created)?></span> <?=$row->title?></a></li>
    		<?php endforeach;?>
		</ul>
    </div><a href="contents/more/newsletters" class="btn_readAll">&nbsp;</a>
    <div class="clr"></div><br>
</div>