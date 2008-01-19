<?php
function Completalavminnuova($userid) {
global $db,$adesso;
require('language/it/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 0,1");	
$paga=5;
$energia=100-(5*$usercar['minatore']);
if ($energia<50)
$energia=50;
$salute=(rand(2,10))-($usercar['minatore'])-(rand(0,floor($usercar['diffisica']/20)));
if ($salute<1)
$salute=1;
$exp=rand(5,(2+floor($usercar['saluteattuale']/10)+floor($usercar['energia']/100)+floor($usercar['attfisico']/10)));
$exp+=(5*(rand(0,(1+$usercar['minatore']))));
$esplosione=rand(10,100)-($usercar['minatore']*5)-($usercar['attfisico']/2);
$danni=0;
if($esplosione>10){
$esplosione=rand(10,100)-($usercar['agilita']/5)-($usercar['attfisico']/2);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span><br /><br />";
}else{
$danni=rand(5,30)-rand(0,floor($usercar['diffisica']/10));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_min2'],$danni)."</span><br /><br />";	
}
$titolo=$lang['report_incidente_miniera'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$testo="<span>".sprintf($lang['report_lavminieranuova'],$paga,$exp,$energia,$salute)."</span><br /><br />";
$titolo=$lang['report_lavoro_nuova'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expminatore=t3.expminatore+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."' WHERE t1.userid='".$userid."'");
} //fine Completalavminnuova

function Completalavlabapp($userid) {
global $db,$adesso;
require('language/it/lang_laboratorio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 0,1");
$paga=6;
$mana=rand(5,10);
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$salute=(rand(2,10))-($usercar['alchimista'])-(rand(0,floor($usercar['difmagica']/10)));
if ($salute<1)
$salute=1;
$exp=rand(5,(2+floor($usercar['saluteattuale']/10)+floor($usercar['energia']/100)+floor($usercar['attmagico']/10)));
$exp+=(5*(rand(0,$usercar['alchimista'])));
$esplosione=rand(10,100)-($usercar['alchimista']*5)-($usercar['attmagico']/2);
$danni=0;
if($esplosione>10){
$esplosione=rand(10,100)-($usercar['agilita']/5)-($usercar['attmagico']/2);
if($esplosione<10){
$testo="<span>".$lang['report_esplosione_lab1']."</span><br /><br />";
}else{
$danni=rand(5,30)-rand(0,floor($usercar['difmagica']/10));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_esplosione_lab2'],$danni)."</span><br /><br />";	
}
$titolo=$lang['report_esplosione_laboratorio'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine esplosione
$testo="<span>".sprintf($lang['report_lavlabapp'],$paga,$exp,$energia,$salute,$mana)."</span><br /><br />";
$titolo=$lang['report_lavoro_labapp'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."',t3.recuperosalute='".$adesso."',t3.recuperoenergia='".$adesso."',t3.manarimasto=t3.manarimasto-'".$mana."' WHERE t1.userid='".$userid."'");
} //fine Completalavlabapp

function Completatempioprega($userid) {
global $db,$adesso;
require('language/it/lang_tempio.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 0,1");
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
$miracolo=rand(0,100)-($usercar['fede']/100);
$titolo=$lang['report_tempio_preghiera'];
if($miracolo<1){
$mana=$usercar['mana'];
$salute=$usercar['salute'];
$energia=$usercar['energiamax'];
$testo="<span>".$lang['report_manifestazione_divina']."</span><br /><br />";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine manifestazione divina
else{
$testo="<span>".sprintf($lang['report_preghiera_normale'],$dono,$energiapersa)."</span><br /><br />";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
}//fine se niente manifestazione divina
$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t3.fede=t3.fede+'".$fede."',t2.monete=t2.monete-'".$dono."',t3.energia='".$energia."',t3.saluteattuale='".$salute."',t3.recuperoenergia='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto='".$mana."' WHERE t2.userid='".$userid."'");
} //fine Completatempioprega

function Completaresurrezione($userid) {
global $db,$adesso;
require('language/it/lang_tempio.php');

$mana=$usercar['mana'];
$salute=$usercar['salute'];
$energia=$usercar['energiamax'];
$titolo=$lang['report_tempio_preghiera'];
$testo="<span>".$lang['report_manifestazione_divina']."</span><br /><br />";
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	

$db->QueryMod("UPDATE utenti t2 JOIN caratteristiche t3 on t2.userid=t3.userid SET t2.resuscita=t'0',t3.energia='".$energia."',t3.saluteattuale='".$salute."',t3.recuperoenergia='".$adesso."',t3.recuperosalute='".$adesso."',t3.decfede='".$adesso."',t3.manarimasto='".$mana."' WHERE t2.userid='".$userid."'");
} //fine Completaresurrezione
?>