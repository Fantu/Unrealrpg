<?php
require('language/it/lang_situazione.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$expnewmin=100+($usercar['minatore']*500);
if($usercar['expminatore']>99) {
	if($usercar['expminatore']>=$expnewmin)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.minatore=t1.minatore+'1',t1.expminatore=t1.expminatore-'".$expnewmin."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv minatore
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$percmin1=floor((100/$expnewmin)*$usercar['expminatore']);
$percmin2=100-$percmin1;
$expnewlevel=$usercar['livello']*100;
$quantimess=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");
if($quantimess['id']==0){
$newmsg=$lang['nessun_nuovo_msg'];
} elseif($quantimess['id']==1){
$newmsg="<a href=\"game.php?act=messaggi\">".$lang['un_nuovo_msg']."</a>";
}else{
$newmsg="<a href=\"game.php?act=messaggi\">".sprintf($lang['nuovi_msg'],$quantimess['id'])."</a>";
}//fine nuovi msg
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>