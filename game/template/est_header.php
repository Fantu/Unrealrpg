<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name." ".$game_state." ".$game_version; ?></title>
<?php include('game/inclusi/meta.php'); ?>
<link href="game/template/stile.css?version=<?php echo $game_version; ?>" rel="stylesheet" type="text/css" title="all"></link>
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
<div id=cont_est>
<div id=login_est>
<?php
if(preg_match("/MSIE/",$_SERVER['HTTP_USER_AGENT']) AND ($pagina=="home")){ ?>
<?php echo $lang['desc_firefox']; ?><br />
<br />
<center><a href="http://www.mozilla-europe.org/firefox/"><img src="game/template/immagini/firefox.png" alt="<?php echo $lang['scarica_firefox']; ?>" border="0" /></a></center>
<br />
<?php } ?>
<center><h1>
<?php echo $game_name." ".$game_state." ".$game_version; ?>
</h1></center>
<span><?php echo $lang['Login']; ?></span><br />
		<form action="game/login.php" method="post" name="formlogin">
		<table width="750" border="0">
		  <tr>
			<td><?php echo $lang['Username']; ?></td>
			<td><input name="login_username" type="text" maxlength="25" /></td>
			<td><?php echo $lang['Server']; ?></td>
			<td><select name="login_server">
			<?php foreach($game_server as $chiave=>$elemento){
				if($language==$game_server_lang[$chiave])
			  	echo "<option value=\"$chiave\">$elemento</option>";} ?>
			</select></td>
		  </tr>
		  <tr>
			<td><?php echo $lang['Password']; ?></td>
			<td><input name="login_password" type="password" maxlength="20" /></td>
			<td><input name="Submit" type="submit" value="<?php echo $lang['Entra']; ?>" /></td>
		  </tr>
		</table>
      	</form>
<br /><br />