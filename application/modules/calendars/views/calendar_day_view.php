<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="calendars">ปฏิทินกิจกรรม</a> <span class="divider">/</span></li>
  <li class="active"><?=$day?></li>
</ul>
	
<img src="themes/hps/images/title_calendar.png">

<?php foreach($calendars as $key=>$calendar):?>
	<div class="index-blk">
		<h2><?php echo $calendar->title?></h2>
		<?php echo $calendar->detail ?><br>
		<span>ประเภท: <span class="<?=$calendar->className?>" style="border-radius: 5px; font-size:11px;"><?php echo $type[$calendar->className] ?></span> เริ่ม <span class="label label-warning"><?php echo mysql_to_th($calendar->start) ?></span> ถึง  <span class="label label-warning"><?php echo mysql_to_th($calendar->end) ?></span></span>
	</div>
<?php endforeach;?>