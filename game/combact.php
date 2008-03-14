<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

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
if($errore){
	$outputerrori="<span>".$lang['outputerrorisfida']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$user['userid']."','".$adesso."','1800','11','4','1','".$idp."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,type,oggid) VALUES ('".$idp."','".$adesso."','1800','12','4','2','".$user['userid']."')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();	
}
break;//fine sfidda
case "rispsfida":
$risp=(int)$_GET['risp'];
if($risp==1){
$outputerrori="Sfida accettata ma impossibile procedere con il combattimento...in sviluppo";
}else{
$titolo=$lang['sfida_rifiutata'];
$testo=$lang['report_sfida_rifiutata'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$user['userid']."','".$titolo."','".$testo."','0','".$adesso."')");
}
$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
$db->QueryMod("DELETE FROM eventi WHERE userid='".$idp."'");
break;//fine rispondi alla sfida
}

$outputsfida=$lang['nessuna_sfida'];
if ($eventi['id']>0){
$eventisfida=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."'");
if($eventisfida['tipo']==4 AND $eventisfida['type']==2)
$outputsfida=sprintf($lang['rispondi_sfida'],$eventisfida['oggid'])." - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=0\">".$lang['Rifiuta']."</a> - <a href=\"index.php?loc=combact&amp;do=rispsfida&amp;risp=1\">".$lang['Accetta']."</a>;
}

require('template/int_combact.php');
?>