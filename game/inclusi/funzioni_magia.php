<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_magia.php');

$elementi=array(1=>$lang['Acqua'],2=>$lang['Aria'],3=>$lang['Terra'],4=>$lang['Fuoco']);

$tipimagia=array(1=>$lang['Offensivi'],2=>$lang['Difensivi']);

function Controllamagieconosciute($userid,$elemento) {
global $db;
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
$semagie=$db->QuerySelect("SELECT COUNT(id) AS num FROM magia WHERE elemento='".$elemento."' AND abilitanec<='".$usercar['magica']."' AND expnec<='".$usercar['expelmagico'.$elemento]."'");
if($semagie['num']>0){
$magieq=$db->QueryCiclo("SELECT * FROM magia WHERE elemento='".$elemento."' AND abilitanec<='".$usercar['magica']."' AND expnec<='".$usercar['expelmagico'.$elemento]."'");
while($chem=$db->QueryCicloResult($magieq)) {
	$magie[$chem['id']]=$chem['id'];
}//fine risultati magie
$inmagie=$db->QuerySelect("SELECT COUNT(id) AS num FROM inmagia WHERE userid='".$userid."'");
if($inmagie['num']>0){
$inmagieq=$db->QueryCiclo("SELECT * FROM inmagia WHERE userid='".$userid."'");
while($chem=$db->QueryCicloResult($inmagieq)) {
	$inmagie[$chem['magid']]=$chem['stato'];
}//fine risultati inmagie
}//fine se ci sono magie
foreach($magie as $chiave=>$el){
if(!isset($inmagie[$chiave]))
$db->QueryMod("INSERT INTO eventi (magid,userid) VALUES ('".$chiave."','".$userid."')");
}//per ogni magia
}//se ci sono magie
}//fine Controllamagieconosciute
?>