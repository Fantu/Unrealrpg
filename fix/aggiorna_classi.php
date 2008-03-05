<?php
if($_GET['code']!='updateurbg'){
	header("Location: ../index.php?error=16");
	exit();}
require('game/inclusi/valori.php');
require('game/inclusi/funzioni_db.php');
require('game/inclusi/personaggio.php');
$db = new ConnessioniMySQL();		
	foreach($game_server as $chiave=>$elemento){
	$db->database = $chiave;
		foreach($classi['nome'] as $chiave=>$elemento){
		$agilita=$classi['agilita'][$chiave];
		$attfisico=$classi['attfisico'][$chiave];
		$attmagico=$classi['attmagico'][$chiave];
		$diffisica=$classi['diffisica'][$chiave];
		$difmagica=$classi['difmagica'][$chiave];
		$mana=$classi['mana'][$chiave];
		$velocita=$classi['velocita'][$chiave];
		$intelligenza=$classi['intelligenza'][$chiave];
		$destrezza=$classi['destrezza'][$chiave];
		$db->QueryMod("UPDATE caratteristiche SET agilita='".$agilita."',attfisico='".$attfisico."',attmagico='".$attmagico."',diffisica='".$diffisica."',difmagica='".$difmagica."',mana='".$mana."',velocita='".$velocita."',intelligenza='".$intelligenza."',destrezza='".$destrezza."' WHERE classe='".$chiave."'");
		}//fine ogni classe
	}// fine per ogni server
?>