<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="calendars">ปฎิทินกิจกรรม</a> <span class="divider">/</span></li>
  <li class="active"><?php echo $calendar->title?></li>
</ul>

<img src="themes/hps/images/title_calendar.png">

		<h2><?php echo $calendar->title?></h2>
		<?php echo $calendar->detail ?><br>
		<span>ประเภท: <span class="<?=$calendar->className?>" style="border-radius: 5px; font-size:11px;"><?php echo $type ?></span> เริ่ม <span class="label label-warning"><?php echo mysql_to_th($calendar->start) ?></span> ถึง <span class="label label-warning"> <?php echo mysql_to_th($calendar->end) ?></span>
		<?php echo $calendar->detail ?>