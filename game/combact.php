<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');
require_once('inclusi/funzioni_combact.php');
$do=htmlspecialchars($_GET['do'],ENT_QUOTES);
switch($do){
case "sfida":
$idp=(int)$_GET['id'];
$errore="";
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
$eventisfidato=$db->QuerySelect("SELECT COUNT(id) AS id FROM eventi WHERE userid='".$idp."'");
if ($eventisfidato['id']>0)
$errore.=$lang['combact_errore1'];
if ($idp==$user['userid'])
$errore.=$lang['combact_errore2'];
if ( (100/$usercar['salute']*$usercar['saluteattuale'])<40 OR (100/$usercar['energiamax']*$usercar['energia'])<40 )
$errore.=$lang['combact_errore5'];
$pcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$idp."' LIMIT 1");
if ( (100/$pcar['salute']*$pcar['saluteattuale'])<40 OR (100/$pcar['energiamax']*$pcar['energia'])<40 )
$errore.=$lang['combact_errore4'];
if($errore){
	$outputerrori="<span>".$lang['outputerrorisfida']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$user['userid']."','".$adesso."','900','11','4','1','".$idp."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$idp."','".$adesso."','900','12','4','2','".$user['userid']."')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
break;//fine sfidda
case "rispsfida":
$risp=(int)$_GET['risp'];
$eventisfida=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."'");
$idp=(int)$eventisfida['oggid'];
$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
$db->QueryMod("DELETE FROM eventi WHERE userid='".$idp."'");
if($risp==1){
//$outputerrori="Sfida accettata ma impossibile procedere con il combattimento...in sviluppo";
Startcombact($user['userid'],$idp,$user['server']);
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}else{
$titolo=$lang['sfida_rifiutata'];
$testo=$lang['report_sfida_rifiutata'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$idp."','".$titolo."','".$testo."','0','".$adesso."')");
}
break;//fine rispondi alla sfida
case "repview":
$repid=(int)$_GET['id'];
$errore="";
$filerep="inclusi/log/report/".$db->database."/".$repid.".log";
if(!file_exists($filerep))
$errore.=$lang['combact_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
ob_start();
include $filerep;
$report=ob_get_contents();
ob_end_clean();
$outputcombact="<table>".$report."</table>";
}
break;//fine sfidda
}

$outputsfida=$lang['nessuna_sfida'];
if ($eventi['id']>0){
$eventisfida=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."' LIMIT 1");
if($eventisfida['tipo']==4 AND $eventisfida['type']==2){
$sfidante=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$eventisfida['oggid']."'");
$outputsfida=sprintf($lang['rispondi_sfida'],$sfidante['username'])." - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=0\">".$lang['Rifiuta']."</a> - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=1\">".$lang['Accetta']."</a>";
}elseif($eventisfida['tipo']==5){
$filerep="inclusi/log/report/".$db->database."/".$eventisfida['battleid'].".log";
ob_start();
include $filerep;
$report=ob_get_contents();
ob_end_clean();
$outputcombact="<table>".$report."</table>";
}
}

require('template/int_combact.php');
?>