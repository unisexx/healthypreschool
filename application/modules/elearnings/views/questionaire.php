<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.10/jquery-ui.min.js"></script>
<script type="text/javascript">
$(function(){
	<?php // if(!is_login()): ?>
	$("#menu").hide();
	$("#form-body").css('height',$(window).height()-50);
	$(window).resize(function(){
        var h = $(window).height();
        var w = $(window).width();
        $("#form-body").css('height',$(window).height()-50);
    });
	<?php // else: ?>
	// $("#form-body").css('height',$(window).height()-202);
    // $(window).resize(function(){
        // var h = $(window).height();
        // var w = $(window).width();
        // $("#form-body").css('height',$(window).height()-202);
    // });
	<?php // endif; ?>
});
</script>

<ul class="breadcrumb">
  <li><a href="home">หน้าแรก</a> <span class="divider">/</span></li>
  <li><a href="elearnings">E-learning</a> <span class="divider">/</span></li>
  <li class="active"><?php echo $topic->title ?></li>
</ul>


<form action="elearnings/questionaire_save" method="post">
<div class="command">
	<div class="left">
		<h1>แบบทดสอบ - <?php echo $topic->title ?></h1>
	</div>
	<div class="right">
		<input type="submit" value="บันทึก" />
	</div>
	<div class="clear"></div>
</div>
<div id="form-body" style="overflow:auto;" >
	<div class="form-inner">
		<h2>คำชี้แจง</h2>
		<p class="detail"><?php echo nl2br($topic->detail) ?></p>
		<ul id="sortable">
			<?php foreach($topic->questionaire->order_by('sequence')->get() as $key => $question): ?>
			<?php question_form2($question,$key) ?>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
</form>

<style>
a{color: #0080ff; text-decoration:none;}


.left {float:left;}
.right {float:right;}

.clear { clear:both; }

#headtxt {border-bottom:1px solid #CCC; padding:5px;}
#headtxt p {text-align:center; font-size:16px; font-weight:700; margin-bottom:5px;}

#food { border-bottom:1px solid #CCC; padding:5px;}
#remark { border-bottom:1px solid #CCC; padding:5px 10px; font-size:13px; font-weight:700; color:#C00; background-color:#FFF}
#remark p {margin-bottom:5px;}
.toggle{display:block; width:16px; height:16px; background:url(../images/toggle.png) bottom left no-repeat;}
.active .toggle{display:block; width:16px; height:16px; background:url(../images/toggle.png) top left no-repeat;}
.report h2{position:relative;}
.report h2 .toggle{position:absolute; right:5px; top:5px;}

#content{
	padding:10px;
	border:1px solid #cacaca;
	border-top:none;
	background:#fff;
}
#content h3{line-height:22px;}


.search{
	text-align:center;
	border-top:1px solid #CCC;
	border-bottom:1px solid #CCC;
	background:#EFEFEF;
	padding:5px 0;
	margin:0 0 15px;
}
.search label{font-weight:bold;}
ol, ul {
    list-style: none;
    margin:0px;
    padding:0px;
}
ol{ list-style-position:inside; list-style-type:decimal;}
ol li{padding:0 0 5px;}
ul li{padding:0 0 5px;}
.list{line-height:16px;}
.list label,.form label{font-weight:bold;}
.full{width:99%;}
#form-body {
    background-color: #FFFFFF;
    border: 1px solid #AAAAAA;
}
#form-body p{padding:0 0 10px;}
.form-inner{padding:10px;}
.form-inner h2{font-size:14px; text-decoration:underline;}
.form-inner .detail{text-indent:15px; line-height:20px;}
.command{background:#AAA; padding:3px;}
.command h1{font-size:16px; margin:5px; padding:0;}
#form-body .box .full{width:70%;}
#form-body .box {padding:20px 10px 20px; border-bottom:1px solid #CCC;}
#form-body .box table th{width:120px; font-weight:bold; text-align:left; color:#000;}
#form-body .box{position:relative;}
#form-body .box:hover{background:#E8F3F9;}
#form-body .box .option{position:absolute; top:10px; right:10px; display:none;}
#form-body .box:hover .option{position:absolute; top:10px; right:10px; display:block;}
#form-body .box .disable {
    border: 1px dashed #999999;
    color: #000000;
	width:200px;
	padding:5px;
}
#form-body .box .half{width:60%;}
#form-body .box.scale .num{width:50px; text-align:center;}
#form-body .box.grid .num{width:50px; text-align:center;}
#form-body .box.grid table table th{width:400px;}
#form-body .box.grid table table th .full{width:85%;}
#form-body .box table th,#form-body .box table td,#form-body .q table th,#form-body .q table td {
    padding: 0.3em 12px 0.3em 0;
    text-align: left;
    vertical-align: middle;
}
#form-body .q {padding:20px 0;border-bottom:1px solid #CCC;}
#form-body .q table th{width:60px; font-weight:bold; text-align:left; color:#000;}
#form-body .q.scale .num{width:50px; text-align:center;}
#form-body .q.scale table table td{border:1px solid #CCC; border-left:none; border-right:none; text-align:center; padding:5px;}
#form-body .q.grid table table tr.odd td{background:#FAFAFA;}
#form-body .q.grid table table td{border:1px solid #CCC; text-align:center; padding:5px;}
.placeholder{border:1px dashed #00ff00; background:#dfffdf; margin:5px 0;}
.box h2{
	padding:5px 10px;
	font-size:16px;
	color: #233979;
	border: 1px solid #C1DAD7;
	text-align: left;
	background: #E2F1FA;
	margin:0 0 1px 0;
	cursor:pointer;
}
.child {padding:0 0 10px;}
.box.grid .child table {width:800px;}
.child table{width:500px; margin:0 auto;}
.child table td,.child table th{border:1px solid #CCC; text-align:center; padding:5px;}
.child table th{background:#EEE;}
.child table tr.odd td{background:#FAFAFA;}
.child table tfoot td{background:#ceffce;}
.child table .num{width:60px; text-align:center;}

.thankyou{
	padding:50px 10px;
	font-size:16px;
	color: #233979;
	border: 1px solid #C1DAD7;
	text-align: center;
	background: #E2F1FA;
	margin:10px;
	cursor:pointer;
}

.group_ddl{width:150px;}
</style>