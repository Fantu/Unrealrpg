<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.6.7";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){
$db->QueryMod("ALTER TABLE `battle` ADD `tatatt` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
ADD `tatatt2` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
ADD `tatdif` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
ADD `tatdif2` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `utenti` ADD `mailnews` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '1'");

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
}//se non � quello di sviluppo principale
}//fine per ogni server
?>