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
} //fine classe Combattente

class Dati{
	public $che;
	
	public function Stabilisciordine($attaccante,$difensore) {
	global $db;
	$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
	$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
	$attn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
	$difn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$difensore."' LIMIT 1");
	$attequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$attaccante."' LIMIT 1");
	$difequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$difensore."' LIMIT 1");
	$attpoint=$attcar['agilita']+$attcar['velocita']+($attcar['saluteattuale']/20)+($attcar['energia']/10);
	$difpoint=$difcar['agilita']+$difcar['velocita']+($difcar['saluteattuale']/20)+($difcar['energia']/10);
	if($attpoint>$difpoint){
	$this->che[1]=new Combattente($attaccante,$attn['username'],$attcar,$attequip);
	$this->che[2]=new Combattente($difensore,$difn['username'],$difcar,$difequip);
	}else{
	$this->che[2]=new Combattente($attaccante,$attn['username'],$attcar,$attequip);
	$this->che[1]=new Combattente($difensore,$difn['username'],$difcar,$difequip);
	}
	} //fine Stabilisciordine
	
	public function equip($chi,$campo) {
	$dato=$this->che[$chi]->equip[$campo];
	return $dato;
	} //fine equip
	
	public function car($chi,$campo) {
	$dato=$this->che[$chi]->car[$campo];
	return $dato;
	} //fine car
	
	public function id($chi) {
	$dato=$this->che[$chi]->id;
	return $dato;
	} //fine id
	
	public function nome($chi) {
	$dato=$this->che[$chi]->nome;
	return $dato;
	} //fine nome
	
	public function Ogginuso($chi) {
	$this->che[$chi]->oggusati=1;
	} //fine ogginuso
	
	public function Controlloogg($chi) {
	$oggpersi=Checkusurarottura($this->id($chi));
	if($oggpersi){
	$dato.=$this->nome($chi)."<br/>".$oggpersi;
	}
	return $dato;
	} //fine Controlloogg
	
	public function pvar($chi) {
	$dato=$this->che[$chi];
	return $dato;
	} //fine pvar
	
	public function Attaccovicino($att,$dif) {
	global $db,$lang;
	if($this->equip($att,'cac')!=0){
	$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($att,'cac')."' LIMIT 1");
	$danno=$arma['danno'];
	$nomearma=$lang['oggetto'.$this->equip($att,'cac').'_nome'];
	$energia=$arma['energia'];
	$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$this->id($att)."' AND oggid='".$this->equip($att,'cac')."' AND equip='1' LIMIT 1");
	$this->Ogginuso($att);
	}else{
	$danno=1+round($this->car($att,'attfisico')/100);
	$nomearma=$lang['pugno'];
	$energia=10;
	}
	
	$colpisci=rand(1,40)+($this->car($att,'agilita')/10-$this->car($dif,'agilita')/10)+($this->car($att,'velocita')/30-$this->car($dif,'velocita')/30);
	if($colpisci>30){
	$difesamax=round($this->car($dif,'diffisica')/100);
	$difesa=rand(0,$difesamax);
	$danno-=$difesa;
	if($danno<1)
	$danno=1;
	$input=sprintf($lang['danno_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma,$danno)."<br/>";
	$db->QueryMod("UPDATE caratteristiche SET saluteattuale=saluteattuale-'".$danno."' WHERE userid='".$this->id($dif)."' LIMIT 1");
	}else{
	$input=sprintf($lang['niente_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma)."<br/>";
	}
	$db->QueryMod("UPDATE caratteristiche SET energia=energia-'".$energia."' WHERE userid='".$this->id($att)."' LIMIT 1");
	return $input;
	} //fine Attaccovicino
	
} //fine classe Dati

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
$dc=new Dati();
$dc->Stabilisciordine($battle['attid'],$battle['difid']);

//$input.=$dc->equip(1,'cac')."<br/>";

$input.=$dc->Attaccovicino(1,2);
$input.=$dc->Attaccovicino(2,1);

if($dc->che[1]->oggusati==1){
$input.=$dc->Controlloogg(1);}
if($dc->che[2]->oggusati==1){
$input.=$dc->Controlloogg(2);}

Inreport($battleid,$input);
/*
//se si continua...creare nuovo turno
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
Docombactstats($battleid,$attaccante,$difensore);
*/
//se non continua
Endcombact($battle['id'],$dc->pvar(1),$dc->pvar(2));
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
