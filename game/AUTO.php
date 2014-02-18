<?php
$start_time=time()+microtime();//PER DEBUG EFFICENZA
require('inclusi/valori.php');

if($_GET['code']!=$scripts_se_code){header("Location: index.php?error=16"); exit();}

$int_security=$game_se_code;
$optimize=0;
foreach($game_language as $chiavel=>$elementol){
		$language=$chiavel;
		require('language/'.$language.'/lang_interno.php');
		require('language/'.$language.'/lang_oggetti_nomi.php');
	foreach($game_server as $chiave=>$elemento){
		if($game_server_lang[$chiave]==$chiavel){
			$db->Setdb($chiave);
			$config=$db->QuerySelect("SELECT * FROM config");
				if($config['chiuso']==0){
					require_once('inclusi/controllo_eventi.php');
					Controllaeventi(3);
					if($config['ottimizzazioni']<$adesso AND $optimize==0){
						$db->QueryMod("UPDATE config SET ottimizzazioni='".($adesso+3600)."'");//prossima "ottimizzazione" fra 1 ora
						$semorti=$db->QuerySelect("SELECT COUNT(userid) AS id FROM caratteristiche WHERE saluteattuale<'1'");
						if($semorti['id']>0){//se ci sono morti
							$morti=$db->QueryCiclo("SELECT * FROM caratteristiche WHERE saluteattuale<'1'");
							while($morto=$db->QueryCicloResult($morti)){
							$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$morto['userid']."'");
								if($eventi['id']==0){
									$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$morto['userid']."' LIMIT 1");
									$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$morto['userid']."' LIMIT 1");
									Dead($user,$usercar);
								}//se non ha eventi, e quindi resurrezione già in corso
							}//per ogni morto
						}//se ci sono morti
						$db->QueryMod("DELETE FROM sessione WHERE time<'".($adesso-10800)."'");// cancellazione di tutte le sessioni più vecchie di 3 ore
						$db->QueryMod("DELETE FROM msginviati WHERE data<'".($adesso-172800)."'");// cancellazione di tutti i msg inviati del regno più vecchi di 2 giorni
						$scaduto=$adesso-2592000;
						$quantimess=$db->QuerySelect("SELECT COUNT(id) AS n FROM messaggi WHERE data<'".$scaduto."'");
						if($quantimess['n']>0){
							$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."'");
						}//eliminazione di tutti i msg del regno più vecchi di 30 giorni
						$scaduto=$adesso-604800;
						$quantimess=$db->QuerySelect("SELECT COUNT(id) AS n FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
						if($quantimess['n']>0){
							$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
						}//eliminazione di tutti i msg letti del regno più vecchi di 7 giorni
						$quantirep=$db->QuerySelect("SELECT COUNT(id) AS n FROM battlereport WHERE data<'".$scaduto."'");
						if($quantirep['n']>0){
							$repscaduti=$db->QueryCiclo("SELECT id FROM battlereport WHERE data<'".$scaduto."'");
							while($reps=$db->QueryCicloResult($repscaduti)){
								$db->QueryMod("DELETE FROM battlereport WHERE id='".$reps['id']."' LIMIT 1");
								unlink("inclusi/log/report/".$config['id']."/".$reps['id'].".log");
							}//eliminazione di tutti i report del regno più vecchi di 7 giorni
						}//se ci sono report più vecchi di 7 giorni nel regno
						$optimize=1;
					}//se bisogna ottimizzare e nn è stato fatto in altri regni durante questa sessione
				if($config['atticriminali']<$adesso){
					$prob=rand(1,500);
					if($prob<=$config['crimine'])
						Controllacrimine($config);
					$tempopcrimine=3600-($config['utenti']*20);
					if($tempopcrimine<600){$tempopcrimine=600;}
						$db->QueryMod("UPDATE config SET atticriminali='".($adesso+$tempopcrimine)."'");
				}//controllo crime se necessario
				if($config['cancellazioni']<$adesso){
				$db->QueryMod("UPDATE config SET cancellazioni='".($adesso+86400)."'");//prossimo controllo cancellazioni fra 1 giorno
				$tempo=$adesso-172800;//2 giorni
				$dacanc=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
				if($dacanc['n']>0){
				$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND conferma='0'");
				while($chi=$db->QueryCicloResult($dacanc)){//cancellazione non confermati
					$messaggio=sprintf($lang['mail_cancellato_noconferma'],$chi['username'],$game_name,$game_server[$db->database]);
					$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
					$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
					$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
				}//fine cancellazione non confermati
				}
				$tempo=$adesso-259200;//3 giorni
				$dacanc=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
				if($dacanc['n']>0){
				$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE dataiscrizione<'".$tempo."' AND personaggio='0'");
				while($chi=$db->QueryCicloResult($dacanc)){//cancellazione senza personaggio
					$messaggio=sprintf($lang['mail_cancellato_nopersonaggio'],$chi['username'],$game_name,$game_server[$db->database]);
					$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
					$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
					$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
					$db->QueryMod("UPDATE config SET utenti=utenti-'1' LIMIT 1");
				}//fine cancellazione senza personaggio
				}
				$tempo=$adesso-1209600;//14 giorni
				$dacanc=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."' AND vacanza<'1'");
				if($dacanc['n']>0){
				$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."' AND avvinattivo<'".$adesso."' AND vacanza<'1'");
				while($chi=$db->QueryCicloResult($dacanc)){//avviso inattività
					$messaggio=sprintf($lang['mail_avviso_inattivita'],$chi['username'],$game_name,$game_server[$db->database]);
					$email=new Email(1,$chi['email'],$lang['Account_inutilizzato'],$messaggio);
					$avviso=$adesso+604800;
					$db->QueryMod("UPDATE utenti SET avvinattivo='".$avviso."' WHERE userid='".$chi['userid']."'");
				}//fine avviso inattività
				}
				$tempo=$adesso-2592000;//30 giorni
				$dacanc=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE ultimologin<'".$tempo."' AND vacanza='0'");
				if($dacanc['n']>0){
				$dacanc=$db->QueryCiclo("SELECT * FROM utenti WHERE ultimologin<'".$tempo."' AND vacanza='0'");
				while($chi=$db->QueryCicloResult($dacanc)){//cancellazione inattivi senza vacanza attiva
					$eventi=$db->QuerySelect("SELECT count(id) AS n FROM eventi WHERE userid='".$chi['userid']."'");
					if($eventi['n']==0){//se non ha eventi in corso
						$messaggio=sprintf($lang['mail_cancellato_inattivita'],$chi['username'],$game_name,$game_server[$db->database]);
						$email=new Email(1,$chi['email'],$lang['Account_cancellato'],$messaggio);
						$db->QueryMod("DELETE FROM utenti WHERE userid='".$chi['userid']."'");
						$db->QueryMod("INSERT INTO cacheuserid (userid,data) VALUES ('".$chi['userid']."','".$adesso."')");
						$db->QueryMod("UPDATE config SET utenti=utenti-'1' LIMIT 1");
						$db->QueryMod("DELETE FROM caratteristiche WHERE userid='".$chi['userid']."'");
						$db->QueryMod("DELETE FROM banca WHERE userid='".$chi['userid']."'");
						$db->QueryMod("DELETE FROM inoggetti WHERE userid='".$chi['userid']."'");
						$db->QueryMod("DELETE FROM messaggi WHERE userid='".$chi['userid']."'");
						$db->QueryMod("DELETE FROM inmagia WHERE userid='".$chi['userid']."'");
						$db->QueryMod("DELETE FROM equipaggiamento WHERE userid='".$chi['userid']."'");
					}//fine se non ha eventi in corso
				}//fine cancellazione inattivi senza vacanza attiva
				}
				}//fine controllo cancellazioni
				}//fine se il server non è chiuso
		}//fine se è di quella lingua
	}//fine ogni server
}//fine per ogni lingua

//PER DEBUG EFFICENZA
$end_time=time()+microtime();
$gen_time=number_format($end_time-$start_time, 4, '.', '');
if($gen_time>1 OR $db->nquery>100){
$db->Setdb(1000);
$log->Sistema("Debug AUTO ".date("d/m/y - H:i")." - Tempo di esecuzione:".$gen_time." secondi - Query eseguite:".$db->nquery);
}
?>
