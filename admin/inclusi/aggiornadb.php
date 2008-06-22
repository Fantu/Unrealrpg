<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.6.13";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){
$db->QueryMod("UPDATE `oggetti` SET `costo` = '55' WHERE `oggetti`.`id` =61 LIMIT 1");

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

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>