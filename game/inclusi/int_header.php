<?php
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$lg[0]."' AND password='".$lg[2]."' AND conferma=1 LIMIT 0,1");
if($user['userid']) {
$adesso=strtotime("now");
$db->QueryMod("UPDATE utenti SET ultimazione='".$adesso."' WHERE userid='".$user['userid']."'");
require_once('inclusi/controllo_eventi.php');
$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$user['userid']."'");
if($user['personaggio']==1) {
if($eventi['id']==0) {
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
}//fine recupero salute con tempo
if ($adesso>($usercar['decfede']+3600)){
	if ($usercar['fede']>0){
		$differenzaora=$adesso-$usercar['decfede'];
		$ore=floor($differenzaora/3600);
		$fede=$usercar['fede']-($ore*10);
		if ($fede<0)
		$fede=0;
		$db->QueryMod("UPDATE caratteristiche SET decfede=decfede+'".($ore*3600)."',fede='".($fede)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET decfede='".$adesso."' WHERE userid='".$user['userid']."'");}
}//fine decremento fede
if ($adesso>($usercar['recuperoenergia']+60)){
	if ($usercar['energia']<$usercar['energiamax']){
		$differenzaora=$adesso-$usercar['recuperoenergia'];
		$ore=floor($differenzaora/60);
		$energia=$usercar['energia']+$ore;
		if ($energia>$usercar['energiamax'])
		$energia=$usercar['energiamax'];
		$db->QueryMod("UPDATE caratteristiche SET recuperoenergia=recuperoenergia+'".($ore*60)."',energia='".($energia)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET recuperoenergia='".$adesso."' WHERE userid='".$user['userid']."'");}
}//fine recupero energia con tempo
}//fine se ci sono eventi in corso
}//fine se personaggio creato
require_once('template/int_header.php');
} //fine if userid
else {
	header("Location: ../index.php?error=4");
	exit();
}
?>
