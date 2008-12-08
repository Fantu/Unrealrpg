<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.15";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("UPDATE `pcpudata` SET `eqpoz` = '27' WHERE `pcpudata`.`id` =8 LIMIT 1");
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
(NULL , '6', '1', '45', '80', '7', '150', '0', '20', '0', '0', '0', '0', '6', '1', '0', '10'),
(NULL , '6', '1', '37', '120', '9', '290', '0', '40', '0', '0', '0', '0', '6', '2', '0', '11'),
(NULL , '6', '1', '30', '200', '10', '550', '0', '60', '0', '0', '0', '0', '6', '3', '0', '15');
");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>