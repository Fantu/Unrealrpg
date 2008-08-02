<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.6.17";
foreach($game_server as $chiave=>$elemento){
if($chiave==999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

/*
$db->QueryMod("CREATE TABLE `carcpu` (
`cpuid` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`pid` SMALLINT UNSIGNED NOT NULL ,
`livello` SMALLINT UNSIGNED NOT NULL ,
`salute` MEDIUMINT UNSIGNED NOT NULL ,
`saluteattuale` MEDIUMINT UNSIGNED NOT NULL ,
`energia` MEDIUMINT UNSIGNED NOT NULL ,
`energiamax` MEDIUMINT UNSIGNED NOT NULL ,
`mana` MEDIUMINT UNSIGNED NOT NULL ,
`manarimasto` MEDIUMINT UNSIGNED NOT NULL ,
`attfisico` MEDIUMINT UNSIGNED NOT NULL ,
`attmagico` MEDIUMINT UNSIGNED NOT NULL ,
`diffisica` MEDIUMINT UNSIGNED NOT NULL ,
`difmagica` MEDIUMINT UNSIGNED NOT NULL ,
`agilita` MEDIUMINT UNSIGNED NOT NULL ,
`velocita` MEDIUMINT UNSIGNED NOT NULL ,
`intelligenza` MEDIUMINT UNSIGNED NOT NULL ,
`destrezza` MEDIUMINT UNSIGNED NOT NULL
) ENGINE = MYISAM");
$db->QueryMod("INSERT INTO `pcpudata` (`id` ,`quest` ,`salute` ,`energia` ,`mana` ,`attfisico` ,`attmagico` ,`diffisica` ,`difmagica` ,`agilita` ,`velocita` ,`intelligenza` ,`destrezza` ,`livello` ,`eqcac` ,`eqarm` ,`eqscu`)
VALUES 
(NULL , '0', '100', '1000', '50', '200', '50', '50', '200', '150', '150', '100', '100', '1', '64', '56', '58');
");
*/

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

// INIZIO SISTEMAZIONE CARATTERISTICHE E RITORNO A LIVELLO 1
require('../game/inclusi/personaggio.php');
$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
while($var=$db->QueryCicloResult($a))
{
$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$var['userid']."'");
if($car['livello']>1){
$chiave=$car['classe'];
		$agilita=$classi['agilita'][$chiave];
		$attfisico=$classi['attfisico'][$chiave];
		$attmagico=$classi['attmagico'][$chiave];
		$diffisica=$classi['diffisica'][$chiave];
		$difmagica=$classi['difmagica'][$chiave];
		$mana=$classi['mana'][$chiave];
		$velocita=$classi['velocita'][$chiave];
		$intelligenza=$classi['intelligenza'][$chiave];
		$destrezza=$classi['destrezza'][$chiave];
$livello=$car['livello'];
$exp=0;
for($i=1;$i=$livello-1;$i++){
$expinc=1+floor($i/2);
$exp+=$expinc*(120*$i);
}
$db->QueryMod("UPDATE caratteristiche SET agilita='".$agilita."',attfisico='".$attfisico."',attmagico='".$attmagico."',diffisica='".$diffisica."',difmagica='".$difmagica."',mana='".$mana."',velocita='".$velocita."',intelligenza='".$intelligenza."',destrezza='".$destrezza."',livello='1',exp=exp+'".$exp."' WHERE userid='".$var['userid']."'");
}//se livello maggiore di 1
}//per ogni utente
// FINE SISTEMAZIONE CARATTERISTICHE E RITORNO A LIVELLO 1
	
	

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non � quello di sviluppo principale
}//fine per ogni server
?>