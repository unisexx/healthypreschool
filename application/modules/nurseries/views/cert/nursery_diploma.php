<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ประกาศนียบัตร</title>
<link href="themes/print_nursery/css/style.css"type="text/css" rel="stylesheet"/>
<style>
	@media print {
		@page {
			size: landscape
		}
		@page {
			margin: 0;
		}
	}
	body {
		-webkit-print-color-adjust: exact;
	}
</style>
</head>

<body>
<div id="bg-diploma">
	<div style="padding-top:30px;">&nbsp;</div>
	<div class="logo">&nbsp;</div>
	<div class="text1">
    	<div style="color:#009; font-size:60px; margin-top:22px;">กรมควบคุมโรค</div>
มอบประกาศนียบัตรนี้ให้ไว้เพื่อแสดงว่า<br><br>

<span style="border-bottom:1px dashed #bbb7b8;"><?=$nursery_name?></span><br><br>

ได้ผ่านเกณฑ์การประเมินศูนย์เด็กเล็ก<br>
และโรงเรียนอนุบาลคุณภาพ-ปลอดโรค ประจำปี <?=$approve_year?><br>
<br>

<img src="media/images/sig.png" width="130">
<div style="border-bottom:1px dashed #bbb7b8; width:300px; margin:-25px auto 0;">&nbsp;</div>
<div style=" font-size:40px;">
	(นายอำนวย  กาจีนะ)<br>
<span style="font-size:32px;">อธิบดีกรมควบคุมโรค</span></div>

<div style="margin-left:60px; margin-top:-5px;font-size:26px; float:left;">ประกาศนียบัตรนี้มีผลรับรองถึงปี <?=$expired?></div>

</div>

</div>


<script>
	window.print();
</script>

</body>
</html>
