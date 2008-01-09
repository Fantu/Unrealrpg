<?php
$adesso=strtotime("now");
require('game/inclusi/valori.php');
require('game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();		
	foreach($game_server as $chiave=>$elemento){
	$db->database = $chiave;
	$a=$db->QueryCiclo("SELECT userid FROM utenti WHERE conferma='1' AND personaggio='1'");
	while($var=$db->QueryCicloResult($a))
	{
		$db->QueryMod("INSERT INTO laboratorio (userid) VALUES ('".$var['userid']."')");
	}
	}// fine per ogni server
?>