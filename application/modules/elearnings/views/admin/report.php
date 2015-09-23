<script type="text/javascript">
$(function(){
	$(".box div.child").hide();	
	
	$(".box h2").click(function(){
		$(this).toggleClass("active"); 
		$(this).parent().find('div.child').slideToggle();
		$(this).parent().siblings().find('h2').removeClass('active');
		$(this).parent().siblings().find('div.child').slideUp();
	})	
	
	$("a[rel=other]").click(function(){
		var me = $(this);
		me.text('กำลังโหลด...');
		$.post($(this).attr('href'),function(data){
			me.next().html(data);
			me.hide();
		})
		return false;
	})	
})
</script>

<div id="container">
	<div id="content" class="report">
		<h1 style="font-size:20px;" class="cufon">รายงานแบบสอบถาม<?php echo $topic->title ?></h1>
<?php foreach($topic->questionaire->order_by('sequence','asc')->get() as $key => $question): ?>
<?php if($question->type=='text'): ?>
<script type="text/javascript">
		
			var chart<?php echo $key ?>;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container<?php echo $key ?>',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: '<?php echo $question->question ?>'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y;
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (this.y/<?php echo $question->answer->count()?>*100).toFixed(2) +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('answer')->select_func('COUNT', '@answer', 'num')->group_by('answer')->get() as $answer): ?>
<?php echo $comma."['".$answer->answer."',".$answer->num.']'; ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
						]
					}]
				});
			});
				
		</script>
<div class="box">
<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
<div id="container<?php echo $key ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>
<table>
	<tr><th class="noborder"></th><th class="num">จำนวน</th><th class="num">ร้อยละ</th></tr>
	<tfoot><tr><td>รวม</td><td class="num"><?php echo $question->answer->count() ?></td><td class="num">100</td></tr></tfoot>
	<?php foreach ($question->answer->select('answer')->select_func('COUNT', '@answer', 'num')->group_by('answer')->get() as $answer): ?>
	<tr <?php echo cycle() ?>><td><?php echo $answer->answer ?></td><td class="num"><?php echo $answer->num ?></td><td class="num"><?php echo round($answer->num/$question->answer->count()*100,2)?></td></tr>
	<?php endforeach; ?>
	
</table>
</div>
</div>
<?php endif; ?>

<?php if($question->type=='radio'): ?>
<script type="text/javascript">
		
			var chart<?php echo $key ?>;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container<?php echo $key ?>',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: '<?php echo $question->question ?>'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y;
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (this.y/<?php echo $question->answer->count()?>*100).toFixed(2) +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('*')->select_func('COUNT', '@choice_id', 'num')->group_by('choice_id')->get() as $answer): ?>
<?php $name = ($answer->choice->name)?$answer->choice->name:'อื่นๆ' ?>
<?php echo $comma."['".$name."',".$answer->num.']'; ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
						]
					}]
				});
			});
				
		</script>
<div class="box">
<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
<div id="container<?php echo $key ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>
<table>
	<tr><th class="noborder"></th><th class="num">จำนวน</th><th class="num">ร้อยละ</th></tr>
	<tfoot><tr><td>รวม</td><td class="num"><?php echo $question->answer->count() ?></td><td class="num">100</td></tr></tfoot>
	<?php foreach ($question->answer->select('*')->select_func('COUNT', '@choice_id', 'num')->group_by('choice_id')->get() as $answer): ?>
	<tr <?php echo cycle() ?>><td><?php echo ($answer->choice->name)?$answer->choice->name:'<a rel="other" href="docs/other/'.$answer->questionaire_id.'">อื่นๆ</a><div></div>' ?></td><td class="num"><?php echo $answer->num ?></td><td class="num"><?php echo round($answer->num/$question->answer->count()*100,2)?></td></tr>
	<?php endforeach; ?>
</table>
</div>
</div>
<?php endif; ?>

<?php if($question->type=='checkbox'): ?>
<script type="text/javascript">
		
			var chart<?php echo $key ?>;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container<?php echo $key ?>',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: '<?php echo $question->question ?>'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y;
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (this.y/<?php echo $question->answer->count()?>*100).toFixed(2) +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('*')->select_func('COUNT', '@choice_id', 'num')->group_by('choice_id')->get() as $answer): ?>
<?php $name = ($answer->choice->name)?$answer->choice->name:'อื่นๆ' ?>
<?php echo $comma."['".$name."',".$answer->num.']'; ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
						]
					}]
				});
			});
				
		</script>
<div class="box">
<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
<div id="container<?php echo $key ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>
<table>
	<tr><th class="noborder"></th><th>จำนวน</th><th>ร้อยละ</th></tr>
	<tfoot><tr><td>รวม</td><td class="num"><?php echo $question->answer->count() ?></td><td class="num">100</td></tr></tfoot>
	<?php foreach ($question->answer->select('*')->select_func('COUNT', '@choice_id', 'num')->group_by('choice_id')->get() as $answer): ?>
	<tr <?php echo cycle() ?>><td><?php echo ($answer->choice->name)?$answer->choice->name:'<a rel="other" href="docs/other/'.$answer->questionaire_id.'">อื่นๆ</a><div></div>' ?></td><td class="num"><?php echo $answer->num ?></td><td><?php echo round($answer->num/$question->answer->count()*100,2)?></td></tr>
	<?php endforeach; ?>
</table>
</div>
</div>
<?php endif; ?>

