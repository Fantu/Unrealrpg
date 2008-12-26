<?php
if($_GET['code']!='autourbg2'){header("Location: index.php?error=16"); exit();}
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
require('inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();
$int_security=$game_se_code;
$optimize=0;
foreach($game_language as $chiavel=>$elementol){
$language=$chiavel;
require('language/'.$language.'/lang_interno.php');
require('language/'.$language.'/lang_oggetti_nomi.php');
foreach($game_server as $chiave=>$elemento){
if($game_server_lang[$chiave]==$chiavel){
$db->database=$chiave;
$config=$db->QuerySelect("SELECT * FROM config");
if($config['chiuso']==0){
require_once('inclusi/controllo_eventi.php');
Controllaeventi(3);
if($config['ottimizzazioni']<$adesso AND $optimize==0){
$semorti=$db->QuerySelect("SELECT COUNT(userid) AS id FROM caratteristiche WHERE saluteattuale<'1'");
if($semorti['id']>0){//se ci sono morti
$morti=$db->QueryCiclo("SELECT * FROM caratteristiche WHERE saluteattuale<'1'");
while($morto=$db->QueryCicloResult($morti)){
$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$morto['userid']."'");
if($eventi['id']==0){
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$morto['userid']."' LIMIT 1");
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$morto['userid']."' LIMIT 1");
require('inclusi/morte.php');
}//se non ha eventi, e quindi resurrezione già in corso
}//per ogni morto
}//se ci sono morti
$db->QueryMod("DELETE FROM sessione WHERE time<'".($adesso-10800)."'");// cancellazione di tutte le sessioni più vecchie di 3 ore
$db->QueryMod("DELETE FROM msginviati WHERE data<'".($adesso-172800)."'");// cancellazione di tutti i msg inviati del regno più vecchi di 2 giorni
$scaduto=$adesso-2592000;
$quantimess=$db->QuerySelect("SELECT COUNT(id) AS n FROM messaggi WHERE data<'".$scaduto."'");
if($quantimess['n']>0){
$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."'");
}//eliminazione di tutti i msg del regno più vecchi di 30 giorni
$scaduto=$adesso-604800;
$quantimess=$db->QuerySelect("SELECT COUNT(id) AS n FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
if($quantimess['n']>0){
$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
}//eliminazione di tutti i msg letti del regno più vecchi di 7 giorni
$quantirep=$db->QuerySelect("SELECT COUNT(id) AS n FROM battlereport WHERE data<'".$scaduto."'");
if($quantirep['n']>0){
$repscaduti=$db->QueryCiclo("SELECT id FROM battlereport WHERE data<'".$scaduto."'");
while($reps=$db->QueryCicloResult($repscaduti)) {
$db->QueryMod("DELETE FROM battlereport WHERE id='".$reps['id']."' LIMIT 1");
unlink("inclusi/log/report/".$config['id']."/".$reps['id'].".log");
}//eliminazione di tutti i report del regno più vecchi di 7 giorni
}//se ci sono report più vecchi di 7 giorni nel regno
$optimize=1;
$db->QueryMod("UPDATE config SET ottimizzazioni='".($adesso+3600)."'");//prossima "ottimizzazione" fra 1 ora
}//se bisogna ottimizzare e nn è stato fatto in altri regni durante questa sessione
if($config['atticriminali']<$adesso){
$prob=rand(1,500);
if($prob<=$config['crimine'])
Controllacrimine($config);
$tempopcrimine=3600-($config['utenti']*20);
if($tempopcrimine<600){$tempopcrimine=600;}
$db->QueryMod("UPDATE config SET atticriminali='".($adesso+$tempopcrimine)."'");}
}//fine se il server non è chiuso
}//fine se è di quella lingua
}//fine ogni server
}//fine per ogni lingua
?>