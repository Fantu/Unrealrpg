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
	var $esausto;
	var $morto;
	function Combattente($id2,$nome2,$car2,$equip2) {
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
	$this->oggusati=0;
	$this->esausto=0;
	$this->morto=0;
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
	$attpoint=$attcar['agilita']+$attcar['velocita']+($attcar['saluteattuale']/2)+($attcar['energia']/5);
	$difpoint=$difcar['agilita']+$difcar['velocita']+($difcar['saluteattuale']/2)+($difcar['energia']/5);
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
	
	public function esausto($chi) {
	$dato=$this->che[$chi]->esausto;
	return $dato;
	} //fine esausto
	
	public function morto($chi) {
	$dato=$this->che[$chi]->morto;
	return $dato;
	} //fine morto
	
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
	$this->che[$chi]->esausto=1;
	if ($this->car($chi,'saluteattuale')<1)
	$this->che[$chi]->morto=1;
	} //fine Controllastato
	
	public function Guadagnaexp($chi,$turni) {
	global $db,$lang;
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$exp=10+2*$turni;
	$exp=round(rand(($exp/100*80),$exp));
	$level=$this->car($chi,'livello')-$this->car($chi2,'livello');
	if($level<0){
	$liv=abs($level);
	if($liv>10)
	$liv=10;
	$exp+=round($exp/10*$liv);
	}
	if($level>0){
	if($liv>9)
	$liv=9;
	$exp-=round($exp/10*$liv);
	}
	$db->QueryMod("UPDATE caratteristiche SET exp=exp+'".$exp."' WHERE userid='".$this->id($chi)."' LIMIT 1");
	$input=sprintf($lang['exp_guadagnata'],$this->nome($chi),$exp)."<br/>";
	return $input;
	} //fine Guadagnaexp
	
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
	if($colpisci>50 OR $this->esausto($dif)==1){
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

function Battledo($battleid,$turni) {
global $db,$adesso,$lang,$language;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$dc=new Dati();
$dc->Stabilisciordine($battle['attid'],$battle['difid']);
$dc->Controllastato(1);
$dc->Controllastato(2);

if($dc->esausto(1)==0){
$input.=$dc->Attaccovicino(1,2);}else{
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(1))."<br/>";}
if($dc->esausto(2)==0){
$input.=$dc->Attaccovicino(2,1);}else{
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(2))."<br/>";}

if($dc->che[1]->oggusati==1){
$input.=$dc->Controlloogg(1);}
if($dc->che[2]->oggusati==1){
$input.=$dc->Controlloogg(2);}
$input.="<br/>";
Inreport($battleid,$input);

$dc->Stabilisciordine($battle['attid'],$battle['difid']);
$dc->Controllastato(1);
$dc->Controllastato(2);

Docombactstats($battleid,$dc->id(1),$dc->id(2));
$finito=0;
$turni++;
if($dc->esausto(1)==1 AND $dc->esausto(2)==1){//se entrambi esausti
$finito=1;
$input=$lang['finito_entrambi_esausti']."<br/>";
}elseif($dc->morto(1)==1){//se il primo vince
$finito=1;
$input=sprintf($lang['vincitore_combattimento'],$dc->nome(2))."<br/>";
}elseif($dc->morto(2)==1){//se il secondo vince
$finito=1;
$input=sprintf($lang['vincitore_combattimento'],$dc->nome(1))."<br/>";
}
elseif($turni==20){//se dura troppo
$finito=1;
$input=$lang['combattimento_troppo_lungo']."<br/>";
}
if($finito==1){
$input.=$dc->Guadagnaexp(1,$turni);
$input.=$dc->Guadagnaexp(2,$turni);
Endcombact($battle['id'],$dc->pvar(1),$dc->pvar(2));
Inreport($battleid,$input);
}else{//continua
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid,turni) VALUES ('0','".$adesso."','180','0','6','".$battleid."','".$turni."')");}
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
$salute=testosalute($percsalute);
$percenergia=100/$attcar['energiamax']*$attcar['energia'];
$energia=testoenergia($percenergia);
$repinput.=$lang['Salute'].": ".$salute."<br/>";
$repinput.=$lang['Energia'].": ".$energia."<br/>";
$repinput.="</td><td>";
$repinput.=$difn['username']."<br/>";
$percsalute=100/$difcar['salute']*$difcar['saluteattuale'];
$salute=testosalute($percsalute);
$percenergia=100/$difcar['energiamax']*$difcar['energia'];
$energia=testoenergia($percenergia);
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
