<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_rocca.php');
require_once('inclusi/funzioni_magia.php');

if (isset($_POST['roccastudia'])){
$errore="";
$elementosel=(int)$_POST['elemento'];
$ore=(int)$_POST['ore'];
if ($usercar['energia']<(100+(100*$ore)))
$errore.=$lang['rocca_errore1'];
if ($elementosel<1)
$errore.=$lang['rocca_errore3'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$user['userid']."','".$adesso."','3600','8','1','6','".$elementosel."','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
}//fine studia
if (isset($_POST['roccapratica'])){
$errore="";
$elementosel=(int)$_POST['elemento2'];
$tiposel=(int)$_POST['tipo'];
$ore=(int)$_POST['ore2'];
if ($usercar['energia']<(100+(100*$ore)))
$errore.=$lang['rocca_errore1'];
if ($elementosel<1)
$errore.=$lang['rocca_errore3'];
if ($tiposel<1)
$errore.=$lang['rocca_errore4'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['rocca_errore5'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore,type) VALUES ('".$user['userid']."','".$adesso."','3600','10','1','8','".$elementosel."','".$ore."','".$tiposel."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
}//fine pratica
require('template/int_rocca.php');
?>