<?php
require('game/inclusi/valori.php');
require('game/inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();
$indb=(int)$_GET['t'];
if(isset($game_server[$indb])){$db->Setdb($indb);}else{header("Location: index.php?error=5"); exit();}
if(!$_GET['cod']){
	header("Location: index.php?error=5");
	exit();
}
$code=htmlspecialchars($_GET['cod'],ENT_QUOTES);
$a=$db->QuerySelect("SELECT userid,conferma FROM utenti WHERE codice='".$code."' LIMIT 1");

if(!$a['userid']){
	header("Location: index.php?error=5");
	exit();
}
elseif($a['conferma']==1){
	header("Location: index.php?error=6");
	exit();
}else{
	$db->QueryMod("UPDATE utenti SET conferma='1' WHERE userid='".$a['userid']."'");
	$db->QueryMod("UPDATE config SET utenti=utenti+'1'");
	header("Location: index.php?error=7");
	exit();
}
?>