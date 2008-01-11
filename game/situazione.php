<?php
require('language/it/lang_situazione.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$expnewmin=100+($usercar['minatore']*500);
if($usercar['expminatore']>99) {
	if($usercar['expminatore']>=$expnewmin)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.minatore=t1.minatore+'1',t1.expminatore=t1.expminatore-'".$expnewmin."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv minatore
$expnewmin2=100+($usercar['alchimista']*500);
if($usercar['expalchimista']>99) {
	if($usercar['expalchimista']>=$expnewmin2)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.alchimista=t1.alchimista+'1',t1.expalchimista=t1.expalchimista-'".$expnewmin2."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv minatore
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$percmin1=floor((100/$expnewmin)*$usercar['expminatore']);
$percmin2=100-$percmin1;
$percmin3=floor((100/$expnewmin2)*$usercar['expalchimista']);
$percmin4=100-$percmin3;
$expnewlevel=$usercar['livello']*100;
$quantimess=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");
if($quantimess['id']==0){
$newmsg=$lang['nessun_nuovo_msg'];
} elseif($quantimess['id']==1){
$newmsg="<a href=\"game.php?act=messaggi\">".$lang['un_nuovo_msg']."</a>";
}else{
$newmsg="<a href=\"game.php?act=messaggi\">".sprintf($lang['nuovi_msg'],$quantimess['id'])."</a>";
}//fine nuovi msg
if($eventi['id']>0){
	$eventi=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."' LIMIT 1");
	$evento=$lang['eventi_dettagli'.$eventi['dettagli']].date("d/m/y - H:i",($eventi['datainizio']+$eventi['secondi']));
}
if(!$evento)
$evento=$lang['nessun_evento'];
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>