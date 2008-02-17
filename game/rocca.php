<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_rocca.php');
require_once('inclusi/funzioni_magia.php');
if (isset($_POST['roccastudia'])){
$errore="";
$elementosel=(int)$_POST['elemento'];
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['rocca_errore1'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore.=$lang['rocca_errore2'];
if ($elementosel<1)
$errore.=$lang['rocca_errore3'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro) VALUES ('".$user['userid']."','".$adesso."','3600','8','1','6')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();	
}
}//fine lavora come apprendista
require('template/int_rocca.php');
?>