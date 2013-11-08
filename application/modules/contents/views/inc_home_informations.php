<div id="news">
    <img src="themes/hps/images/title_news.png" width="698" height="47" /> 
    <div id="contentNews">
    	<?php foreach($contents as $key=>$row):?>
    		<?php if($key == 0):?>
    			<a href="contents/view/informations/<?=$row->id?>"><?=thumb('uploads/content/'.$row->image,153,108,1,'class="imgNews"')?> <span class="textNews"><?=$row->title?></span></a>
	    <p><?=strip_tags($row->detail)?></p>
	    	<ul class="listNews">
    		<?php else:?>
	            <li><a href="contents/view/informations/<?=$row->id?>"><span class="date"><?=mysql_to_th($row->created)?></span> <?=$row->title?></a></li>
    		<?php endif;?>
    	<?php endforeach;?>
        	</ul>
     </div>
  <a href="contents/more/informations" class="btn_readAll">&nbsp;</a></div>
<div class="clr"></div><br>