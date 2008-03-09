<?php
if($_GET['code']!='updateurbg'){
	header("Location: ../index.php?error=16");
	exit();}
$adesso=strtotime("now");
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database = $chiave;
$db->QueryMod("ALTER TABLE `eventi` CHANGE `dettagli` `dettagli` TINYINT UNSIGNED NOT NULL");
$db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `sesso` `sesso` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `minatore` `minatore` TINYINT UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `alchimista` `alchimista` TINYINT UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `fabbro` `fabbro` TINYINT UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `magica` `magica` TINYINT UNSIGNED NOT NULL DEFAULT '0'");
echo "Aggiornato db server ".$chiave." alla 0.5.10<br />";
}//se non è quello di sviluppo principale
}//fine per ogni server	
	/* //creazione record per tab con 1 record per utente
	foreach($game_server as $chiave=>$elemento){
	$db->database = $chiave;
	$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
	while($var=$db->QueryCicloResult($a))
	{
		$db->QueryMod("INSERT INTO lavori (userid) VALUES ('".$var['userid']."')");
	}
	}// fine per ogni server*/
?>