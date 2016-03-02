<script type="text/javascript" src="media/js/easyslider1.7/js/easySlider1.7.js"></script>
<link href="media/js/easyslider1.7/css/screen.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript">
$(document).ready(function(){	
	$("#slider").easySlider({
		auto: true, 
		numeric: true,
		numericId: 'controls',
		continuous: true,
		speed: 800,
		pause: 5000
	});
});
</script>

<div id="slider" style="margin-left: 5px;">
	<ul>
		<?php foreach($hilights as $key=>$hilight):?>
			<li>
				<div>
					<a href="<?=$hilight->url?>" target="_blank">
						<?php echo thumb("uploads/hilight/".$hilight->image,710,211,0)?>
					</a>
					<div class="clear"></div>
				</div>
			</li>
		<?php endforeach;?>		
	</ul>
</div>