<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('inclusi/funzioni_oggetti.php');
require_once('inclusi/funzioni_magia.php');

function Completalavminnuova($userid,$ore) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$paga=7;
$energia=100-(5*$usercar['minatore']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['minatore'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attfisico']/8);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['minatore']);
$esplosione=rand(30,110)-($usercar['minatore']*5)-($usercar['attfisico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_min2'],$danni)."</span>";	
}
$titolo=$lang['report_incidente_miniera'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$testo="<span>".sprintf($lang['report_lavminieranuova'],$paga,$exp,$energia,$salute)."</span>";
$titolo=$lang['report_lavoro_nuova'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expminatore=t3.expminatore+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t2.userid='".$userid."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$paga."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['miniera_errore2'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$userid."','".$adesso."','3600','1','1','1','".$ore."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavminnuova

function Completalavlabapp($userid,$ore) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_laboratorio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$paga=7;
$mana=rand(5,10);
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['difmagica']/20;
$salute=rand(2,10)-($usercar['alchimista'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attmagico']/13+$usercar['intelligenza']/20);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['alchimista']);
$esplosione=rand(30,110)-($usercar['alchimista']*5)-($usercar['attmagico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['alchimista']*5)-($usercar['agilita']/20)-($usercar['attmagico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_esplosione_lab1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_esplosione_lab2'],$danni)."</span>";	
}
$titolo=$lang['report_esplosione_laboratorio'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine esplosione
$testo="<span>".sprintf($lang['report_lavlabapp'],$paga,$exp,$energia,$salute,$mana)."</span>";
$titolo=$lang['report_lavoro_labapp'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."',t3.manarimasto=t3.manarimasto-'".$mana."' WHERE t2.userid='".$userid."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$paga."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<100)
$errore .= $lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['lab_errore2'];
if ($usercar['mana']<10)
$errore .= $lang['lab_errore4'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$userid."','".$adesso."','3600','2','1','2','".$ore."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavlabapp

function Completatempioprega($userid,$ore) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_tempio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$mana=$usercar['mana'];
if($usercar['manarimasto']!=$usercar['mana']){
$mana=floor($usercar['mana']/10);
$mana+=$usercar['manarimasto'];
if($mana>$usercar['mana'])
$mana=$usercar['mana'];
}
$energiapersa=10;
$energia=$usercar['energia']-$energiapersa;
$salute=$usercar['saluteattuale'];
$fedeg=100;
$dono=1;
$fede=$usercar['fede']/100;
if($fede>100)
$fede=100;
$miracolo=rand(2,1000)-$fede;
$titolo=$lang['report_tempio_preghiera'];
if($miracolo<1){
$mana=$usercar['mana'];
$salute=$usercar['salute'];
$energia=$usercar['energiamax'];
$testo="<span>".$lang['report_manifestazione_divina']."</span>";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine manifestazione divina
else{
$testo="<span>".sprintf($lang['report_preghiera_normale'],$dono,$energiapersa)."</span>";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}//fine se niente manifestazione divina
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.fede=t3.fede+'".$fedeg."',t2.monete=t2.monete-'".$dono."',t3.energia='".$energia."',t3.saluteattuale='".$salute."',t3.recuperoenergia='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto='".$mana."' WHERE t2.userid='".$userid."'");
if($ore>1){
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,ore) VALUES ('".$userid."','".$adesso."','3600','3','2','".$ore."')");	
}//fine se la coda ha almeno un altra ora
} //fine Completatempioprega

function Completaresurrezione($userid) {
global $db,$adesso;
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$userid."' LIMIT 1");
if ($user['resuscita']=='1'){
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t2.resuscita='0',t3.energia=t3.energiamax,t3.saluteattuale=t3.salute,t3.recuperoenergia='".$adesso."',t3.recuperosalute='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto=t3.mana WHERE t2.userid='".$userid."'");
}else{
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if($usercar['fede']<5000){
$mana=$usercar['manarimasto'];
$salute=round($usercar['salute']/2);
$energia=round($usercar['energiamax']/2);
}else{
$bonus=10*($usercar['fede']/5000);
$mana=$usercar['manarimasto']+round($usercar['mana']/100*$bonus);
if($mana>$usercar['mana'])
$mana=$usercar['mana'];
$salute=$usercar['saluteattuale']+round($usercar['salute']/100*$bonus);
if($salute>$usercar['salute'])
$salute=$usercar['salute'];
$energia=$usercar['energia']+round($usercar['energiamax']/100*$bonus);
if($energia>$usercar['energiamax'])
$energia=$usercar['energiamax'];
}
$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."',saluteattuale='".$salute."',recuperoenergia='".$adesso."',recuperosalute='".$adesso."',decfede='".$adesso."',manarimasto='".$mana."' WHERE userid='".$userid."'");
}
} //fine Completaresurrezione

function Completalavminvecchia($userid,$piccone,$ore) {
global $db,$adesso,$lang,$language;
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$piccone."' ORDER BY usura DESC LIMIT 1");	
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='1' ORDER BY usura DESC LIMIT 1");
require_once('language/'.$language.'/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$energia=70-(5*$usercar['minatore']);
if ($energia<30)
$energia=30;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['minatore'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attfisico']/8);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['minatore']);
$esplosione=rand(30,110)-($usercar['minatore']*5)-($usercar['attfisico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_min2'],$danni)."</span>";	
}
$titolo=$lang['report_incidente_miniera'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$piccone2=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$piccone."' LIMIT 1");
$efficenza=($usercar['minatore']*1500)+($usercar['attfisico']*2);
$efficenza+=($efficenza/100*$piccone2['bonuseff']);
if($efficenza>9950)
$efficenza=9950;
$energia+=$piccone2['energia'];
$trovare=rand(0,10000)-$efficenza;
if($trovare<10){
$trovato=1;
$exp+=floor($exp/100*20);
}else{
$trovato=0;
$exp-=floor($exp/100*20);}
$testo=sprintf($lang['report_lavminieravecchia'],$exp,$energia,$salute)."<br />";
if($trovato==0){
$testo.=$lang['report_lavminieravecchia_materiali_no']."<br />";
}else{//inizio trovato minerale
$efficenza=rand(0,1+($usercar['minatore']*400));
$efficenza+=($efficenza/100*$piccone2['bonuseff']);
if($efficenza>7000)
$efficenza=7000;
$trovare=rand(0,9999)-$efficenza;
$oggminerali=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='1' AND categoria='1' AND probtrovare>'".$trovare."'");
while($oggminerale=$db->QueryCicloResult($oggminerali)) {	
$minerali[]=$oggminerale['id'];
}
shuffle($minerali);
$minerale=$lang['oggetto'.$minerali[0].'_nome'];
$quantimin=rand(1,2+floor($usercar['minatore']/3));
for($i=1; $i<=$quantimin; $i++){
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$minerali[0]."','".$userid."')");
}
$testo.=sprintf($lang['report_lavminieravecchia_materiali_si'],$quantimin,$minerale)."<br />";
}//fine trovato minerale
$oggpersi=Checkusurarottura($userid,0);
$testo="<span>".$testo.$oggpersi."</span>";
$titolo=$lang['report_lavoro_vecchia'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expminatore=t3.expminatore+'".$exp."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t2.userid='".$userid."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<200)
$errore .= $lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['miniera_errore2'];
$picconesel=$db->QuerySelect("SELECT COUNT(id) AS num FROM inoggetti WHERE oggid='".$piccone."' AND userid='".$userid."'");
if ($picconesel['num']<1)
$errore.=$lang['miniera_errore5'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$userid."','".$adesso."','3600','5','1','3','".$piccone."','".$ore."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavminvecchia

function Completalavfucapp($userid,$ore) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_fucina.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$paga=7;
$energia=100-(5*$usercar['fabbro']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['fabbro'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attfisico']/30+$usercar['destrezza']/20+$usercar['intelligenza']/40);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['fabbro']);
$esplosione=rand(30,110)-($usercar['fabbro']*5)-($usercar['attfisico']/20)-($usercar['destrezza']/10);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['fabbro']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_fuc1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_fuc2'],$danni)."</span>";	
}
$titolo=$lang['report_incidente_fucina'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$testo="<span>".sprintf($lang['report_lav_fuc_app'],$paga,$exp,$energia,$salute)."</span>";
$titolo=$lang['report_lavoro_fucina_app'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expfabbro=t3.expfabbro+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t2.userid='".$userid."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$paga."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['fucina_errore2'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$userid."','".$adesso."','3600','6','1','4','".$ore."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavfucapp

function Completalavlabalc($userid,$pozionesel,$ore) {
global $db,$adesso,$lang,$language;
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='36' ORDER BY usura DESC LIMIT 1");
require_once('language/'.$language.'/lang_laboratorio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$pozione=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$pozionesel."' LIMIT 1");
$nomepozione=$lang['oggetto'.$pozione['id'].'_nome'];
$mana=rand(5,10);
$costo=floor($pozione['costo']/5);
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['difmagica']/20;
$salute=rand(2,10)-($usercar['alchimista'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attmagico']/13+$usercar['intelligenza']/20);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['alchimista']);
$bonusabilita=$usercar['alchimista']-$pozione['abilitanec'];
if($bonusabilita>0)
$bonusabilita=$bonusabilita*17;
if($bonusabilita>70)
$bonusabilita=70;
$esplosione=rand(70,100)-$bonusabilita-($usercar['attmagico']/15)-$usercar['intelligenza']/25;
$danni=0;
$probinc=rand(1,10);
if($esplosione>10 OR $probinc==10){
$esplosione=rand(30,110)-($usercar['alchimista']*5)-($usercar['agilita']/20)-($usercar['attmagico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo2="<span>".$lang['report_esplosione_lab1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo2="<span>".sprintf($lang['report_esplosione_lab2'],$danni)."</span>";	
}
$titolo=$lang['report_esplosione_laboratorio'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo2."','0','".$adesso."')");	
$testo3=sprintf($lang['report_lavlab_pozione_no'],$nomepozione)."<br />";
$exp-=floor($exp/100*20);
}/*fine esplosione*/else{
$exp+=floor($exp/100*20);
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$pozione['id']."','".$userid."')");
$testo3=sprintf($lang['report_lavlab_pozione_si'],$nomepozione)."<br />";
}//fine pozione riuscita
$testo=sprintf($lang['report_lavlabalc'],$exp,$energia,$salute,$mana,$costo)."<br />";
$testo.=$testo3;
$oggpersi=Checkusurarottura($userid,0);
$testo="<span>".$testo.$oggpersi."</span>";
$titolo=$lang['report_lavoro_labalc'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete-'".$costo."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."',t3.manarimasto=t3.manarimasto-'".$mana."' WHERE t2.userid='".$userid."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['lab_errore2'];
if ($usercar['mana']<10)
$errore.=$lang['lab_errore4'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore,oggid) VALUES ('".$userid."','".$adesso."','3600','7','1','5','".$ore."','".$pozionesel."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavlabalc

function Completaroccastudia($userid,$elementosel,$ore) {
global $db,$adesso,$lang,$language,$elementi;
require_once('language/'.$language.'/lang_rocca.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$energia=100-(5*$usercar['magica']);
if($energia<50)
$energia=50;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attmagico']/12+$usercar['intelligenza']/15);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['magica']);
$testo="<span>".sprintf($lang['report_lavstudiorocca'],$exp,$elementi[$elementosel],$energia)."</span>";
$titolo=$lang['report_lavoro_roccastudio'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$db->QueryMod("UPDATE caratteristiche SET expmagica=expmagica+'".$exp."',expelmagico".$elementosel."=expelmagico".$elementosel."+'".$exp."',energia=energia-'".$energia."',recuperosalute='".$adesso."',recuperoenergia='".$adesso."' WHERE userid='".$userid."'");
Controllamagieconosciute($userid,$elementosel);
if($ore>1){
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$userid."','".$adesso."','3600','8','1','6','".$elementosel."','".$ore."')");
}//fine se deve lavorare ancora
} //fine Completaroccastudia

function Completalavfucfab($userid,$oggdf,$ore,$materiale) {
global $db,$adesso,$lang,$language,$materiali_num,$oggdf_num;
require_once('language/'.$language.'/lang_fucina.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if($materiali_num[$materiale][1]>0)
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='2' LIMIT ".$materiali_num[$materiale][1]);
if($materiali_num[$materiale][2]>0)
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='3' LIMIT ".$materiali_num[$materiale][2]);
if($materiali_num[$materiale][3]>0)
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='4' LIMIT ".$materiali_num[$materiale][3]);
if($materiali_num[$materiale][4]>0)
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='10' LIMIT ".$materiali_num[$materiale][4]);
$energia=100-(5*$usercar['fabbro']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['fabbro'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attfisico']/30+$usercar['destrezza']/20+$usercar['intelligenza']/40);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['fabbro']);
$bonusabilita=$usercar['fabbro']*7;
if($bonusabilita>50)
$bonusabilita=50;
$esplosione=rand(30,110)-$bonusabilita-($usercar['attfisico']/20)-($usercar['destrezza']/10)-($usercar['intelligenza']/40);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['fabbro']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo2="<span>".$lang['report_incidente_fuc1']."</span>";
}else{
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo2="<span>".sprintf($lang['report_incidente_fuc2'],$danni)."</span>";	
}
$titolo2=$lang['report_incidente_fucina'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo2."','".$testo2."','0','".$adesso."')");	
$testo=$lang['report_lavfuc_forgia_no']."<br />";
$exp-=floor($exp/100*20);
}/*fine incidente*/else{//inizio forgia riuscita
$exp+=floor($exp/100*20);
$oggettodf=$db->QuerySelect("SELECT * FROM oggetti WHERE tipo='".$oggdf_num[$oggdf][1]."' AND categoria='".$oggdf_num[$oggdf][2]."' AND materiale='".$materiale."' AND abilitanec<='".$usercar['fabbro']."' ORDER BY abilitanec DESC LIMIT 1");
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$oggettodf['id']."','".$userid."')");
$nomeoggetto=$lang['oggetto'.$oggettodf['id'].'_nome'];
$testo=sprintf($lang['report_lavfuc_forgia_si'],$nomeoggetto)."<br />";
}//fine forgia riuscita
$oggpersi=Checkusurarottura($userid,0);
$testo="<span>".$testo.$oggpersi."</span>";
$titolo=$lang['report_lavoro_fucina_fab'];
$testo1=sprintf($lang['report_lav_fuc_fab'],$exp,$energia,$salute)."<br />";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo1.$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.expfabbro=t3.expfabbro+'".$exp."',t2.monete=t2.monete-'1',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t2.userid='".$userid."'");
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['fucina_errore2'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore,oggid,type) VALUES ('".$userid."','".$adesso."','3600','9','1','7','".$ore."','".$oggdf."','".$materiale."')");
}//fine continua lavoro
}//fine se la coda ha almeno un altra ora
} //fine Completalavfucfab

function Completaroccapratica($userid,$elementosel,$ore,$tiposel) {
global $db,$adesso,$lang,$language,$elementi,$tipimagia;
require_once('language/'.$language.'/lang_rocca.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$energia=100-(5*$usercar['magica']);
if($energia<50)
$energia=50;
$exp=floor($usercar['saluteattuale']/30+$usercar['energia']/200+$usercar['attmagico']/12+$usercar['intelligenza']/15);
$exp=floor(rand(($exp/100*80),$exp));
$exp+=10+(2*$usercar['magica']);
$trovato=0;
$riuscito=0;
$danni=0;
$inmagie=$db->QuerySelect("SELECT COUNT(id) AS num FROM inmagia WHERE userid='".$userid."' AND stato='0'");
if($inmagie['num']>0){
$inmagieq=$db->QueryCiclo("SELECT * FROM inmagia WHERE userid='".$userid."' AND stato='0'");
while($chem=$db->QueryCicloResult($inmagieq)) {
	$inmagie[$chem['magid']]=$chem['magid'];
}//fine mostra risultati
$magieq=$db->QueryCiclo("SELECT * FROM magia WHERE elemento='".$elementosel."'");
while($chem=$db->QueryCicloResult($magieq)) {
	$magie[$chem['id']]=$chem['tipo'];
}//fine mostra risultati
foreach($inmagie as $chiave=>$elemento){
if($magie[$chiave]==$tiposel AND isset($magie[$chiave])){
$trovato=1;
$magiasel=$elemento;
}//se corrispondente
}//mostra ogni magia
if($trovato==0){
foreach($inmagie as $chiave=>$elemento){
if(isset($magie[$chiave])){
$trovato=1;
$magiasel=$elemento;
}//se stesso elemento
}//mostra ogni magia
}//se nn ha già trovato
}//fine se ci sono magie
if($trovato==1){
$magia=$db->QueryCiclo("SELECT * FROM magia WHERE id='".$magiasel."'");
$bonusabilita=$usercar['magica']-$magia['abilitanec'];
if($bonusabilita>0)
$bonusabilita=$bonusabilita*30;
$esplosione=rand(60,100)-$bonusabilita-($usercar['attmagico']/20)-$usercar['intelligenza']/20;
if($esplosione<10){
$riuscito=1;
$db->QueryMod("UPDATE inmagia SET stato='1' WHERE userid='".$userid."' AND magid='".$magiasel."'");
$testo3="<br />".sprintf($lang['report_lavroc_magia_si'],$lang['magia'.$magiasel]);
}//se riuscito
}//se trovata una magia
if($riuscito==0){
$esplosione=rand(30,100)-($usercar['magica']*5)-($usercar['agilita']/20)-($usercar['attmagico']/10);
if($esplosione<10){
$testo2="<span>".$lang['report_esplosione_roc1']."</span>";
}else{
$resistenza=$usercar['difmagica']/20;
$danni=rand(20,25)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo2="<span>".sprintf($lang['report_esplosione_roc2'],$danni)."</span>";	
}
$titolo=$lang['report_esplosione_rocca'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo2."','0','".$adesso."')");	
$testo3="<br />".$lang['report_lavroc_magia_no'];
}

$testo="<span>".sprintf($lang['report_lavpraticarocca'],$exp,$elementi[$elementosel],$energia).$testo3."</span>";
$titolo=$lang['report_lavoro_roccapratica'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$db->QueryMod("UPDATE caratteristiche SET saluteattuale=saluteattuale-'".$danni."',expmagica=expmagica+'".$exp."',expelmagico".$elementosel."=expelmagico".$elementosel."+'".$exp."',energia=energia-'".$energia."',recuperosalute='".$adesso."',recuperoenergia='".$adesso."' WHERE userid='".$userid."'");
Controllamagieconosciute($userid,$elementosel);
if($ore>1){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($usercar['saluteattuale']<30)
$errore.=$lang['rocca_errore5'];
if($errore){
$testo=$lang['outputerrori_continualav']."<br />".$errore;
$titolo=$lang['Impossibile_lavorare_ancora'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
else {
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore,type) VALUES ('".$userid."','".$adesso."','3600','10','1','8','".$elementosel."','".$ore."','".$tiposel."')");
}//fine continua lavoro
}//fine se deve lavorare ancora
} //fine Completaroccapratica

function Completasfida($userid,$eid) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_combact.php');
$sfida=$db->QuerySelect("SELECT * FROM eventi WHERE id='".$eid."' LIMIT 1");
$sfidante=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$sfida['oggid']."' LIMIT 1");
if($sfida['type']==1){
$titolo=$lang['sfida_annullata'];
$testo=sprintf($lang['report_sfida_annullata1'],$sfidante['username']);
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}else{//se dello sfidante
$titolo=$lang['sfida_annullata'];
$testo=sprintf($lang['report_sfida_annullata2'],$sfidante['username']);
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}
} //fine Completasfida

function Completadormire($userid,$ore){
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_locanda.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
if($usercar['saluteattuale']<=$usercar['salute']){
$salute=$usercar['saluteattuale']+round($usercar['salute']/100*2);
if($salute>$usercar['salute'])
$salute=$usercar['salute'];
}else{$salute=$usercar['salute'];}
if($usercar['energia']<=$usercar['energiamax']){
$energia=$usercar['energia']+round($usercar['energiamax']/1000*200);
if($energia>$usercar['energiamax'])
$energia=$usercar['energiamax'];
}else{$energia=$usercar['energiamax'];}
$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."',saluteattuale='".$salute."',recuperosalute='".$adesso."',recuperoenergia='".$adesso."' WHERE userid='".$userid."'");
if($ore>1){
$ore--;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,ore) VALUES ('".$userid."','".$adesso."','3600','14','7','".$ore."')");
}//fine se la coda ha almeno un altra ora
} //fine Completadormire

function Completaquest($userid,$qid,$secondi){
global $db,$adesso,$lang;
$prob=rand(1,100);
$titolo=$lang['le_montagne'];
$energia=$secondi/100*3;
$db->QueryMod("UPDATE caratteristiche SET energia=energia-'".$energia."' WHERE userid='".$userid."'");
if($prob==100){
$monete=rand(5,100);
$testo=sprintf($lang['oconfini_trovato_tesoro'],$monete)."<br />";
$db->QueryMod("UPDATE utenti SET monete=monete+'".$monete."' WHERE userid='".$userid."'");
}elseif($prob<40){
$pq=$db->QueryCiclo("SELECT id FROM pcpudata WHERE quest='1'");
while($ps=$db->QueryCicloResult($pq)) {	
$prs[]=$ps['id'];
}
shuffle($prs);
$pcpuid=$prs[0];
$npcid=Npcesistente($pcpuid);
if($npcid==0){$npcid=Inizializzanpc($pcpuid);}
Startcombact($userid,$npcid,1);
$db->QueryMod("INSERT INTO cachequest (userid,secondi) VALUES ('".$userid."','".$secondi."')");
}else{
$testo=$lang['oconfini_trovato_nulla']."<br />";
}
if($prob>=40){
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
Ritornoacasa($userid,$secondi);
}
} //fine Completaquest

function Ritornoacasa($userid,$secondi){
global $db,$adesso;
$energia=$secondi/100*3;
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
if($usercar['energia']<(50+$energia)){
$energiam=($energia+50)-$usercar['energia'];
$secondi2=100+($energia*60);
$energia=50;
}else{
$secondi2=$secondi;
$energia=$usercar['energia']-$energia;
}
$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."',recuperosalute='".($adesso+$secondi)."',recuperoenergia='".($adesso+$secondi)."' WHERE userid='".$userid."'");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo) VALUES ('".$userid."','".$adesso."','".$secondi2."','16','9')");	
} //fine Completaquest
?>