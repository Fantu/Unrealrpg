<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$tempo=$adesso-172800;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
while($chi=$db->QueryCicloResult($dacanc)) {
$intestazione="From: ".$game_name."<server@lostage.it>\r\n";
$messaggio="Ciao ".$chi['username'].",\nSiamo spiacenti di informarti che il tuo account su ".$game_name." sul server ".$game_server[$chi['server']]." è stato cancellato perchè non confermato entro 48 ore.\nSaluti,\nLostgames Staff";
mail($chi['email'],"Account cancellato",$messaggio,$intestazione);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
}
$tempo=$adesso-259200;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
while($chi=$db->QueryCicloResult($dacanc)) {
$intestazione="From: ".$game_name."<server@lostage.it>\r\n";	
$messaggio="Ciao ".$chi['username']."\nSiamo spiacenti di informarti che il tuo account su ".$game_name." sul server ".$game_server[$chi['server']]." è stato cancellato perchè non è stato creato un personaggio entro 72 ore.\nSaluti,\nLostgames Staff";
mail($chi['email'],"Account cancellato",$messaggio,$intestazione);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("UPDATE config SET utenti=utenti-'1' WHERE id='".$chi['server']."'");
}
?>