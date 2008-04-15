<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

class Combattente{
	var $id;
	var $nome;
	var $car;
	var $equip;
	function Combattente($id2,$nome2,$car2,$equip2) {
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
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
$attequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$attaccante."' LIMIT 1");
$difequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$difensore."' LIMIT 1");
$att=new Combattente($attaccante,$attn['username'],$attcar,$attequip);
$dif=new Combattente($difensore,$difn['username'],$difcar,$difequip);
$chi=Stabilisciordine($att,$dif);
if ($chi==1){
$input.=Attaccovicino($att,$dif);
$input.=Attaccovicino($dif,$att);
}else{
$input.=Attaccovicino($dif,$att);
$input.=Attaccovicino($att,$dif);
}
$oggpersi=Checkusurarottura($att->id);
if($oggpersi){
$input.=$att->nome."<br/>".$oggpersi;
}
$oggpersi=Checkusurarottura($dif->id);
if($oggpersi){
$input.=$dif->nome."<br/>".$oggpersi;
}
Inreport($battleid,$input);
/*
//se si continua...creare nuovo turno
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
Docombactstats($battleid,$attaccante,$difensore);
*/
//se non continua
Endcombact($battle['id']);
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

function Stabilisciordine($att,$dif) {
global $db;
$attpoint=$att->car['agilita']+$att->car['velocita']+($att->car['saluteattuale']/20)+($att->car['energia']/10);
$difpoint=$dif->car['agilita']+$dif->car['velocita']+($dif->car['saluteattuale']/20)+($dif->car['energia']/10);
if($attpoint>$difpoint){
$chi=1;
}else{
$chi=2;
}
return $chi;
} //fine Stabilisciordine

function Attaccovicino($att,$dif) {
global $db,$lang;
if($att->equip['cac']!=0){
$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$att->equip['cac']."' LIMIT 1");
$danno=$arma['danno'];
$nomearma=$lang['oggetto'.$att->equip['cac'].'_nome'];
$energia=$arma['energia'];
}else{
$danno=2;
$nomearma=$lang['pugno'];
$energia=10;
}

$colpisci=rand(1,2);
if($colpisci==1){
$input=sprintf($lang['danno_att_vicino'],$att->nome,$dif->nome,$nomearma);
$db->QueryMod("UPDATE caratteristiche SET saluteattuale=saluteattuale-'".$danno."' WHERE userid='".$dif->id."' LIMIT 1");
}else{
$input=sprintf($lang['niente_att_vicino'],$att->nome,$dif->nome,$nomearma);
}
$db->QueryMod("UPDATE caratteristiche SET energia=energia-'".$energia."' WHERE userid='".$att->id."' LIMIT 1");
return $input;
} //fine Attaccovicino
