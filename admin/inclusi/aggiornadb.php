<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.6.2";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){
$db->QueryMod("ALTER TABLE `inoggetti` CHANGE `inuso` `inuso` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `inoggetti` ADD `equip` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("CREATE TABLE equipaggiamento ( `userid` SMALLINT UNSIGNED NOT NULL , `cac` SMALLINT UNSIGNED NOT NULL DEFAULT '0', PRIMARY KEY ( `userid` ) ) ENGINE = MYISAM");

	$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
	while($var=$db->QueryCicloResult($a))
	{
		$db->QueryMod("INSERT INTO equipaggiamento (userid) VALUES ('".$var['userid']."')");
	}

$db->QueryMod("INSERT INTO oggetti (`id`,`tipo`,`categoria`,`probrottura`,`costo`,`energia`,`usura`,`bonuseff`,`forzafisica`,`probtrovare`,`recsalute`,`recenergia`,`abilitanec`,`materiale`,`danno`)
VALUES 
(NULL , '5', '2', '250', '10', '30', '10', '0', '50', '0', '0', '0', '1', '1', '6'),
(NULL , '5', '2', '200', '20', '30', '20', '0', '50', '0', '0', '0', '3', '1', '7'),
(NULL , '5', '2', '100', '30', '30', '50', '0', '50', '0', '0', '0', '5', '1', '8'),
(NULL , '5', '2', '200', '20', '50', '20', '0', '80', '0', '0', '0', '1', '2', '10'),
(NULL , '5', '2', '100', '40', '50', '40', '0', '80', '0', '0', '0', '3', '2', '12'),
(NULL , '5', '2', '50', '60', '50', '80', '1', '80', '0', '0', '0', '5', '2', '15'),
(NULL , '5', '2', '100', '30', '60', '40', '0', '100', '0', '0', '0', '1', '3', '13'),
(NULL , '5', '2', '50', '60', '60', '80', '1', '100', '0', '0', '0', '3', '3', '16'),
(NULL , '5', '2', '25', '120', '60', '160', '3', '100', '0', '0', '0', '6', '3', '20');
");
$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server

	/* //creazione record per tab con 1 record per utente
	$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
	while($var=$db->QueryCicloResult($a))
	{
		$db->QueryMod("INSERT INTO lavori (userid) VALUES ('".$var['userid']."')");
	}*/
?>