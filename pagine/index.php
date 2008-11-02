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
}//se refer
$pagina=htmlspecialchars($_GET['pag'],ENT_QUOTES);
if(!file_exists('pagine/'.$pagina.'.php'))
$pagina="home";
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
<?php
if(ereg("MSIE",$_SERVER['HTTP_USER_AGENT']) AND ($pagina=="home")){ ?>
<?php echo $lang['desc_firefox']; ?><br />
<br />
<center><a href="http://www.mozilla-europe.org/firefox/"><img src="game/template/immagini/firefox.png" alt="<?php echo $lang['scarica_firefox']; ?>" border="0" /></a></center>
<br />
<?php } ?>
</td>
</tr>
<tr>
<td>
<center><h1>
<?php echo $game_name; echo" "; echo $game_version; echo" "; echo $game_revision; ?>
</h1></center>
<?php require('pagine/'.$pagina.'.php');
require('game/template/est_footer.php');
?>