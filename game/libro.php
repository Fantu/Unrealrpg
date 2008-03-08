<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$semagie=0;
$inmagie=$db->QuerySelect("SELECT COUNT(id) AS num FROM inmagia WHERE userid='".$user['userid']."'");
if($inmagie['num']>0){
$semagie=1;
$inmagieq=$db->QueryCiclo("SELECT * FROM inmagia WHERE userid='".$user['userid']."'");
while($chem=$db->QueryCicloResult($inmagieq)) {
	$inmagie[$chem['magid']]=$chem['stato'];
}//fine mostra risultati
$magieq=$db->QueryCiclo("SELECT * FROM magia");
while($chem=$db->QueryCicloResult($magieq)) {
	$magie[$chem['id']]['tipo']=$chem['tipo'];
	$magie[$chem['id']]['elemento']=$chem['elemento'];
}//fine mostra risultati
}//fine se ci sono magie

if($semagie==1){
foreach($elementi as $chiaveel=>$elementoel){
foreach($tipimagia as $chiavetm=>$elementotm){
foreach($inmagie as $chiave=>$elemento){
if($magie[$chiave]['tipo']==$chiavetm AND $magie[$chiave]['elemento']==$chiaveel){
$outputmagie[$elementoel][$elementotm][$chiave]=$elemento;
}//se corrispondente
}//mostra ogni magia
}//per ogni tipo 
}//per ogni elemento
}/*fine mostra incantesimi*/

require('template/int_libro.php');
?>