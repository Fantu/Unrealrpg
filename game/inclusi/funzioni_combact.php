<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

class Combattente{
	var id;
	var nome;
	var car;
	function Combattente($id,$nome,$car) {
	$this->id=$id;
	$this->nome=$nome;
	$this->car=$car;
	}
}

function Startcombact($attaccante,$difensore,$server) {
global $db,$adesso,$lang,$language;
$db->QueryMod("INSERT INTO battle (attid,difid) VALUES ('".$attaccante."','".$difensore."')");
$battle=$db->QuerySelect("SELECT id FROM battle WHERE attid='".$attaccante."' LIMIT 1");
$db->QueryMod("INSERT INTO battlereport (id,data) VALUES ('".$battle['id']."','".$adesso."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battle['id']."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$difensore."','".$adesso."','84600','13','5','".$attaccante."','".$battle['id']."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$attaccante."','".$adesso."','84600','13','5','".$difensore."','".$battle['id']."')");
Docombactstats($battle['id'],$attaccante,$difensore);
Battledo($battle['id']);//prova
Endcombact($battle['id']);
} //fine Startcombact

function Battledo($battleid) {
global $db,$adesso,$lang,$language;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$attaccante=$battle['attid'];
$difensore=$battle['difid'];
$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
$attn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
$difn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$difensore."' LIMIT 1");
$chi=Stabilisciordine($attaccante,$difensore,$attcar,$difcar,$attn,$difn);

//prova ordine
foreach($chi as $chiave=>$elemento){
$input.=$elemento->nome."-".$elemento->car['livello']."<br/>";
}
Inreport($battleid,$input);

//se si continua...creare nuovo turno
//$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
//Docombactstats($battleid,$attaccante,$difensore);
} //fine Battledo

function Endcombact($battleid) {
global $db;
$db->QueryMod("DELETE FROM eventi WHERE battleid='".$battleid."'");
$db->QueryMod("DELETE FROM battle WHERE id='".$battleid."'");
} //fine Endcombact

function Docombactstats($battleid,$attaccante,$difensore) {
global $db,$lang;
$server=$db->database;
umask(0000);
$fp=fopen("inclusi/log/report/".$server."/".$battleid.".log","a+");
$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
$attn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
$difn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$difensore."' LIMIT 1");
$repinput.="<tr><td>";
$repinput.=$attn['username']."<br/>";
$repinput.=$lang['Salute'].": ".$attcar['saluteattuale']."/".$attcar['salute']."<br/>";
$repinput.=$lang['Energia'].": ".$attcar['energia']."/".$attcar['energiamax']."<br/>";
$repinput.="</td><td>";
$repinput.=$difn['username']."<br/>";
$repinput.=$lang['Salute'].": ".$difcar['saluteattuale']."/".$difcar['salute']."<br/>";
$repinput.=$lang['Energia'].": ".$difcar['energia']."/".$difcar['energiamax']."<br/>";
$repinput.="</td></tr>";
fputs($fp,$repinput);
} //fine Docombactstats

function Inreport($battleid,$input) {
global $db;
$server=$db->database;
umask(0000);
$fp=fopen("inclusi/log/report/".$server."/".$battleid.".log","a+");
$repinput.="<tr><td colspan=\"2\">";
$repinput.=$input;
$repinput.="</td></tr>";
fputs($fp,$repinput);
} //fine Inreport

function Stabilisciordine($attaccante,$difensore,$attcar,$difcar,$attn,$difn) {
global $db;
$attpoint=$attcar['agilita']+$attcar['velocita']+($attcar['saluteattuale']/20)+($attcar['energia']/10);
$difpoint=$difcar['agilita']+$difcar['velocita']+($difcar['saluteattuale']/20)+($difcar['energia']/10);
$att=new Combattente($attaccante,$attn['username'],$attcar);
$dif=new Combattente($difensore,$difn['username'],$difcar);
if($attpoint>$difpoint){
$chi[0]=$att;
$chi[1]=$dif;
}else{
$chi[1]=$att;
$chi[0]=$dif;
}
return $chi;
} //fine Stabilisciordine
