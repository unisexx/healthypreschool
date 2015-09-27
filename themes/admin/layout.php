<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<base href="<?php echo base_url(); ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<title><?php echo $template['title']; ?></title> 
        <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
		<link rel="stylesheet" href="media/css/pagination.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="themes/admin/media/css/stylesheet.css" type="text/css" media="screen" charset="utf-8" /> 
		<link rel="stylesheet" href="media/js/bootstrap/css/bootstrap.min.css" type="text/css">
		<link rel="stylesheet" href="media/js/bootstrap/css/bootstrap-responsive.min.css" type="text/css">
		<link rel="stylesheet" href="media/css/font-awesome-4.4.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="media/css/elearnings.css">
		<script src="media/js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<script type="text/javascript" src="media/js/jquery.validate.min.js"></script>
		<script type="text/javascript" src="media/js/highchart/highcharts.js"></script>
		<script type="text/javascript" src="media/js/highchart/modules/exporting.js"></script>
		<?php echo $template['metadata']; ?>
	</head>
	<body> 
	<div id="header"><?php include_once('_header.inc.php'); ?></div> 
		<div id="container">
			<div id="menu"><?php include_once '_menu.inc.php'; ?></div> 
			<div id="content"><div class="inner"><?php echo $template['body']; ?></div></div> 
			<div style="clear:both;"></div>
		</div> 
		<div id="footer"></div> 
	</body>
</html>