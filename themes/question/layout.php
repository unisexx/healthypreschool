<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
	<head>
		<base href="<?php echo base_url(); ?>" />
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8"> 
		<title><?php echo $template['title']; ?></title> 
		<script src="media/js/jquery-1.4.2.min.js" type="text/javascript"></script>
		<link rel="stylesheet" href="media/css/reset.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="media/css/icons.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="themes/question/css/default.css" type="text/css" media="screen" charset="utf-8" />	
		<link rel="stylesheet" href="media/css/pagination.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="themes/question/css/stylesheet.css" type="text/css" media="screen" charset="utf-8" />	
		<link rel="stylesheet" href="media/js/checkbox2/style.css" type="text/css" media="screen" charset="utf-8" />
		<link rel="stylesheet" href="media/js/jquery.jnotify/css/jquery.jnotify-alt.css" type="text/css" media="screen" />		
		<script type="text/javascript" src="media/js/jquery-ui-1.7.3.custom.min.js"></script>
		<script type="text/javascript" src="media/js/highchart/highcharts.js"></script>
		<script type="text/javascript" src="media/js/highchart/modules/exporting.js"></script>
		<script type="text/javascript" src="media/js/checkbox2/iphone-style-checkboxes.js"></script>
		<script type="text/javascript" src="media/js/jquery.jnotify/js/jquery.jnotify.min.js"></script>
		<script type="text/javascript" src="media/js/cufon/cufon-yui.js"></script>
		<script type="text/javascript" src="media/js/cufon/supermarket_400.font.js"></script>
		<?php echo $template['metadata']; ?>
		<script type="text/javascript">
			Cufon.replace('.cufon', { hover: true });
		</script>
	</head>
	<body> 
		<div id="wrapper">
			<div id="menu"><?php  include_once '_menu.php'; ?></div> 
			<div class="clear"></div>
			<div id="container"><?php echo $template['body']; ?></div> 
			<div id="footer"></div> 
		</div> 
	</body>
</html>