<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.13";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='5'");
$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='3'");
$db->QueryMod("UPDATE `oggetti` SET `costo` = '60' WHERE `oggetti`.`id` =61 LIMIT 1");
$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='4'");
$db->QueryMod("UPDATE `oggetti` SET `costo` = '78' WHERE `oggetti`.`id` =64 LIMIT 1");

$db->QueryMod("INSERT INTO `oggetti` (
`id` ,
`tipo` ,
`categoria` ,
`probrottura` ,
`costo` ,
`energia` ,
`usura` ,
`bonuseff` ,
`forzafisica` ,
`destrezza` ,
`probtrovare` ,
`recsalute` ,
`recenergia` ,
`abilitanec` ,
`materiale` ,
`danno` ,
`difesafisica`
)
VALUES 
(NULL , '5', '3', '175', '30', '55', '70', '0', '140', '0', '0', '0', '0', '1', '2', '12', '0'),
(NULL , '5', '3', '125', '60', '55', '140', '2', '140', '0', '0', '0', '0', '3', '2', '14', '0'),
(NULL , '5', '3', '75', '120', '55', '300', '5', '140', '0', '0', '0', '0', '6', '2', '17', '0'),
(NULL , '5', '4', '230', '40', '100', '70', '0', '210', '0', '0', '0', '0', '1', '2', '15', '0'),
(NULL , '5', '4', '180', '80', '100', '140', '0', '210', '0', '0', '0', '0', '3', '2', '18', '0'),
(NULL , '5', '4', '120', '160', '100', '300', '1', '210', '0', '0', '0', '0', '6', '2', '22', '0'),
(NULL , '5', '5', '75', '30', '70', '100', '0', '140', '0', '0', '0', '0', '1', '2', '11', '0'),
(NULL , '5', '5', '60', '60', '70', '200', '1', '140', '0', '0', '0', '0', '3', '2', '13', '0'),
(NULL , '5', '5', '45', '120', '70', '450', '2', '140', '0', '0', '0', '0', '6', '2', '15', '0');
");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>