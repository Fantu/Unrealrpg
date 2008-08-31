<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.0";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("INSERT INTO `pcpudata` (
`id` ,
`quest` ,
`salute` ,
`energia` ,
`mana` ,
`attfisico` ,
`attmagico` ,
`diffisica` ,
`difmagica` ,
`agilita` ,
`velocita` ,
`intelligenza` ,
`destrezza` ,
`livello` ,
`eqcac` ,
`eqarm` ,
`eqscu` ,
`monete`
)
VALUES 
(NULL , '1', '100', '1000', '50', '100', '25', '100', '25', '150', '150', '100', '100', '1', '65', '55', '57', '10'),
(NULL , '1', '105', '1050', '50', '200', '25', '200', '25', '160', '160', '100', '150', '2', '60', '56', '57', '15'),
(NULL , '1', '115', '1150', '50', '300', '30', '300', '30', '180', '180', '120', '200', '4', '61', '56', '58', '20'),
(NULL , '1', '100', '1200', '50', '200', '50', '200', '50', '200', '200', '50', '50', '3', '65', '0', '0', '10');
");
$db->QueryMod("ALTER TABLE `battle` CHANGE `exp` `exp` FLOAT UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `eventi` ADD `questid` SMALLINT UNSIGNED NOT NULL DEFAULT '0'");

/*$db->QueryMod("INSERT INTO `oggetti` (
`id` ,
`tipo` ,
`categoria` ,
`probrottura` ,
`costo` ,
`energia` ,
`usura` ,
`bonuseff` ,
`forzafisica` ,
`probtrovare` ,
`recsalute` ,
`recenergia` ,
`abilitanec` ,
`materiale` ,
`danno` ,
`difesafisica`
)
VALUES 
(NULL , '5', '3', '200', '15', '50', '20', '0', '100', '0', '0', '0', '1', '1', '11', '0'),
(NULL , '5', '3', '150', '30', '50', '40', '1', '100', '0', '0', '0', '3', '1', '13', '0'),
(NULL , '5', '3', '100', '50', '50', '100', '2', '100', '0', '0', '0', '5', '1', '16', '0'),
(NULL , '5', '4', '250', '20', '100', '20', '0', '150', '0', '0', '0', '1', '1', '13', '0'),
(NULL , '5', '4', '200', '40', '100', '40', '0', '150', '0', '0', '0', '3', '1', '16', '0'),
(NULL , '5', '4', '150', '70', '100', '80', '0', '150', '0', '0', '0', '5', '1', '20', '0'),
(NULL , '5', '5', '150', '15', '60', '30', '0', '100', '0', '0', '0', '1', '1', '10', '0'),
(NULL , '5', '5', '120', '30', '60', '60', '0', '100', '0', '0', '0', '3', '1', '12', '0'),
(NULL , '5', '5', '90', '60', '60', '150', '1', '100', '0', '0', '0', '5', '1', '14', '0');
");*/
	/*//creazione record per tab con 1 record per utente
	$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
	while($var=$db->QueryCicloResult($a))
	{
		$db->QueryMod("INSERT INTO equipaggiamento (userid) VALUES ('".$var['userid']."')");
	}*/

/* INIZIO SISTEMAZIONE CARATTERISTICHE E RITORNO A LIVELLO 1
require('../game/inclusi/personaggio.php');
$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
while($var=$db->QueryCicloResult($a))
{
$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$var['userid']."'");
if($car['livello']>1){
$chiave2=$car['classe'];
		$agilita=$classi['agilita'][$chiave2];
		$attfisico=$classi['attfisico'][$chiave2];
		$attmagico=$classi['attmagico'][$chiave2];
		$diffisica=$classi['diffisica'][$chiave2];
		$difmagica=$classi['difmagica'][$chiave2];
		$mana=$classi['mana'][$chiave2];
		$velocita=$classi['velocita'][$chiave2];
		$intelligenza=$classi['intelligenza'][$chiave2];
		$destrezza=$classi['destrezza'][$chiave2];
$livello=$car['livello'];
$exp=0;
for($i=1;$i<=$livello-1;$i++){
$expinc=1+floor($i/2);
$exp+=$expinc*(120*$i);
}
$db->QueryMod("UPDATE caratteristiche SET agilita='".$agilita."',attfisico='".$attfisico."',attmagico='".$attmagico."',diffisica='".$diffisica."',difmagica='".$difmagica."',mana='".$mana."',manarimasto='".$mana."',velocita='".$velocita."',intelligenza='".$intelligenza."',destrezza='".$destrezza."',livello='1',exp=exp+'".$exp."',salute='100',saluteattuale='100',energia='1000',energiamax='1000' WHERE userid='".$var['userid']."'");
}//se livello maggiore di 1
}//per ogni utente
// FINE SISTEMAZIONE CARATTERISTICHE E RITORNO A LIVELLO 1*/
	
	

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>