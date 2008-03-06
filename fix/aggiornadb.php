<?php
if($_GET['code']!='updateurbg'){
	header("Location: ../index.php?error=16");
	exit();}
$adesso=strtotime("now");
$pathbase=1;
$percorsobase="../game/";
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->QueryMod("ALTER TABLE `messaggi` CHANGE `testo` `testo` VARCHAR( 11000 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL");
$db->QueryMod("ALTER TABLE `oggetti` CHANGE `tipo` `tipo` TINYINT( 1 ) UNSIGNED NOT NULL");
$db->QueryMod("ALTER TABLE `oggetti` CHANGE `categoria` `categoria` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT '0'");
$db->QueryMod("ALTER TABLE `oggetti` ADD INDEX ( `tipo` )");
$db->QueryMod("ALTER TABLE `oggetti` ADD INDEX ( `categoria` )");
echo "Aggiornato db server ".$chiave." alla 0.5.9<br />";
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