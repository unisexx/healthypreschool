<STYLE type=text/css> 
#printable { display: block; }
@media print 
{ 
	#menu,#hilight,#print,.span4 { display: none; } 
	#printable { display: block;}
}
</STYLE> 

<!-- Calendar -->
<script type='text/javascript' src='media/js/fullcalendar-1.4.3/fullcalendar.js'></script>
<script type='text/javascript' src='media/js/ui.core.js'></script>
<script type='text/javascript' src='media/js/ui.draggable.js'></script>
<script type='text/javascript' src='media/js/ui.resizable.js'></script>
<script type="text/javascript">
$(document).ready(function(){
	$.fullCalendar.parseDate( 'a' );		
	$('#calendar').fullCalendar({
		header: {
					left: 'today',
					center: 'title',
					right: 'prev,next'
				},
		theme: true,
		editable: true,
		disableDragging : true,
		disableResizing : true,
		eventClick: function(event){
		window.location = '<?php echo base_url()?>calendars/view/' + event.id + '/<?php echo $id ?>';
				},
				events: "<?php echo base_url()?>calendars/events/<?php echo $id ?><?php echo @$_GET['group_id'] ?>",
				loading: function(bool) {
				if (bool) $('#loading').show();
					else $('#loading').hide();
				}
	});
	
	$("#print").click(function(){
		window.print();
	});
});
</script>
<!-- !Calendar -->

<div id="printable">
<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li class="active">ปฎิทินกิจกรรม</li>
</ul>

<div class="carendar">
	<div id="data">
	<div style="clear:left;display:inline-block;width:100%">
			<div style="height:30px;">
			<div id='loading' style='display:none;text-align:center;'><img src="media/images/ajax-loader.gif" /></div>
		</div>
		<div id='calendar'></div>
		<div style="clear:both;"></div></div>
	</div>
	<!-- <br>
	<div id="print" class="pull-right btn btn-small"><i class="icon-print"></i> พิมพ์หน้านี้</div> -->
</div>
</div>
