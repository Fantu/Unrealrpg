<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$numquery=0;
require('game/language/'.$language.'/lang_esterno.php');
require('game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$adesso=strtotime("now");
if(!empty($_GET['refer'])){
$refer=htmlspecialchars($_GET['refer'],ENT_QUOTES);
$server=htmlspecialchars($_GET['server'],ENT_QUOTES);
if(is_numeric($refer) AND is_numeric($server))
setcookie ("urbgrefer", $refer."|".$server,time()+604800);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name; echo" "; echo $game_version; echo" "; echo $game_revision; ?></title>
<?php include('game/inclusi/meta.php'); ?>
<link href="game/template/stile.css" rel="stylesheet" type="text/css" title="all"></link>
<script type="text/javascript">
<!--
function CambiaImg(id,bool) {
	var immagine = document.getElementById(id);
	if( bool == true )
		percorso = 'game/template/immagini/'+id+'_color.gif';
	else
		percorso = 'game/template/immagini/'+id+'_grigio.gif';
	immagine.src = percorso;
}
// -->
</script>
</head>
<body>
<table width="750" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
  <td>
<center><h1>
<?php echo $game_name; echo" "; echo $game_version; echo" "; echo $game_revision; ?>
</h1></center>
<?php
if( file_exists('pagine/'.$_GET['pag'].'.php') )
include('pagine/'.$_GET['pag'].'.php');
else
include('pagine/home.php');		
?>
  </td>
  </tr>
</table>
<div align="center">
<br /><br />
<?php echo $game_name; ?> &copy; 2007 Powered by <a href="http://www.lostgames.net" target="_blank">Lostgames.net</a>
<br />
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
	<img id="xhtml" src="game/template/immagini/xhtml_grigio.gif" alt="" border="0" onmouseover="CambiaImg('xhtml', true);" onmouseout="CambiaImg('xhtml', false);" />
</a>&nbsp;
<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
	<img id="css" src="game/template/immagini/css_grigio.gif" border="0" alt="" onmouseover="CambiaImg('css', true);" onmouseout="CambiaImg('css', false);" />
</a>
<a href="http://www.php.net" target="_blank">
	<img id="php" src="game/template/immagini/php_grigio.gif" alt="" border="0" onmouseover="CambiaImg('php', true);" onmouseout="CambiaImg('php', false);" />
</a>&nbsp;&nbsp;
<a href="http://www.mysql.com" target="_blank">
	<img id="mysql" src="game/template/immagini/mysql_grigio.gif" alt="" border="0" onmouseover="CambiaImg('mysql', true);" onmouseout="CambiaImg('mysql', false);" />
</a>&nbsp;&nbsp;<br /><div id="tempogenpag">
<?php
if($_GET['error']){
require("game/inclusi/errori.php");}
$end_time=time()+microtime();
$gen_time=number_format($end_time-$start_time, 4, '.', '');
echo sprintf($lang['tempo_gen_pagina'],$gen_time,$numquery);
?></div><br />
<script type="text/javascript"><!--
google_ad_client = "pub-0644240535082356";
//468x60, creato il 26/01/08
google_ad_slot = "7260256335";
google_ad_width = 468;
google_ad_height = 60;
google_cpa_choice = ""; // on file
//--></script>
<script type="text/javascript"
src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
</script>
</div>
</body>
</html>
