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
	var $tattica;
	var $subtattica;
	var $bonusexp;
	var $plus;
	var $salutei;
	var $energiai;
	function Combattente($id2,$nome2,$car2,$equip2,$tattica2,$subtattica2,$plus2){
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
	$this->oggusati=0;
	$this->esausto=0;
	$this->morto=0;
	$this->tattica=$tattica2;
	$this->subtattica=$subtattica2;
	$this->bonusexp=0;
	$this->plus=$plus2;
	$this->salutei=$car2['saluteattuale'];
	$this->energiai=$car2['energia'];
	}
} //fine classe Combattente

class Dati{
	public $che;
	
	public function Stabilisciordine($attaccante,$difensore,$battle) {
	global $db;
	$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
	$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
	$attn=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
	$difn=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$difensore."' LIMIT 1");
	$attequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$attaccante."' LIMIT 1");
	$difequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$difensore."' LIMIT 1");
	$attpoint=$attcar['agilita']+$attcar['velocita']+($attcar['saluteattuale']/2)+($attcar['energia']/5);
	$difpoint=$difcar['agilita']+$difcar['velocita']+($difcar['saluteattuale']/2)+($difcar['energia']/5);
	if($attpoint>$difpoint){
	$this->che[1]=new Combattente($attaccante,$attn['username'],$attcar,$attequip,$battle['tatatt'],$battle['tatatt2'],$attn['plus']);
	$this->che[2]=new Combattente($difensore,$difn['username'],$difcar,$difequip,$battle['tatdif'],$battle['tatdif2'],$difn['plus']);
	}else{
	$this->che[2]=new Combattente($attaccante,$attn['username'],$attcar,$attequip,$battle['tatatt'],$battle['tatatt2'],$attn['plus']);
	$this->che[1]=new Combattente($difensore,$difn['username'],$difcar,$difequip,$battle['tatdif'],$battle['tatdif2'],$difn['plus']);
	}
	if($this->plus(1)>0 AND $this->tattica(1,1)==0)
	$this->Autotattic(1);
	if($this->plus(2)>0 AND $this->tattica(2,1)==0)
	$this->Autotattic(2);
	} //fine Stabilisciordine
	
	//----------------------------
	//  VISUALIZZAZIONE DATI
	//----------------------------
	
	public function equip($chi,$campo) {
	$dato=$this->che[$chi]->equip[$campo];
	return $dato;
	} //fine equip
	
	public function car($chi,$campo) {
	$dato=$this->che[$chi]->car[$campo];
	return $dato;
	} //fine car
	
	public function tattica($chi,$campo) {
	if($campo==1)
	$dato=$this->che[$chi]->tattica;
	else
	$dato=$this->che[$chi]->subtattica;
	return $dato;
	} //fine tattica
	
	public function id($chi) {
	$dato=$this->che[$chi]->id;
	return $dato;
	} //fine id
	
	public function plus($chi) {
	$dato=$this->che[$chi]->plus;
	return $dato;
	} //fine plus
	
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
	
	public function bexp($chi) {
	$dato=$this->che[$chi]->bonusexp;
	return $dato;
	} //fine bexp
	
	public function pvar($chi) {
	$dato=$this->che[$chi];
	return $dato;
	} //fine pvar
	
	//----------------------------
	//  IMPOSTAZIONE DATI
	//----------------------------
	
	public function Ogginuso($chi,$cosa) {
	global $db;
	$db->QueryMod("UPDATE equip SET inuso='1' WHERE userid='".$this->id($chi)."' AND oggid='".$this->equip($chi,$cosa)."' LIMIT 1");
	$this->che[$chi]->oggusati=1;
	} //fine ogginuso
	
	public function Modsalute($chi,$quanto){
	$this->che[$chi]->car['saluteattuale']-=$quanto;
	} //fine ogginuso
	
	public function Modenergia($chi,$quanto){
	$this->che[$chi]->car['energia']-=$quanto;
	} //fine ogginuso
	
	public function Aggiornastat($chi){
	global $db;
	if($this->car($chi,'saluteattuale')<0)
	$this->che[$chi]->car['saluteattuale']=0;
	$db->QueryMod("UPDATE caratteristiche SET saluteattuale='".$this->car($chi,'saluteattuale')."',energia='".$this->car($chi,'energia')."' WHERE userid='".$this->id($chi)."' LIMIT 1");
	} //fine ogginuso
	
	public function Impobexp($chi,$cosa) {
	$this->che[$chi]->bonusexp=$cosa;
	} //fine Impobexp
	
	public function Controlloogg($chi) {
	$oggpersi=Checkusurarottura($this->id($chi));
	if($oggpersi){
	$dato.=$this->nome($chi)."<br/>".$oggpersi;
	}
	return $dato;
	} //fine Controlloogg
	
	public function Controllastato($chi) {
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	if ($percenergia<5)
	$this->che[$chi]->esausto=1;
	if ($this->car($chi,'saluteattuale')<1)
	$this->che[$chi]->morto=1;
	} //fine Controllastato
	
	public function Autotattic($chi) {
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$percsalute=100/$this->car($chi,'salute')*$this->car($chi,'saluteattuale');
	$percsalute2=100/$this->car($chi2,'salute')*$this->car($chi2,'saluteattuale');
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	$percenergia2=100/$this->car($chi2,'energiamax')*$this->car($chi2,'energia');
	$tattp=array(1=>0,2=>0,3=>0);
	$tattp[1]=99;//attacco di base
	if($percsalute<40){//difesa
	$tattp[3]+=40;}
	if($percenergia<30){//difesa
	$tattp[3]+=40;}
	if($percsalute2>40 AND $percsalute<40){//difesa
	$tattp[3]+=40;}
	if($percenergia2>10 AND $percsalute<30 AND $percsalute2>40){//difesa
	$tattp[3]+=40;}
	if($this->equip($chi,'cac')==0 AND $this->equip($chi2,'cac')!=0){//se nessuna arma mentre avversario sì difesa
	$tattp[3]+=18;}
	if($percenergia2<5){//se l'avversario è esausto attacco
	$tattp[1]+=90;}
	if($percsalute<10){//se la salute è pessima resa
	$tattp[2]+=181;}
	if($percenergia<5){//se esausto resa
	$tattp[2]+=200;}
	$max=0;
	foreach($tattp as $chiave=>$elemento){
	if($elemento>$max){
	$max=$elemento;
	$this->che[$chi]->tattica=$chiave;
	}
	}//per ogni tattica
	if($this->tattica($chi,1)==1)
	$this->che[$chi]->subtattica==1;
	} //fine Autotattic
	
	public function Guadagnaexp($chi,$turni,$expb) {
	global $db,$lang;
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$exp=1*$turni;
	$exp+=$expb;
	$exp=round(rand(($exp/100*95),$exp));
	if($this->bexp($chi)==1){
	$exp-=6;
	}elseif($this->bexp($chi)==2){
	$exp+=6;}
	$level=$this->car($chi,'livello')-$this->car($chi2,'livello');
	if($level<0){
	$liv=abs($level);
	if($liv>10)
	$liv=10;
	$exp+=round($exp/10*$liv);
	}elseif($level>0){
	if($liv>9)
	$liv=9;
	$exp-=round($exp/10*$liv);
	}
	$db->QueryMod("UPDATE caratteristiche SET exp=exp+'".$exp."' WHERE userid='".$this->id($chi)."' LIMIT 1");
	$input=sprintf($lang['exp_guadagnata'],$this->nome($chi),$exp)."<br/>";
	return $input;
	} //fine Guadagnaexp
	
	public function Viewequip($chi) {
	global $lang;
	if($this->equip($chi,'cac')!=0 OR $this->equip($chi,'arm')!=0 OR $this->equip($chi,'scu')!=0){
	if($this->equip($chi,'cac')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'cac').'_nome'];
	if($this->equip($chi,'arm')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'arm').'_nome'];
	if($this->equip($chi,'scu')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'scu').'_nome'];
	}else{$equip=$lang['nessuno'];}
	$input=sprintf($lang['equip_di'],$this->nome($chi),$this->car($chi,'livello'),$equip)."<br/>";
	return $input;
	} //fine Viewequip
	
	public function Checkrep($chi) {
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$level=$this->car($chi,'livello')-$this->car($chi2,'livello');
	$liv=abs($level);
	$rep[1]=floor($liv/2);
	if($liv<=2){
	$rep[0]=0;//pari
	}elseif($level<0){
	$rep[0]=1;//più debole
	}elseif($level>0){
	$rep[0]=2;//più forte
	}
	return $rep;
	} //fine Checkrep
	
	public function Checkeqipexp($expb){
	//controllo armi
	if($this->equip(1,'cac')!=0)
	$expb+=0.5;
	if($this->equip(2,'cac')!=0)
	$expb+=0.5;
	//controllo difese
	if($this->equip(1,'arm')!=0 OR $this->equip(1,'scu')!=0)
	$expb+=0.5;
	if($this->equip(2,'arm')!=0 OR $this->equip(2,'scu')!=0)
	$expb+=0.5;
	$expb=floor($expb);
	return $expb;
	} //fine Checkeqipexp
	
	public function Checkturnexp($expb){
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	if ($percenergia<5)
	$this->che[$chi]->esausto=1;
	if ($this->car($chi,'saluteattuale')<1)
	$this->che[$chi]->morto=1;
	//energia
	if( (($this->che[$chi]->energiai(1)-$this->car(1,'energia'))+($this->che[$chi]->energiai(2)-$this->car(2,'energia')))>100 )
	$expb+=0.5;
	//controllo difese
	if( ($this->che[$chi]->salutei(2)-$this->car(2,'saluteattuale'))>5 )
	$expb+=0.5;
	if( ($this->che[$chi]->salutei(2)-$this->car(2,'saluteattuale'))>5 )
	$expb+=0.5;
	if( (($this->che[$chi]->salutei(2)-$this->car(2,'saluteattuale'))+($this->che[$chi]->salutei(2)-$this->car(2,'saluteattuale')))>30 )
	$expb+=0.5;
	$expb=floor($expb);
	return $expb;
	} //fine Checkturnexp
	
	public function Attaccovicino($att,$dif) {
	global $db,$lang;
	if($this->equip($att,'cac')!=0){
	$arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($att,'cac')."' LIMIT 1");
	$energia=$arma['energia'];
	}
	if($this->equip($att,'cac')!=0 AND $this->car($att,'energia')>$energia){
	$danno=$arma['danno'];
	$nomearma=$lang['oggetto'.$this->equip($att,'cac').'_nome'];
	$this->Ogginuso($att,'cac');
	}else{
	$danno=rand(1,2)+round($this->car($att,'attfisico')/80);
	$nomearma=$lang['pugno'];
	$energia=50;
	}
	$casuale=rand(1,10);if($casuale==1){$colpisci=100;}elseif($casuale==10){$colpisci=0;}else{//casualità totale per minima prob colpire o non colpire cmq
	$colpisci=rand(1,100)+($this->car($att,'agilita')/5-$this->car($dif,'agilita')/5)+($this->car($att,'velocita')/15-$this->car($dif,'velocita')/15);
	if($this->equip($att,'cac')!=0 AND $arma['bonuseff']!=0)
	$colpisci+=$colpisci/100*$arma['bonuseff'];
	if($this->tattica($dif,1)==3 AND $this->esausto($dif)==0)
	$colpisci-=rand(5,20);
	if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
	$colpisci-=20;
	if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20)
	$colpisci+=20;
	if((100/$this->car($att,'salute')*$this->car($att,'saluteattuale'))<10)
	$colpisci-=20;
	if((100/$this->car($dif,'salute')*$this->car($dif,'saluteattuale'))<10)
	$colpisci+=20;
	}//se colpire o no non sicuro
	if($colpisci>50 OR $this->esausto($dif)==1){
	$difesamax=round($this->car($dif,'diffisica')/100);
	$difesa=rand(0,$difesamax);
	if($this->equip($dif,'arm')!=0){
	$armatura=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'arm')."' LIMIT 1");
	if($armatura['energia']<=$this->car($dif,'energia')){
	$this->Modenergia($dif,$armatura['energia']);
	$difesa+=round(rand(0,$armatura['difesafisica']));
	$this->Ogginuso($dif,'arm');
	}
	}//se il difensore ha armatura
	$pscudo="";
	if($this->esausto($dif)==0 AND $this->equip($dif,'scu')!=0){
	$this->Ogginuso($dif,'scu');
	$scudo=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'scu')."' LIMIT 1");
	$this->Modenergia($dif,$scudo['energia']);
	}//se il difensore ha scudo
	if($this->tattica($dif,1)==3){
	$probps=rand(0,40);}else{$probps=rand(0,90);}
	if($this->equip($dif,'scu')!=0 AND $probps<20 AND $this->esausto($dif)==0){
	if($scudo['energia']<=$this->car($dif,'energia')){
	$pscudo=" ".sprintf($lang['parata_con_scudo'],$this->nome($dif));
	$prob=10;
	if($this->tattica($dif,1)==3)
	$prob=50;
	$difesa+=round(rand($scudo['difesafisica']/100*$prob,$scudo['difesafisica']));
	}
	}//se il difensore ha scudo
	$danno-=$difesa;
	if($danno<1)
	$danno=1;
	$potente="";
	$probpot=rand(1,10);
	if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
	$probpot-=5;
	if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20 AND (100/$this->car($att,'energiamax')*$this->car($att,'energia'))>40)
	$probpot+=3;
	if($probpot>=10){
	$danno+=round($danno/2);
	$potente=" ".sprintf($lang['colpo_potente'],$this->nome($att));
	}//se colpo potente
	$input=sprintf($lang['danno_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma,$danno).$potente.$pscudo."<br/>";
	$this->Modsalute($dif,$danno);
	}else{
	$input=sprintf($lang['niente_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma)."<br/>";
	}
	$this->Modenergia($att,$energia);
	return $input;
	} //fine Attaccovicino
	
} //fine classe Dati

function Startcombact($attaccante,$difensore,$server) {
global $db,$adesso,$lang,$language;
$db->QueryMod("INSERT INTO battle (attid,difid) VALUES ('".$attaccante."','".$difensore."')");
$battle=$db->QuerySelect("SELECT id FROM battle WHERE attid='".$attaccante."' LIMIT 1");
$db->QueryMod("INSERT INTO battlereport (id,data,attid,difid) VALUES ('".$battle['id']."','".$adesso."','".$attaccante."','".$difensore."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','100','0','6','".$battle['id']."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$difensore."','".$adesso."','84600','13','5','".$attaccante."','".$battle['id']."')");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$attaccante."','".$adesso."','84600','13','5','".$difensore."','".$battle['id']."')");
Docombactstats($battle['id'],$attaccante,$difensore);
} //fine Startcombact

function Battledo($battleid,$turni) {
global $db,$adesso,$lang,$language;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$expb=$battle['exp'];
$dc=new Dati();
$dc->Stabilisciordine($battle['attid'],$battle['difid'],$battle);
$expb=$dc->Checkeqipexp($expb);
if($turni==0){
$input.=$dc->Viewequip(1);
$input.=$dc->Viewequip(2);}
//$input.="Debug tattiche: ".$dc->tattica(1,1)." - ".$dc->tattica(2,1)."<br/>";//visualizzazione tattiche per debug
if($dc->tattica(1,1)!=2 AND $dc->tattica(2,1)!=2){
$dc->Controllastato(1);
$dc->Controllastato(2);

if($dc->esausto(1)==1){
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(1))."<br/>";
}elseif($dc->tattica(1,1)==3){
$input.=sprintf($lang['resta_in_difesa'],$dc->nome(1))."<br/>";
}else{
$input.=$dc->Attaccovicino(1,2);
}
if($dc->esausto(2)==1){
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(2))."<br/>";
}elseif($dc->tattica(2,1)==3){
$input.=sprintf($lang['resta_in_difesa'],$dc->nome(2))."<br/>";
}else{
$input.=$dc->Attaccovicino(2,1);
}

if($dc->che[1]->oggusati==1){
$input.=$dc->Controlloogg(1);}
if($dc->che[2]->oggusati==1){
$input.=$dc->Controlloogg(2);}
$input.="<br/>";

$dc->Aggiornastat(1);
$dc->Aggiornastat(2);
$dc->Controllastato(1);
$dc->Controllastato(2);
$expb+=$dc->Checkturnexp($expb);

$turni++;
$input.="---------------------------------<( ".($turni+1)." )>---------------------------------";
Inreport($battleid,$input);
$input="";
Docombactstats($battleid,$dc->id(1),$dc->id(2));
}//se nessuno si arrende
$finito=1;
if($dc->tattica(1,1)==2 AND $dc->tattica(2,1)==2){//se entrambi si arrendono
$input=$lang['finito_entrambi_arresi']."<br/>";
}elseif($dc->tattica(1,1)==2){//se il primo si arrende
$input.=sprintf($lang['finito_resa'],$dc->nome(1),$dc->nome(2))."<br/>";
$dc->Impobexp(1,1);//diminuzione al primo
$dc->Impobexp(2,2);//aumento al secondo
$rep=$dc->Checkrep(1);
if($rep[0]==2)
$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione-'".$rep[1]."' WHERE userid='".$this->id(1)."' LIMIT 1");
}elseif($dc->tattica(2,1)==2){//se il secondo si arrende
$input.=sprintf($lang['finito_resa'],$dc->nome(2),$dc->nome(1))."<br/>";
$dc->Impobexp(2,1);//diminuzione al secondo
$dc->Impobexp(1,2);//aumento al primo
$rep=$dc->Checkrep(2);
if($rep[0]==2)
$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione-'".$rep[1]."' WHERE userid='".$this->id(2)."' LIMIT 1");
}elseif($dc->esausto(1)==1 AND $dc->esausto(2)==1){//se entrambi esausti
$input=$lang['finito_entrambi_esausti']."<br/>";
}elseif($dc->morto(1)==1){//se il secondo vince
$input.=sprintf($lang['vincitore_combattimento'],$dc->nome(2))."<br/>";
$dc->Impobexp(2,2);//aumento al secondo
$rep=$dc->Checkrep(2);
if($rep[0]==1)
$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione+'".$rep[1]."' WHERE userid='".$this->id(2)."' LIMIT 1");
}elseif($dc->morto(2)==1){//se il primo vince
$input.=sprintf($lang['vincitore_combattimento'],$dc->nome(1))."<br/>";
$dc->Impobexp(1,2);//aumento al primo
$rep=$dc->Checkrep(1);
if($rep[0]==1)
$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione+'".$rep[1]."' WHERE userid='".$this->id(1)."' LIMIT 1");
}elseif($turni==25){//se dura troppo
$input=$lang['combattimento_troppo_lungo']."<br/>";
}else{$finito=0;}
$db->QueryMod("UPDATE battle SET tatatt='0',tatatt2='0',tatdif='0',tatdif2='0' WHERE id='".$battleid."' LIMIT 1");
if($finito==1){
if($turni>1){
$input.=$dc->Guadagnaexp(1,$turni,$expb);
$input.=$dc->Guadagnaexp(2,$turni,$expb);
}//se più di un turno
Endcombact($battle['id'],$dc->pvar(1),$dc->pvar(2));
Inreport($battleid,$input);
}else{//continua
if($expb!=$battle['exp']){
$db->QueryMod("UPDATE battle SET exp='".$expb."' WHERE id='".$battleid."' LIMIT 1");}
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid,turni) VALUES ('0','".$adesso."','100','0','6','".$battleid."','".$turni."')");
}//fine continua
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
$db->QueryMod("UPDATE battlereport SET finito='1' WHERE id='".$battleid."' LIMIT 1");
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
