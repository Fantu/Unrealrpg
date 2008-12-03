<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_interno.php');
$tempo=$adesso-172800;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
while($chi=$db->QueryCicloResult($dacanc)){
$messaggio=sprintf($lang['mail_cancellato_noconferma'],$chi['username'],$game_name,$game_server[$chi['server']]);
$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
}//cancellazione non confermati
$tempo=$adesso-259200;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
while($chi=$db->QueryCicloResult($dacanc)){
$messaggio=sprintf($lang['mail_cancellato_nopersonaggio'],$chi['username'],$game_name,$game_server[$chi['server']]);
$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
$db->QueryMod("UPDATE config SET utenti=utenti-'1' WHERE id='".$chi['server']."'");
}//cancellazione senza personaggio
$tempo=$adesso-1209600;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."' AND vacanza<'1'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."' AND vacanza<'1'");
while($chi=$db->QueryCicloResult($dacanc)){
$messaggio=sprintf($lang['mail_avviso_inattivita'],$chi['username'],$game_name,$game_server[$chi['server']]);
$email=new Email(1,$chi['email'],$lang['Account_inutilizzato'],$messaggio);
$avviso=$adesso+604800;
$db->QueryMod("UPDATE utenti SET avvinattivo='".$avviso."' WHERE userid='".$chi['userid']."'");
}//avviso inattivitą
$tempo=$adesso-2592000;
$dacanc=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE ultimologin<'".$tempo."' AND vacanza='0'");
$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."' AND vacanza='0'");
while($chi=$db->QueryCicloResult($dacanc)){
$eventi=$db->QuerySelect("SELECT count(id) AS n FROM eventi WHERE userid='".$chi['userid']."'");
if($eventi['n']==0){
$messaggio=sprintf($lang['mail_cancellato_inattivita'],$chi['username'],$game_name,$game_server[$chi['server']]);
$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
$db->QueryMod("UPDATE config SET utenti=utenti-'1' WHERE id='".$chi['server']."'");
$db->QueryMod("DELETE FROM caratteristiche WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM banca WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM inoggetti WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM messaggi WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM inmagia WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM equipaggiamento WHERE userid='".$chi['userid']."'");
$db->QueryMod("DELETE FROM userlog WHERE userid='".$chi['userid']."'");
}//se non ha eventi in corso
}//cancellazione inattivi senza vacanza attiva
?>