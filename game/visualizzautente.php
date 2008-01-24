<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('inclusi/personaggio.php');
$utente=(int)$_GET['id'];
$datiutente=$db->QuerySelect("SELECT t1.userid AS userid,t1.username AS username,t1.ultimazione AS ultimazione,t2.livello AS livello,t2.razza AS razza,t2.classe AS classe,t2.sesso AS sesso,t2.salute AS salute,t2.energiamax AS energiamax,t2.saluteattuale AS saluteattuale,t2.energia AS energia FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.userid='".$utente."' LIMIT 1");
$percsalute=100/$datiutente['salute']*$datiutente['saluteattuale'];
if ($percsalute<10){
$salute=$lang['pessima'];
}elseif ($percsalute>=10 AND $percsalute<20){
$salute=$lang['molto_bassa'];
}elseif ($percsalute>=20 AND $percsalute<40){
$salute=$lang['bassa'];
}elseif ($percsalute>=40 AND $percsalute<60){
$salute=$lang['media'];
}elseif ($percsalute>=60 AND $percsalute<80){
$salute=$lang['alta'];
}elseif ($percsalute>=80 AND $percsalute<90){
$salute=$lang['molto_alta'];
}elseif ($percsalute>=90){
$salute=$lang['perfetta'];
}
$percenergia=100/$datiutente['energiamax']*$datiutente['energia'];
if ($percenergia<10){
$energia=$lang['pessima'];
}elseif ($percenergia>=10 AND $percenergia<20){
$energia=$lang['molto_bassa'];
}elseif ($percenergia>=20 AND $percenergia<40){
$energia=$lang['bassa'];
}elseif ($percenergia>=40 AND $percenergia<60){
$energia=$lang['media'];
}elseif ($percenergia>=60 AND $percenergia<80){
$energia=$lang['alta'];
}elseif ($percenergia>=80 AND $percenergia<90){
$energia=$lang['molto_alta'];
}elseif ($percenergia>=90){
$energia=$lang['perfetta'];
}
require('template/int_visualizzautente.php');
?>