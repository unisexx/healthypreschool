<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<base href="<?php echo base_url(); ?>" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $template['title'] ?></title>
	<? include "_css.php";?>
    <? include "_script.php";?>
    <?php echo $template['metadata'] ?>
</head>
<body>
	<div class="main">
		<div class="header">
	    	<? include "_header.php";?>
	        <div class="content">
				<div class="content_resize">
	            <? include "_left.php";?>
				<div class="col2">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
				      <tr>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_top_left.png" width="9" height="9" /></td>
				        <td height="9" background="themes/hps/images/table_content_top.png"> </td>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_top_right.png" width="9" height="9" /></td>
				      </tr>
				      <tr>
				        <td background="themes/hps/images/table_content_left.png">&nbsp;</td>
				        <td bgcolor="#FFFFFF" class="main_content_blk">
				        	<?php echo $template['body'] ?>
				        </td>
				        <td background="themes/hps/images/table_content_right.png">&nbsp;</td>
				      </tr>
				      <tr>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_bottom_left.png" width="9" height="9" /></td>
				        <td height="9" background="themes/hps/images/table_content_bottom.png"> </td>
				        <td width="9" height="9"><img src="themes/hps/images/table_content_bottom_right.png" width="9" height="9" /></td>
				      </tr>
				    </table>
				</div>
	       	 	<div class="clr"></div>
			</div>
		</div>
	    <? include "_footer.php";?>
		</div>
	</div>
</body>
</html>