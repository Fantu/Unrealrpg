<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');
require_once('inclusi/funzioni_combact.php');
$do=htmlspecialchars($_GET['do'],ENT_QUOTES);
$combactview=0;

$outputsfida=$lang['nessuna_sfida'];
if ($eventi['id']>0){
if($evento['tipo']==4 AND $evento['type']==2){
$sfidante=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$evento['oggid']."'");
$outputsfida=sprintf($lang['rispondi_sfida'],$sfidante['username'])." - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=0\">".$lang['Rifiuta']."</a> - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=1\">".$lang['Accetta']."</a>";
}elseif($evento['tipo']==4 AND $evento['type']==1){
$sfidante=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$evento['oggid']."'");
$outputsfida=sprintf($lang['sfida_lanciata'],$sfidante['username'])." - <a href=\"index.php?loc=combact&amp;do=annullasfida\">".$lang['Annulla']."</a>";
}elseif($evento['tipo']==5){
$filerep="inclusi/log/report/".$db->database."/".$evento['battleid'].".log";
ob_start();
include $filerep;
$report=ob_get_contents();
ob_end_clean();
$combactview=2;
$titleoutputcombact=$lang['titolo_report_combattimento2'];
$outputcombact="<table width=\"500\" align=\"center\">".$report."</table>";
$batt=$db->QuerySelect("SELECT * FROM battle WHERE id='".$evento['battleid']."' LIMIT 1");
$tattica=(int)$_GET['tattica'];
$subtattica=(int)$_GET['subtatt'];
if($tattica!=0){
if($batt['attid']==$user['userid']){
$db->QueryMod("UPDATE battle SET tatatt='".$tattica."',tatatt2='".$subtattica."' WHERE id='".$evento['battleid']."' LIMIT 1");
}else{
$db->QueryMod("UPDATE battle SET tatdif='".$tattica."',tatdif2='".$subtattica."' WHERE id='".$evento['battleid']."' LIMIT 1");
}
}//fine imposta tattica
$batt=$db->QuerySelect("SELECT * FROM battle WHERE id='".$evento['battleid']."' LIMIT 1");
if($batt['attid']==$user['userid']){
$tattica=$batt['tatatt'];
$subtattica=$batt['tatatt2'];
}else{
$tattica=$batt['tatdif'];
$subtattica=$batt['tatdif2'];
}
switch($tattica){
case 0:
$viewtattic=$lang['nessuna'];
break;//fine nessuna
case 1:
$viewtattic=$lang['tattica_attacco']." ".$lang['tattica_attacco_cac'];
break;//fine attacco
case 2:
$viewtattic=$lang['tattica_resa'];
break;//fine resa
case 3:
$viewtattic=$lang['tattica_difesa'];
break;//fine difesa
}
$viewtattic=sprintf($lang['tattica_selezionata'],$viewtattic)."<br/>";
}
}//se ci sono eventi

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
if ((100/$usercar['salute']*$usercar['saluteattuale'])<40 OR (100/$usercar['energiamax']*$usercar['energia'])<40)
$errore.=$lang['combact_errore5'];
$pcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$idp."' LIMIT 1");
if ((100/$pcar['salute']*$pcar['saluteattuale'])<40 OR (100/$pcar['energiamax']*$pcar['energia'])<40)
$errore.=$lang['combact_errore4'];
$expinc=1+floor($usercar['livello']/2);
if ($usercar['exp']>=$expinc*(120*$usercar['livello']))
$errore.=$lang['combact_errore6'];
$expinc=1+floor($pcar['livello']/2);
if ($pcar['exp']>=$expinc*(120*$pcar['livello']))
$errore.=$lang['combact_errore7'];
if($errore){
	$outputerrori="<span>".$lang['outputerrorisfida']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$user['userid']."','".$adesso."','600','11','4','1','".$idp."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$idp."','".$adesso."','600','12','4','2','".$user['userid']."')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
break;//fine sfidda
case "rispsfida":
$risp=(int)$_GET['risp'];
if ($eventi['id']>0){
$idp=(int)$evento['oggid'];
$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
$db->QueryMod("DELETE FROM eventi WHERE userid='".$idp."'");
if($risp==1){
Startcombact($user['userid'],$idp,$user['server']);
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}else{
$titolo=$lang['sfida_rifiutata'];
$testo=$lang['report_sfida_rifiutata'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$idp."','".$titolo."','".$testo."','0','".$adesso."')");
}
}
break;//fine rispondi alla sfida
case "annullasfida":
if ($eventi['id']>0){
if($evento['type']==1){
$idp=(int)$evento['oggid'];
$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
$db->QueryMod("DELETE FROM eventi WHERE userid='".$idp."'");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}//se ha lanciato lui la sfida
}
break;//fine annulla sfida
case "repview":
$repid=(int)$_GET['id'];
$errore="";
$filerep="inclusi/log/report/".$db->database."/".$repid.".log";
if(!file_exists($filerep))
$errore.=$lang['combact_errore3'];
if($errore==""){
$repbatt=$db->QuerySelect("SELECT * FROM battlereport WHERE id='".$repid."' LIMIT 1");
if($repbatt['attid']!=$user['userid'] AND $repbatt['difid']!=$user['userid'])
$errore.=$lang['combact_errore8'];	
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
ob_start();
include $filerep;
$report=ob_get_contents();
ob_end_clean();
$combactview=1;
$titleoutputcombact=$lang['titolo_report_combattimento1'];
$outputcombact="<table width=\"500\" align=\"center\">".$report."</table>";
}
break;//fine sfidda
}

require('template/int_combact.php');
?>