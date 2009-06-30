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
<div id=contenitore>
	<div id=latosx>

    <?php include('inclusi/menu.php'); ?>
	</div>
	<div id=corpocentrale> 
		<div id="contenuto">