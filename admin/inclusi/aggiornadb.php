<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.6";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

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
`probtrovare` ,
`recsalute` ,
`recenergia` ,
`abilitanec` ,
`materiale` ,
`danno` ,
`difesafisica`
)
VALUES 
(NULL , '6', '1', '180', '15', '5', '30', '0', '20', '0', '0', '0', '1', '1', '0', '6'),
(NULL , '6', '1', '150', '25', '7', '60', '0', '40', '0', '0', '0', '1', '2', '0', '7'),
(NULL , '6', '1', '120', '35', '8', '100', '0', '60', '0', '0', '0', '1', '3', '0', '8'),
(NULL , '6', '2', '180', '15', '12', '30', '0', '35', '0', '0', '0', '1', '1', '0', '9'),
(NULL , '6', '2', '150', '25', '14', '60', '0', '70', '0', '0', '0', '1', '2', '0', '11'),
(NULL , '6', '2', '120', '35', '16', '100', '0', '90', '0', '0', '0', '1', '3', '0', '12'),
(NULL , '5', '2', '40', '150', '60', '450', '2', '90', '0', '0', '0', '1', '4', '18', '0'),
(NULL , '5', '2', '20', '350', '60', '1050', '5', '90', '0', '0', '0', '6', '4', '22', '0');
");

$db->QueryMod("UPDATE `oggetti` SET `energia` = '9' WHERE `oggetti`.`id` =57 LIMIT 1");
$db->QueryMod("UPDATE `oggetti` SET `energia` = '10' WHERE `oggetti`.`id` =58 LIMIT 1");
$db->QueryMod("");
$db->QueryMod("");

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