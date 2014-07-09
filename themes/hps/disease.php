<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo base_url(); ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $template['title'] ?></title>
<?php echo $template['metadata'] ?>
<style type="text/css">
@charset "utf-8";
/*
Design by http://www.favouritedesign.com
*/
body { margin:0; padding:0; width:100%; color:#5e5e5e; font:normal 14px/1.5em "Liberation sans", Arial, Helvetica, sans-serif; background:#fff;}


.clr { clear:both; padding:0; margin:0; width:100%; font-size:0px; line-height:0px;}
p { margin:8px 0; padding:0 0 8px;}
a {text-decoration:none; color:#0575d4;}
a:hover {color:#0190fe;}


/* table */
.table1 {border-spacing:2px;  border:1px solid #ccc; }
.table1 tr td {padding:5px; border-bottom:1px solid #ccc;}

.table2 {line-height:20px; }
.table2 tr td {padding:10px; border-bottom:2px solid #fff;}

.title {font-size:16px; font-weight:bold; color:#3067aa; margin:20px 0 10px 25px;}

/* officer */
.officer {float:left; width:700px; margin:10px auto 10px auto; height:33px; }
.officer ul { list-style:none; padding-left:20px; margin:0; width:700px; float:left;}
.officer ul li {display:block;  padding:0; padding-top:8px; float:left; text-align:center; margin-top:0px; border:none; padding-left:3px; margin-left:5px; background: url(../images/bullet_inno.png) 0px 13px no-repeat;}
.officer ul li a { display:block;  margin:0; padding-right:10px; padding-left:10px; font-size:13px;  font-weight:bold; color:#686868; text-decoration:none; text-align:center;}
.officer ul li.active a, .officer ul li a:hover{ padding:0px; padding-left:10px; padding-right:10px; margin:0; color:#4993ec}
</style>
<link rel="stylesheet" href="media/js/bootstrap/css/bootstrap.min.css" type="text/css">
<? include "_script.php";?>
</head>


<body>
<?php echo $template['body'] ?>
</body>
</html>
