<?php
require('game/inclusi/valori.php');
require('game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$indb=(int)$_GET['t'];
$esistenza=0;		
	foreach($game_server as $chiave=>$elemento){
	if ($chiave==$indb){$esistenza=1;}
	}
if($esistenza==1)
	$db->database=$indb;
else {
	header("Location: index.php?error=5");
	exit();
}
if(!$_GET['cod']) {
	header("Location: index.php?error=5");
	exit();
}
$a=$db->QuerySelect("SELECT userid,conferma,server FROM utenti WHERE codice='".$_GET['cod']."' LIMIT 0,1");

if(!$a['userid']) {
	header("Location: index.php?error=5");
	exit();
}
else if($a['conferma']==1) {
	header("Location: index.php?error=6");
	exit();
} else {	
	$ora=strtotime("now");
	$db->QueryMod("UPDATE utenti SET conferma='1' WHERE userid='".$a['userid']."'");
	$db->QueryMod("UPDATE config SET utenti=utenti+'1' WHERE id='".$a['server']."'");						
	
	header("Location: index.php?error=7");
	exit();
}
?>