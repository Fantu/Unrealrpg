<?php
require_once('inclusi/funzioni_oggetti.php');

function Completalavminnuova($userid) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$paga=6;
$energia=100-(5*$usercar['minatore']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['minatore'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/10+$usercar['energia']/100+$usercar['attfisico']/5);
$exp=floor(rand($exp/2,$exp));
$exp+=(5*$usercar['minatore']);
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['attfisico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span>";
}else{
$danni=rand(20,30)-rand(floor($resistenza/2),floor($resistenza));
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
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expminatore=t3.expminatore+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t1.userid='".$userid."'");
} //fine Completalavminnuova

function Completalavlabapp($userid) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_laboratorio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$paga=6;
$mana=rand(5,10);
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['difmagica']/20;
$salute=rand(2,10)-($usercar['alchimista'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/10+$usercar['energia']/100+$usercar['attmagico']/7+$usercar['intelligenza']/15);
$exp=floor(rand($exp/2,$exp));
$exp+=(5*$usercar['alchimista']);
$esplosione=rand(30,100)-($usercar['alchimista']*5)-($usercar['attmagico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['alchimista']*5)-($usercar['agilita']/20)-($usercar['attmagico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_esplosione_lab1']."</span>";
}else{
$danni=rand(20,30)-rand(floor($resistenza/2),floor($resistenza));
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
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."',t3.manarimasto=t3.manarimasto-'".$mana."' WHERE t1.userid='".$userid."'");
} //fine Completalavlabapp

function Completatempioprega($userid) {
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
$fede=100;
$dono=1;
$miracolo=rand(0,1000)-($usercar['fede']/100);
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
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.fede=t3.fede+'".$fede."',t2.monete=t2.monete-'".$dono."',t3.energia='".$energia."',t3.saluteattuale='".$salute."',t3.recuperoenergia='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto='".$mana."' WHERE t2.userid='".$userid."'");
} //fine Completatempioprega

function Completaresurrezione($userid) {
global $db,$adesso;
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t2.resuscita='0',t3.energia=t3.energiamax,t3.saluteattuale=t3.salute,t3.recuperoenergia='".$adesso."',t3.recuperosalute='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto=t3.mana WHERE t2.userid='".$userid."'");
} //fine Completaresurrezione

function Completalavminvecchia($userid) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$energia=70-(5*$usercar['minatore']);
if ($energia<30)
$energia=30;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['minatore'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/10+$usercar['energia']/100+$usercar['attfisico']/5);
$exp=floor(rand($exp/2,$exp));
$exp+=(5*$usercar['minatore']);
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['attfisico']/20);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['minatore']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span>";
}else{
$danni=rand(20,30)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_min2'],$danni)."</span>";	
}
$titolo=$lang['report_incidente_miniera'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$piccone=$db->QuerySelect("SELECT t1.oggid AS oggid,t2.bonuseff AS bonuseff,t2.energia AS energia FROM inoggetti AS t1 JOIN oggetti t2 ON t1.oggid=t2.id WHERE t1.userid='".$userid."' AND t2.tipo='2' AND t2.categoria='1'  AND t1.inuso='1' LIMIT 1");
$efficenza=($usercar['minatore']*1000)+($usercar['attfisico']*2);
$efficenza+=($efficenza/100*$piccone['bonuseff']);
$energia+=$piccone['energia'];
$trovare=rand(0,10000)-$efficenza;
if($trovare<10){
$trovato=1;}else{
$trovato=0;}
$testo=sprintf($lang['report_lavminieravecchia'],$exp,$energia,$salute)."<br />";
if($trovato==0){
$testo.=$lang['report_lavminieravecchia_materiali_no']."<br />";
}else{//inizio trovato minerale
$efficenza=rand(0,1+($usercar['minatore']*500));
if($efficenza>9000)
$efficenza=9000;
$trovare=rand(0,9999)-$efficenza;
$numeromin=0;
$oggminerali=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='1' AND categoria='1' AND probtrovare>'".$trovare."'");
while($oggminerale=$db->QueryCicloResult($oggminerali)) {
$numeromin++;	
$picconi['id'][$numeromin]=$oggminerale['id'];
$picconi['nome'][$numeromin]=$lang['oggetto'.$oggminerale['id'].'_nome'];
}
$numeromin=rand(1,$numeromin);
$minerale=$picconi['nome'][$numeromin];
$quantimin=rand(1,2+floor($usercar['minatore']/3));
for($i=1; $i<=$quantimin; $i++){
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$picconi['id'][$numeromin]."','".$userid."')");
}
$testo.=sprintf($lang['report_lavminieravecchia_materiali_si'],$quantimin,$minerale)."<br />";
}//fine trovato minerale
$oggpersi=Checkusurarottura($userid);
$testo="<span>".$testo.$oggpersi."</span>";
$titolo=$lang['report_lavoro_vecchia'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expminatore=t3.expminatore+'".$exp."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t1.userid='".$userid."'");
} //fine Completalavminvecchia

