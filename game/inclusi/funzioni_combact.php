<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

class Combattente{
	var $id,$nome,$car,$equip;
	function Combattente($id2,$nome2,$car2,$equip2) {
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
	$this->oggusati=0;
	}
} //fine classe Combattente
class Dati{
	var $att,$dif,$uno,$due;
	function Stabilisciordine() {
	$attpoint=$this->att->car['agilita']+$this->att->car['velocita']+($this->att->car['saluteattuale']/20)+($this->att->car['energia']/10);
	$difpoint=$this->dif->car['agilita']+$this->dif->car['velocita']+($this->dif->car['saluteattuale']/20)+($this->dif->car['energia']/10);
	if($attpoint>$difpoint){
	$this->uno=new Combattente($this->att->id,$this->att->nome,$this->att->car,$this->att->equip);
	$this->due=new Combattente($this->dif->id,$this->dif->nome,$this->dif->car,$this->dif->equip);
	}else{
	$this->due=new Combattente($this->att->id,$this->att->nome,$this->att->car,$this->att->equip);
	$this->uno=new Combattente($this->dif->id,$this->dif->nome,$this->dif->car,$this->dif->equip);
	}
	} //fine Stabilisciordine
	function eq($chi) {
	if($chi==1){
	$dato=$this->uno->equip;}
	else{
	$dato=$this->due->equip;}
	return $dato;
	} //fine eq
	function id($chi) {
	if($chi==1){
	$dato=$this->uno->id;}
	else{
	$dato=$this->due->id;}
	return $dato;
	} //fine id
	function nome($chi) {
	if($chi==1){
	$dato=$this->uno->nome;}
	else{
	$dato=$this->due->nome;}
	return $dato;
	} //fine nome
	function ogginuso($chi) {
	if($chi==1){
	$this->uno->oggusati=1;}
	else{
	$this->due->oggusati=1;}
	} //fine ogginuso
	
} //fine classe Dati

function Startcombact($attaccante,$difensore,$server) {
global $db,$adesso,$lang,$language,$dc;
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
//$input.=Attaccovicino("1","2");
//$input.=Attaccovicino("2","1");

$atteq=$dc->eq(1);
$input.=$atteq['cac'];

if($dc->uno->oggusati==1){
$oggpersi=Checkusurarottura($dc->id(1));
if($oggpersi){
$input.=$dc->nome(1)."<br/>".$oggpersi;
}
}
if($dc->due->oggusati==2){
$oggpersi=Checkusurarottura($dc->id(2));
if($oggpersi){
$input.=$dc->nome(2)."<br/>".$oggpersi;
}
}
Inreport($battleid,$input);
/*
//se si continua...creare nuovo turno
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
Docombactstats($battleid,$attaccante,$difensore);
*/
//se non continua
Endcombact($battle['id'],$dc->uno,$dc->due);
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

function Attaccovicino($at,$di) {
global $db,$lang,$dc;
$atteq=$dc->equip($at);
if($atteq['cac']!=0){
$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$atteq['cac']."' LIMIT 1");
$danno=$arma['danno'];
$nomearma=$lang['oggetto'.$atteq['cac'].'_nome'];
$energia=$arma['energia'];
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$dc->id($at)."' AND oggid='".$atteq['cac']."' AND equip='1' LIMIT 1");
$dc->ogginuso($at);
}else{
$danno=2;
$nomearma=$lang['pugno'];
$energia=10;
}

$colpisci=rand(1,2);
if($colpisci==1){
$input=sprintf($lang['danno_att_vicino'],$dc->nome($at),$dc->nome($di),$nomearma,$danno)."<br/>";
$db->QueryMod("UPDATE caratteristiche SET saluteattuale=saluteattuale-'".$danno."' WHERE userid='".$dc->id($di)."' LIMIT 1");
}else{
$input=sprintf($lang['niente_att_vicino'],$dc->nome($at),$dc->nome($di),$nomearma)."<br/>";
}
$db->QueryMod("UPDATE caratteristiche SET energia=energia-'".$energia."' WHERE userid='".$dc->id($at)."' LIMIT 1");
return $input;
} //fine Attaccovicino
