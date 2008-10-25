<?php
if($_GET['code']!='autourbg'){
	header("Location: index.php?error=16");
	exit();}
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
require('inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();
$adesso=strtotime("now");
$int_security=$game_se_code;
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