function Completalavfucapp($userid) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_fucina.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");	
$paga=6;
$energia=100-(5*$usercar['fabbro']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['diffisica']/20;
$salute=rand(5,15)-($usercar['fabbro'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/10+$usercar['energia']/100+$usercar['attfisico']/15)+($usercar['destrezza']/10)+($usercar['intelligenza']/20);
$exp=floor(rand($exp/2,$exp));
$exp+=(5*$usercar['minatore']);
$esplosione=rand(30,100)-($usercar['fabbro']*5)-($usercar['attfisico']/20)-($usercar['destrezza']/10);
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['fabbro']*5)-($usercar['agilita']/20)-($usercar['attfisico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_fuc1']."</span>";
}else{
$danni=rand(20,30)-rand(floor($resistenza/2),floor($resistenza));
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
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expfabbro=t3.expfabbro+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t1.userid='".$userid."'");
} //fine Completalavfucapp

function Completalavlabalc($userid,$pozionesel) {
global $db,$adesso,$lang,$language;
require_once('language/'.$language.'/lang_laboratorio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$pozione=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$pozionesel."' LIMIT 1");
$mana=rand(5,10);
$costo=floor($pozione['costo']/5);
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$resistenza=$usercar['difmagica']/20;
$salute=rand(2,10)-($usercar['alchimista'])-rand(floor($resistenza/2),floor($resistenza));
if ($salute<1)
$salute=1;
$exp=floor($usercar['saluteattuale']/10+$usercar['energia']/100+$usercar['attmagico']/7+$usercar['intelligenza']/15);
$exp=floor(rand($exp/2,$exp));
$exp+=(5*$usercar['alchimista']);
$testo=sprintf($lang['report_lavlabalc'],$exp,$energia,$salute,$mana,$costo)."<br />";
$bonusabilita=$usercar['alchimista']-$pozione['abilitanec'];
if($bonusabilita>0)
$bonusabilita=$bonusabilita*30;
$esplosione=rand(30,100)-$bonusabilita-($usercar['attmagico']/20)-$usercar['intelligenza']/20;
$danni=0;
if($esplosione>10){
$esplosione=rand(30,100)-($usercar['alchimista']*5)-($usercar['agilita']/20)-($usercar['attmagico']/10)-($usercar['velocita']/50);
if($esplosione<10){
$testo2="<span>".$lang['report_esplosione_lab1']."</span>";
}else{
$danni=rand(20,30)-rand(floor($resistenza/2),floor($resistenza));
if ($danni<1)
$danni=1;	
$testo2="<span>".sprintf($lang['report_esplosione_lab2'],$danni)."</span>";	
}
$titolo=$lang['report_esplosione_laboratorio'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo2."','0','".$adesso."')");	
$testo.=$lang['report_lavlab_pozione_no']."<br />";
$exp=floor($exp/2);
}/*fine esplosione*/else{
$exp=$exp*2;
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$pozione['id']."','".$userid."')");
$nomepozione=$lang['oggetto'.$pozione['id'].'_nome'];
$testo.=sprintf($lang['report_lavlab_pozione_si'],$nomepozione)."<br />";
}//fine pozione riuscita
$oggpersi=Checkusurarottura($userid);
$testo="<span>".$testo.$oggpersi."</span>";
$titolo=$lang['report_lavoro_labalc'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete-'".$costo."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."',t3.manarimasto=t3.manarimasto-'".$mana."' WHERE t1.userid='".$userid."'");
} //fine Completalavlabalc
?>