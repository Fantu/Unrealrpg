<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$semagie=0;
$inmagie=$db->QuerySelect("SELECT COUNT(id) AS num FROM inmagia WHERE userid='".$user['userid']."'");
if($inmagie['num']>0){
$semagie=1;
$inmagie=$db->QuerySelect("SELECT * FROM inmagia WHERE userid='".$user['userid']."'");
$magieq=$db->QueryCiclo("SELECT * FROM magia");
while($chem=$db->QueryCicloResult($magieq)) {
	$magie[$chem['id']]['tipo']=$chem['tipo'];
	$magie[$chem['id']]['elemento']=$chem['elemento'];
}//fine mostra risultati
}//fine se ci sono magie
require('template/int_libro.php');
?>