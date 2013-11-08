<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="contents/more/<?=$type?>"><?=$type_name?></a> <span class="divider">/</span></li>
  <li class="active"><?=$content->title?></li>
</ul>
<?=$header_img?>
<h1><?=lang_decode($content->title)?></h1>
<div style="text-align: center; margin:15px auto;"><img src="uploads/content/<?=$content->image?>"></div>
<div><?=$content->detail?></div>
