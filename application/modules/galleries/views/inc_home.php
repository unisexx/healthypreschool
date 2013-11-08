<script type="text/javascript" src="media/js/jcarousel-0.2.8/lib/jquery.jcarousel.min.js"></script>
<link rel="stylesheet" type="text/css" href="media/js/jcarousel-0.2.8/skins/tango/skin.css" />
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel({
    	wrap: 'circular'
    });
});
</script>
<div id="gallery">
	<img src="themes/hps/images/title_gallery.png" width="698" height="47" /><br>
    <a href="galleries" class="viewGallery"><u>ดูภาพกิจกรรมทั้งหมด</u></a><br clear="all">
<div id="content_gallery">
	  <ul id="mycarousel" class="jcarousel-skin-tango">
	  	<?php foreach($galleries as $row):?>
	  		<li><a rel="lightbox[xxx]" href="uploads/albums/<?=$row->album->id?>/<?=$row->image?>"><?php echo thumb('uploads/albums/'.$row->album->id."/".$row->image,100,80,0,'class="img-polaroid" title="'.$row->title.'" alt="'.$row->title.'"');?></a></li>
	  	<?php endforeach;?>
  </ul>
  </div>
</div>