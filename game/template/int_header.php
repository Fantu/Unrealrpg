<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name." ".$game_state; ?></title>
<?php include('inclusi/meta.php'); ?>
<link href="template/stile.css?version=<?php echo $game_version; ?>" rel="stylesheet" type="text/css" title="all"></link>
</head>
<body>
<table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155" rowspan="2" valign="top"><?php include('inclusi/menu.php'); ?>
    </td>
    <td width="20">&nbsp;</td>
    <td width="715">&nbsp;</td>
    <td width="20">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td valign="top" align="center">
		<table width="715" border="0" align="right" cellpadding="1" cellspacing="1">
		  <tr>
			<td width="565" valign="top">
			<div id="contenuto">