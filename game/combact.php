<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

$do=htmlspecialchars($_GET['do'],ENT_QUOTES);

if ($do=="sfida"){
$idp=(int)$_GET['id'];
$errore="";
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
$eventisfidato=$db->QuerySelect("SELECT COUNT(id) AS id FROM eventi WHERE userid='".$idp."'");
if ($eventisfidato['id']>0)
$errore.=$lang['combact_errore1'];
if ($idp==$user['userid'])
$errore.=$lang['combact_errore2'];
if($errore){
	$outputerrori="<span>".$lang['outputerrorisfida']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type) VALUES ('".$user['userid']."','".$adesso."','1800','11','4','1')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type) VALUES ('".$idp."','".$adesso."','1800','12','4','2')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
}//fine sfida

require('template/int_combact.php');
?>