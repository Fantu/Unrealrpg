<?php
require('../game/inclusi/valori.php');
$db->Setdb(1000);
$int_security=$game_se_code;
if($_COOKIE['urbglanguage']){
$language=htmlspecialchars($_COOKIE['urbglanguage'],ENT_QUOTES);
}else{
$language="it";
}//fine lingua
require('../game/language/'.$language.'/lang_admin.php');
$accesso=explode("|||",$_COOKIE['urbgadm']);
$user=htmlspecialchars($accesso[0],ENT_QUOTES);
$pass=htmlspecialchars($accesso[1],ENT_QUOTES);
$op=$db->QuerySelect("SELECT * FROM utenti WHERE password='".$pass."'");

if(md5($op['username'])!=$user){
	header("Location: index.php");
	exit();
}else{
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name; echo" - "; echo $lang['pannello_amministrazione']; ?></title>
<meta name="author" content="Fantoni Fabio"></meta>
<meta name="language" content="it,en"></meta>
<meta name="copyright" content="Fantoni Fabio"></meta>
<meta name="content-language" content="it,en"></meta>
<script type="text/javascript">
<!--
function CambiaImg(id,bool) {
	var immagine = document.getElementById(id);
	if( bool == true )
		percorso = '../game/template/immagini/'+id+'_color.gif';
	else
		percorso = '../game/template/immagini/'+id+'_grigio.gif';
	immagine.src = percorso;
}
// -->
</script>
<link href="stile.css" rel="stylesheet" type="text/css" title="all"></link>
</head>
<body>
	<table width="700" cellspacing="2" border="0" cellpadding="2" align="center">
	  <tbody>
	<tr><td colspan="2"><h3><?php echo $lang['pannello_amministrazione']; ?></h3></TD></tr>
		<tr>
		  <td width="200" valign="top"><?php include("admin_menu.php"); ?></td>
		  <td width="500" class="tabmenu" valign="top" style="padding:10px 10px 10px 10px"><br />
		<?php
		$loc=htmlspecialchars($_GET['loc'],ENT_QUOTES);
		if(isset($_GET['loc'])&&file_exists("admin_".$loc.".php"))
			include("admin_".$loc.".php");
		else
		include("home.php");
		?>
		<br/></td>
		</tr>
	  </tbody>
	</table>
<br/><br/>
<?php include('footer.php'); ?>
</body>
</html>
<?php
}
?>
