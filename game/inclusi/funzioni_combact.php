<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

function Startcombact() {
global $db,$adesso,$lang,$language,$user,$outputerrori;
if(!is_dir('inclusi/log/report/'.$user['server'])){
$outputerrori="Dir mancante<br>";
mkdir("inclusi/log/report/".$user['server'], 0777);
if(!is_dir('inclusi/log/report/'.$user['server']))
$outputerrori.="Creazione dir non riuscita<br>";
}//se la cartella non esiste

} //fine Startcombact
