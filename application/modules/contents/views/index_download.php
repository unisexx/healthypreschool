<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active"><?=$type_name?></li>
</ul>
<h1>เอกสารดาวน์โหลด</h1>
<?php foreach($contents as $key=>$row):?>
	<ul>
		<li><a href="contents/download/<?=$row->attach->id?>"><span class="textNews"><?=$row->title?></span></a></li>
	</ul>
<?php endforeach;?>
<?php echo $contents->pagination();?>