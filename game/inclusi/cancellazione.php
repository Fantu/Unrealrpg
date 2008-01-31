<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$intestazione="From: ".$game_name."<server@lostage.it>\r\n";
$tempo=$adesso-172800;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
while($chi=$db->QueryCicloResult($dacanc)) {
$messaggio="Ciao ".$chi['username'].",\nSiamo spiacenti di informarti che il tuo account su ".$game_name." sul server ".$game_server[$chi['server']]." è stato cancellato perchè non confermato entro 48 ore.\nSaluti,\n".$game_name." Staff";
mail($chi['email'],"Account cancellato",$messaggio,$intestazione);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
}
$tempo=$adesso-259200;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
while($chi=$db->QueryCicloResult($dacanc)) {	
$messaggio="Ciao ".$chi['username']."\nSiamo spiacenti di informarti che il tuo account su ".$game_name." sul server ".$game_server[$chi['server']]." è stato cancellato perchè non è stato creato un personaggio entro 72 ore.\nSaluti,\n".$game_name." Staff";
mail($chi['email'],"Account cancellato",$messaggio,$intestazione);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("UPDATE config SET utenti=utenti-'1' WHERE id='".$chi['server']."'");
}
$tempo=$adesso-1209600;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."'");
while($chi=$db->QueryCicloResult($dacanc)) {	
$messaggio="Ciao ".$chi['username']."\nTi scriviamo per informarti che il tuo account su ".$game_name." server ".$game_server[$chi['server']]." risulta inattivo da più di 2 settimane.\nSe questa inattività dovesse raggiungere i 30 giorni, l'account verrà automaticamente cancellato dal sistema.\nSaluti,\n".$game_name." Staff";
mail($chi['email'],"Account inutilizzato",$messaggio,$intestazione);
$avviso=$adesso+604800;
$db->QueryMod("UPDATE utenti SET avvinattivo='".$avviso."' WHERE userid='".$chi['userid']."'");
}
$tempo=$adesso-2592000;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE ultimologin<'".$tempo."'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."'");
while($chi=$db->QueryCicloResult($dacanc)) {	
$messaggio="Ciao ".$chi['username']."\nSiamo spiacenti di informarti che il tuo account su ".$game_name." sul server ".$game_server[$chi['server']]." è stato cancellato perchè inattivo da oltre 30 giorni.\nSaluti,\n".$game_name." Staff";
mail($chi['email'],"Account cancellato",$messaggio,$intestazione);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("UPDATE config SET utenti=utenti-'1' WHERE id='".$chi['server']."'");
$db->QueryMod("DELETE FROM caratteristiche WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM banca WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM lavori WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM inoggetti WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM messaggi WHERE userid='".$chi['userid']."'");
}
?>