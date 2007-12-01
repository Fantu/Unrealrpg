<?php
require('game/inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();

//if($_GET['t']==999 || $_GET['t']==0)
$esistenza=0;		
	foreach($game_server as $key->$elemento){
	if ($key==$_GET['t']){$esistenza=1;}
	}
if($esistenza==1)
	$db->database = $_GET['t'];
else {
	header("Location: index.php?error=5");
	exit();
}
if(!$_GET['cod']) {
	header("Location: index.php?error=5");
	exit();
}
$a=$db->QuerySelect("SELECT userid,conferma,server FROM utenti WHERE codice='".$_GET['cod']."'");

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