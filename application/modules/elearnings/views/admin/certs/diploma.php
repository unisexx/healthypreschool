<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<base href="<?php echo base_url(); ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>ประกาศนียบัตร</title>
		<link href="themes/print/css/style.css"type="text/css" rel="stylesheet"/>
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
			<div style="margin-top:-10px;margin-left:-10px;">
				&nbsp;
			</div>
			<div class="logo">
				&nbsp;
			</div>
			<div class="text1" style="font-size:44px;">
				<div style=" font-size:50px; margin-top:15px;">
					สำนักโรคติดต่อทั่วไป กรมควบคุมโรค
				</div>
				ขอมอบใบสำคัญนี้ให้ไว้เพื่อแสดงว่า
				<br>
				<span style="color:#009;font-size:50px;padding-top:20px;padding-bottom:20px;display:block;">
				<?=@$user -> name ?>
				</span>
				เป็นผู้ที่ผ่านการทดสอบความรู้ทางสื่อออนไลน์
				<br>
				เรื่องการป้องกันควบคุมโรคติดต่อในศูนย์เด็กเล็กและโรงเรียนอนุบาล
				<br>
				ให้ไว้ ณ <?=thainumDigit(mysql_to_th_cert($questionresult[0]-> update_date, "F")) ?>
				<br>

				<div style="margin-top:20px; font-size:32px;">
					<img src="media/images/sig.png" width="130">
					<br>
					(นายอำนวย  กาจีนะ)
					<br>
					อธิบดีกรมควบคุมโรค
				</div>
			</div>
		</div>
	</body>
</html>
<script>
	window.print();
</script>