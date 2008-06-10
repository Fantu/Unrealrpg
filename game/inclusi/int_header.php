<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$userid=htmlspecialchars($lg[0],ENT_QUOTES);
$password=htmlspecialchars($lg[2],ENT_QUOTES);
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$userid."' AND password='".$password."' AND conferma=1 LIMIT 1");
if($user['userid']){
if($user['ipattuale']!=$_SERVER['REMOTE_ADDR']){
echo "<script language=\"javascript\">window.location.href='../index.php?error=14'</script>";
exit();
}//se ip non corrisponde
$db->QueryMod("UPDATE utenti SET ultimazione='".$adesso."' WHERE userid='".$user['userid']."'");
require_once('inclusi/controllo_eventi.php');
Controllaeventi(2);
$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$user['userid']."'");
if($user['personaggio']==1) {
if(($user['refertime']!=0) AND ($user['refertime']<$adesso)){
	$refercheck=explode("|",$user['refer']);
	if($user['server']==$refercheck[1]){
	$referuserid=(int)$refercheck[0];
	$refercheck2=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE userid='".$referuserid."'");
	if($refercheck2['id']>0){
	$revisit=$adesso+2592000;
	$db->QueryMod("UPDATE utenti SET refertime='".$revisit."' WHERE userid='".$user['userid']."'");
	$db->QueryMod("UPDATE utenti SET puntiplus=puntiplus+'1' WHERE userid='".$referuserid."'");	
	}//fine se referente esiste
	}//fine se server � lo stesso
}//fine se ora del controllo ref
if($user['plus']<$adesso){
$db->QueryMod("UPDATE utenti SET plus='0' WHERE userid='".$user['userid']."'");
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}//se account plus scaduto
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");	
if($eventi['id']==0) {
if ($usercar['saluteattuale']<1){
require('inclusi/morte.php');
}
if ($adesso>($usercar['decfede']+3600)){
	if ($usercar['fede']>0){
		$differenzaora=$adesso-$usercar['decfede'];
		$ore=floor($differenzaora/3600);
		$fede=$usercar['fede']-($ore*8);
		if ($fede<0)
		$fede=0;
		$db->QueryMod("UPDATE caratteristiche SET decfede=decfede+'".($ore*3600)."',fede='".$fede."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET decfede='".$adesso."' WHERE userid='".$user['userid']."'");}
}//fine decremento fede	
if ($adesso>($usercar['recuperosalute']+3600)){
	if ($usercar['saluteattuale']<=$usercar['salute']){
		$differenzaora=$adesso-$usercar['recuperosalute'];
		$ore=floor($differenzaora/3600);
		$salute=$usercar['saluteattuale']+round($usercar['salute']/100*$ore);
		if ($salute>$usercar['salute'])
		$salute=$usercar['salute'];
		$db->QueryMod("UPDATE caratteristiche SET recuperosalute=recuperosalute+'".($ore*3600)."',saluteattuale='".($salute)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET recuperosalute='".$adesso."' WHERE userid='".$user['userid']."'");}
}//fine recupero salute con tempo
if ($adesso>($usercar['recuperoenergia']+60)){
	if ($usercar['energia']<=$usercar['energiamax']){
		$differenzaora=$adesso-$usercar['recuperoenergia'];
		$ore=floor($differenzaora/60);
		$energia=$usercar['energia']+round($usercar['energiamax']/1000*$ore);
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
	header("Location: ../index.php?error=13");
	exit();
}
?>
