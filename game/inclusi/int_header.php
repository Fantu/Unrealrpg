<?php
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$lg[0]."' AND password='".$lg[2]."' AND conferma=1 LIMIT 0,1");

if($user['userid']) {
$adesso=strtotime("now");
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($adesso>($usercar['recuperosalute']+3600)){
	if ($usercar['saluteattuale']<$usercar['salute']){
		$differenzaora=$adesso-$usercar['recuperosalute'];
		$ore=floor($differenzaora/3600);
		$salute=$usercar['saluteattuale']+$ore;
		if ($salute>$usercar['salute'])
		$salute=$usercar['salute'];
		$db->QueryMod("UPDATE caratteristiche SET recuperosalute=recuperosalute+'".($ore*3600)."',saluteattuale='".($salute)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET recuperosalute='".$adesso."' WHERE userid='".$user['userid']."'");}
}
require_once('template/int_header.php');
} //fine if userid
else {
	header("Location: ../index.php?error=4");
	exit();
}
?>
