<script type="text/javascript">
$(document).ready(function(){	
	$("#contentVdo").easySlider({
		auto: false,
		continuous: true,
		nextId: "vdonext",
		prevId: "vdoprev"
	});
});
</script>
<div id="vdo">
	<img src="themes/hps/images/title_vdo.png" width="698" height="47" />
	<div id="contentVdo">
        <ul>
           <?php foreach($contents as $row):?>
    			<li>
    				<?=$row->vdo_script?>
    			</li>
    		<?php endforeach;?>
        </ul>
    </div>
	<div id="listVdo">
    	<ul>
    		<?php foreach($contents as $row):?>
    			<li><a href="contents/view/vdos/<?=$row->id?>"><?=$row->title?></a></li>
    		<?php endforeach;?>
		</ul>
    </div><a href="contents/more/vdos" class="btn_readAll">&nbsp;</a>
    <div class="clr"></div><br>
</div>