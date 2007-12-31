<?php
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
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>