<?php if($question->type=='scale'): ?>
<script type="text/javascript">
		
			var chart<?php echo $key ?>;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container<?php echo $key ?>',
						plotBackgroundColor: null,
						plotBorderWidth: null,
						plotShadow: false
					},
					title: {
						text: '<?php echo $question->question ?>'
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.point.name +'</b>: '+ this.y;
						}
					},
					plotOptions: {
						pie: {
							allowPointSelect: true,
							cursor: 'pointer',
							dataLabels: {
								enabled: true,
								color: '#000000',
								connectorColor: '#000000',
								formatter: function() {
									return '<b>'+ this.point.name +'</b>: '+ (this.y/<?php echo $question->answer->count()?>*100).toFixed(2) +' %';
								}
							}
						}
					},
				    series: [{
						type: 'pie',
						name: 'Browser share',
						data: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('answer')->select_func('COUNT', '@answer', 'num')->group_by('answer')->get() as $answer): ?>
<?php echo $comma."['".$answer->answer."',".$answer->num.']'; ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
						]
					}]
				});
			});
				
		</script>
<div class="box">
<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
<div id="container<?php echo $key ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>
<table>
	<tr><th class="noborder"></th><th>จำนวน</th><th>ร้อยละ</th></tr>
	<tfoot><tr><td>รวม</td><td class="num"><?php echo $question->answer->count() ?></td><td class="num">100</td></tr></tfoot>
	<?php foreach ($question->answer->select('answer')->select_func('COUNT', '@answer', 'num')->group_by('answer')->get() as $answer): ?>
	<tr <?php echo cycle() ?>><td><?php echo $answer->answer ?></td><td class="num"><?php echo $answer->num ?></td><td class="num"><?php echo round($answer->num/$question->answer->count()*100,2)?></td></tr>
	<?php endforeach; ?>
</table>
</div>
</div>
<?php endif; ?>

<?php if($question->type=='grid'): ?>
<?php $optional = json_decode($question->optional,TRUE); ?>
<script type="text/javascript">
		
			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container<?php echo $key ?>',
						defaultSeriesType: 'column',
						margin: [ 50, 50, 100, 80]
					},
					title: {
						text: '<?php echo $question->question ?>'
					},
					xAxis: {
						categories: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('*')->select_func('AVG', '@answer', 'num')->group_by('choice_id')->get() as $answer): ?>
<?php echo $comma."'".$answer->choice->name."'"; ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
						],
						labels: {
							rotation: -45,
							align: 'right',
							style: {
								 font: 'normal 13px Verdana, sans-serif'
							}
						}
					},
					yAxis: {
						min: 0,
						title: {
							text: '<?php echo $question->question ?>'
						}
					},
					legend: {
						enabled: false
					},
					tooltip: {
						formatter: function() {
							return '<b>'+ this.x +'</b><br/><br/>'+
								 'คะแนนเฉลี่ย: '+ Highcharts.numberFormat(this.y, 1);
						}
					},
				        series: [{
						name: 'Population',
						data: [
<?php $comma = ''; ?>
<?php foreach ($question->answer->select('*')->select_func('AVG', '@answer', 'num')->group_by('choice_id')->get() as $answer): ?>
<?php echo $comma.round($answer->num,2); ?>
<?php $comma = ','; ?>
<?php endforeach; ?>
],
						dataLabels: {
							enabled: true,
							rotation: -90,
							color: '#FFFFFF',
							align: 'right',
							x: -3,
							y: 10,
							formatter: function() {
								return this.y;
							},
							style: {
								font: 'normal 13px Verdana, sans-serif'
							}
						}			
					}]
				});
				
				
			});
				
		</script>
<div class="box grid">
<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
<div id="container<?php echo $key ?>" style="width: 800px; height: 400px; margin: 0 auto"></div>
<table width="90%">
	<tr>
		<th class="noborder"></th>
		<?php for($i=1;$i<=$question->range;$i++): ?>
		<th class="num"><?php echo (@$optional[$i-1])?$optional[$i-1]:$i ?><br /><?php echo '('.($question->range - $i + 1).')' ?></th>
		<?php endfor; ?>
		<th class="num">เฉลี่ย</th>
	
	</tr>
	<?php foreach ($question->answer->select('*')->select_func('AVG', '@answer', 'num')->group_by('choice_id')->get() as $answer): ?>
	<tr <?php echo cycle() ?>>
		<td><?php echo $answer->choice->name ?></td>
		<?php for($i=$question->range;$i>=1;$i--): ?><td class="num"><?php echo $question->answer->where('choice_id',$answer->choice_id)->where('answer',$i)->count()?></td><?php endfor; ?>
		<td class="num"><?php echo round($answer->num,2) ?></td></tr>
	<?php endforeach; ?>
</table>
</div>
</div>
<?php endif; ?>



<?php if($question->type=='textarea'): ?>
<div class="box grid">
	<h2><?php echo $question->question ?> <span class="toggle"></span></h2>
<div class="child">
	<table style="width:100%;">
		<tr>
			<th class="num">ลำดับ</th>
			<th>คำตอบ</th>
		</tr>
		<?php foreach ($question->answer->get() as $key => $answer): ?>
		<tr <?php echo cycle() ?>>
			<td class="num"><?php echo ++$key ?></td>
			<td style="text-align:left;"><?php echo nl2br($answer->answer) ?></td></tr>
		<?php endforeach; ?>
	</table>
</div>
</div>
<?php endif; ?>
<?php endforeach; ?>

</div>
</div>