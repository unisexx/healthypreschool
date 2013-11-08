<?php foreach($polls as $poll): ?>
<div class="poll-text"><?php echo $poll->name ?></div>
<div class="poll-bar progress" style="height: 10px; background:#E9E9E9; margin-bottom:0px;"><div class="poll-foreground bar bar-danger" style="height:10px; width:<?php echo $poll->percent ?>%;"></div></div>
<div class="poll-percent"><span style="float:left;"><?php echo $poll->num ?> คน</span><?php echo $poll->percent ?>%</div>
<?php endforeach; ?>