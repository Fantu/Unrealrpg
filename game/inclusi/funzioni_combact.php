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
	$this->oggusati=0;
	}
}
class Dati{
	var $att;
	var $dif;
	function Stabilisciordine {
	global $db;
	$att=$this->$att;
	$dif=$this->$dif;
	$attpoint=$att->car['agilita']+$att->car['velocita']+($att->car['saluteattuale']/20)+($att->car['energia']/10);
	$difpoint=$dif->car['agilita']+$dif->car['velocita']+($dif->car['saluteattuale']/20)+($dif->car['energia']/10);
	if($attpoint>$difpoint){
	$chi=1;
	}else{
	$chi=2;
	}
	return $chi;
	} //fine Stabilisciordine
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
global $db,$adesso,$lang,$language,$dc;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$attaccante=$battle['attid'];
$difensore=$battle['difid'];
$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
$attn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
$difn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$difensore."' LIMIT 1");
$attequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$attaccante."' LIMIT 1");
$difequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$difensore."' LIMIT 1");
$dc->att=new Combattente($attaccante,$attn['username'],$attcar,$attequip);
$dc->dif=new Combattente($difensore,$difn['username'],$difcar,$difequip);
$chi=$dc->Stabilisciordine;
if ($chi==1){
$input.=Attaccovicino($dc->att,$dc->dif);
$input.=Attaccovicino($dc->dif,$dc->att);
}else{
$input.=Attaccovicino($dc->dif,$dc->att);
$input.=Attaccovicino($dc->att,$dc->dif);
}
$oggpersi=Checkusurarottura($dc->att->id);
if($oggpersi){
$input.=$dc->att->nome."<br/>".$oggpersi;
}
$oggpersi=Checkusurarottura($dc->dif->id);
if($oggpersi){
$input.=$dc->dif->nome."<br/>".$oggpersi;
}
Inreport($battleid,$input);
/*
//se si continua...creare nuovo turno
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
Docombactstats($battleid,$attaccante,$difensore);
*/
//se non continua
Endcombact($battle['id'],$dc->att,$dc->dif);
} //fine Battledo

function Endcombact($battleid,$att,$dif) {
global $db,$adesso;
$link="<a href=\"index.php?loc=combact&do=repview&id=".$battleid."\">qui</a>";
$titolo="Combattimento finito";
$testo="Nella versione attuale non si pu&ograve; definire ancora un combattimento, per&ograve; usabile comunque per rilevare eventuali errori o problemi di alcuni sistemi in sviluppo che saranno alla base del sistema di combattimento, per visualizzare il report clicca ".$link;
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$att->id."','".$titolo."','".$testo."','0','".$adesso."')");
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$dif->id."','".$titolo."','".$testo."','0','".$adesso."')");
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

function Attaccovicino($att,$dif) {
global $db,$lang;
if($att->equip['cac']!=0){
$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$att->equip['cac']."' LIMIT 1");
$danno=$arma['danno'];
$nomearma=$lang['oggetto'.$att->equip['cac'].'_nome'];
$energia=$arma['energia'];
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$att->id."' AND oggid='".$att->equip['cac']."' AND equip='1' LIMIT 1");
}else{
$danno=2;
$nomearma=$lang['pugno'];
$energia=10;
}

$colpisci=rand(1,2);
if($colpisci==1){
$input=sprintf($lang['danno_att_vicino'],$att->nome,$dif->nome,$nomearma,$danno)."<br/>";
$db->QueryMod("UPDATE caratteristiche SET saluteattuale=saluteattuale-'".$danno."' WHERE userid='".$dif->id."' LIMIT 1");
}else{
$input=sprintf($lang['niente_att_vicino'],$att->nome,$dif->nome,$nomearma)."<br/>";
}
$db->QueryMod("UPDATE caratteristiche SET energia=energia-'".$energia."' WHERE userid='".$att->id."' LIMIT 1");
return $input;
} //fine Attaccovicino
