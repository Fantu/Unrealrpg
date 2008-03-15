<?php
if($_GET['code']!='updateurbg'){
	header("Location: ../index.php?error=16");
	exit();}
$adesso=strtotime("now");
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$newversion="0.6.1";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion){
$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo "Aggiornato db server ".$chiave." alla versione ".$newversion."<br />";
}/*se non aggiornato*/else{
echo "IL db server ".$chiave." egrave; giagrave; aggiornato<br />";
}
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