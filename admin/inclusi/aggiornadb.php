<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.6.3";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){
$db->QueryMod("ALTER TABLE `eventi` ADD `battleid` INT UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("CREATE TABLE `battle` (`id` INT UNSIGNED NOT NULL AUTO_INCREMENT ,`attid` SMALLINT UNSIGNED NOT NULL ,`difid` SMALLINT UNSIGNED NOT NULL ,PRIMARY KEY ( `id` )) ENGINE = MYISAM");
$db->QueryMod("CREATE TABLE `battlereport` (`id` INT UNSIGNED NOT NULL ,`data` INT( 13 ) UNSIGNED NOT NULL ,PRIMARY KEY ( `id` )) ENGINE = MYISAM");
$db->QueryMod("ALTER TABLE `oggetti` DROP INDEX `tipo`");
$db->QueryMod("ALTER TABLE `oggetti` DROP INDEX `categoria`");
$db->QueryMod("ALTER TABLE `magia` DROP INDEX `elemento`");

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