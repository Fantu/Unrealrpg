<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

function Startcombact($attaccante,$difensore,$server) {
global $db,$adesso,$lang,$language,$outputerrori;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid) VALUES ('".$difensore."','".$adesso."','84600','13','5','".$attaccante."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid) VALUES ('".$attaccante."','".$adesso."','84600','13','5','".$difensore."')");
$db->QueryMod("INSERT INTO battle (attid,difid) VALUES ('".$attaccante."','".$difensore."')");
$battle=$db->QuerySelect("SELECT id FROM battle WHERE attid='".$attaccante."' LIMIT 1");
$db->QueryMod("INSERT INTO battlereport (id,data) VALUES ('".$battle['id']."','".$adesso."')");
umask(0000);
$fp=fopen("inclusi/log/report/".$server."/".$battle['id'].".log","a+");
fputs($fp,"prova");
} //fine Startcombact
