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
	var $stato;
	function Combattente($id2,$nome2,$car2,$equip2) {
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
	$this->oggusati=0;
	$this->stato=0;
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
	
	public function stato($chi) {
	$dato=$this->che[$chi]->stato;
	return $dato;
	} //fine stato
	
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
	
	public function Controllastato($chi) {
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	if ($percenergia<5)
	$this->che[$chi]->stato=1;
	} //fine Controllastato
	
	public function Attaccovicino($att,$dif) {
	global $db,$lang;
	if($this->equip($att,'cac')!=0){
	$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($att,'cac')."' LIMIT 1");
	$energia=$arma['energia'];
	}
	if($this->equip($att,'cac')!=0 AND $this->car($att,'energia')>$energia){
	$danno=$arma['danno'];
	$nomearma=$lang['oggetto'.$this->equip($att,'cac').'_nome'];
	$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$this->id($att)."' AND oggid='".$this->equip($att,'cac')."' AND equip='1' LIMIT 1");
	$this->Ogginuso($att);
	}else{
	$danno=1+round($this->car($att,'attfisico')/100);
	$nomearma=$lang['pugno'];
	$energia=20;
	}
	$colpisci=rand(1,100)+($this->car($att,'agilita')/5-$this->car($dif,'agilita')/5)+($this->car($att,'velocita')/15-$this->car($dif,'velocita')/15);
	if($this->equip($att,'cac')!=0 AND $arma['danno']!=0)
	$colpisci+=$colpisci/100*$arma['danno'];
	if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
	$colpisci-=20;
	if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20)
	$colpisci+=20;
	if((100/$this->car($att,'salute')*$this->car($att,'saluteattuale'))<10)
	$colpisci-=20;
	if((100/$this->car($dif,'salute')*$this->car($dif,'saluteattuale'))<10)
	$colpisci+=20;
	if($colpisci>50 OR $this->stato($dif)==1){
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
$dc->Controllastato(1);
$dc->Controllastato(2);

if($dc->stato(1)==0){
$input.=$dc->Attaccovicino(1,2);}else{
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(1))."<br/>";}
if($dc->stato(2)==0){
$input.=$dc->Attaccovicino(2,1);}else{
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(2))."<br/>";}

if($dc->che[1]->oggusati==1){
$input.=$dc->Controlloogg(1);}
if($dc->che[2]->oggusati==1){
$input.=$dc->Controlloogg(2);}

Inreport($battleid,$input);

//se si continua...creare nuovo turno
//$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','180','0','6','".$battleid."')");
Docombactstats($battleid,$dc->id(1),$dc->id(2));

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
$percsalute=100/$attcar['salute']*$attcar['saluteattuale'];
if ($percsalute<1){
$salute=$lang['morto'];
}elseif ($percsalute>=1 AND $percsalute<10){
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
$percenergia=100/$attcar['energiamax']*$attcar['energia'];
if ($percenergia<5){
$energia=$lang['esausto'];
}elseif ($percenergia>=5 AND $percenergia<10){
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
$repinput.=$lang['Salute'].": ".$salute."<br/>";
$repinput.=$lang['Energia'].": ".$energia."<br/>";
$repinput.="</td><td>";
$repinput.=$difn['username']."<br/>";
$percsalute=100/$difcar['salute']*$difcar['saluteattuale'];
if ($percsalute<1){
$salute=$lang['morto'];
}elseif ($percsalute>=1 AND $percsalute<10){
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
$percenergia=100/$difcar['energiamax']*$difcar['energia'];
if ($percenergia<5){
$energia=$lang['esausto'];
}elseif ($percenergia>=5 AND $percenergia<10){
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
$repinput.=$lang['Salute'].": ".$salute."<br/>";
$repinput.=$lang['Energia'].": ".$energia."<br/>";
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
