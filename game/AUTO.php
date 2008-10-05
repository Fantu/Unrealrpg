<?php
if($_GET['code']!='autourbg'){
	header("Location: index.php?error=16");
	exit();}
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
require('inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$adesso=strtotime("now");
$int_security=$game_se_code;
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$language=$game_server_lang[$chiave];
require('language/'.$language.'/lang_interno.php');
require_once('inclusi/controllo_eventi.php');
Controllaeventi(3);
$semorti=$db->QuerySelect("SELECT COUNT(userid) AS id FROM caratteristiche WHERE saluteattuale<'1'");
if ($semorti['id']>0){//se ci sono morti
$morti=$db->QueryCiclo("SELECT * FROM caratteristiche WHERE saluteattuale<'1'");
while($morto=$db->QueryCicloResult($morti)) {
$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$morto['userid']."'");
if($eventi['id']==0) {
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$morto['userid']."' LIMIT 1");
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$morto['userid']."' LIMIT 1");
require('inclusi/morte.php');
}//se non ha eventi, e quindi resurrezione già in corso
}//per ogni morto
}//se ci sono morti
$config=$db->QuerySelect("SELECT * FROM config");
if($config['atticriminali']<$adesso){
$prob=rand(1,500);
//if($prob<=$config['crimine'])
Controllacrimine($config);
$db->QueryMod("UPDATE config SET atticriminali='".($adesso+3600)."'");}
}//fine ogni server
?>