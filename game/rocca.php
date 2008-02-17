<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_rocca.php');
require_once('inclusi/funzioni_magia.php');
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if($user['plus']==0){$tempoproxlav=$game_proxlav_normal;}else{$tempoproxlav=$game_proxlav_plus;}
$tempoproxlav=$tempoproxlav*$userlav['oreultimolav'];
if (isset($_POST['roccastudia'])){
$errore="";
$elementosel=(int)$_POST['elemento'];
$ore=(int)$_POST['ore'];
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<(100+(100*$ore)))
$errore.=$lang['rocca_errore1'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore.=$lang['rocca_errore2'];
if ($elementosel<1)
$errore.=$lang['rocca_errore3'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE lavori SET oreultimolav='0' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$user['userid']."','".$adesso."','3600','8','1','6','".$elementosel."','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();	
}
}//fine lavora come apprendista
require('template/int_rocca.php');
?>