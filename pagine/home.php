<?php
		if( $_POST['step']=="registrazione" ) {
			$errore="";
			$server=(int)$_POST['server'];
			foreach($game_server as $chiave=>$elemento){
			if ($chiave==$server){$esistenza=1;}
			}
			if($esistenza==1){
			$db->database=$server;}
			else{
				$errore .= "- Non hai selezionato il server";}
				if(!$_POST['username'])
					$errore.="- Non hai scritto il tuo username.<br />";
				if( strlen($_POST['username'])<3 )
					$errore.="- L'username deve essere almeno di 3 caratteri.<br />";
				if(!$_POST['password'])
					$errore.="- Non hai scritto la password.<br />";
				if(strlen($_POST['password'])<6)
					$errore.="- La password deve essere lunga almeno 6 caratteri.<br />";
				if(!$_POST['email'])
					$errore.="- Non hai scritto l'email.<br />";
				if(!eregi("^.+@.+\..{2,3}$",$_POST['email']))	
					$errore.="- L'email inserita non sembra essere corretta.<br />";
			if( empty($errore) ) {
				$a=$db->QuerySelect("SELECT maxutenti AS Max, utenti AS Ut FROM config WHERE id='".$_POST['server']."'");	
				$a2=$db->QuerySelect("SELECT COUNT(*) AS Us1 FROM utenti WHERE username='".$_POST['username']."'");				
				if($a2['Us1']>0)
					$errore.="- L'username che hai scelto � gi� stato preso.<br />";
				if($a['Ut']>=$a['Max'])
					$errore.="- Questo server � al momento troppo affollato, scegline un altro.<br />";
			}
			
			if($errore){
				$outputreg="<span>Si sono verificati i seguenti errori:</span><br /><span>".$errore."</span><br /><br />";}
			else {
				$ip=$_SERVER['REMOTE_ADDR'];
				$pass=md5($_POST['password']);
				$cod=md5($_POST['username']);
				$refer=0;
				$refertime=0;
				if($_COOKIE['urbgrefer']){
				$refer=htmlentities($_COOKIE['urbgrefer']);
				$refertime=$adesso+172800;
				}
				$username=htmlentities($_POST['username']);
				$db->QueryMod("INSERT INTO utenti (username,password,codice,email,dataiscrizione,ipreg,server,ultimazione,refer,refertime) VALUES ('".$username."','".$pass."','".$cod."','".$_POST['email']."','".$adesso."','".$ip."','".$server."','".$adesso."','".$refer."','".$refertime."')");		
				$intestazione = "From: ".$game_name."<server@lostage.it>\r\n";
				$messaggio="Ciao,\nPer confermare l'iscrizione a ".$game_name." devi visitare il link sottostante:\n ".$game_link."/conferma.php?t=".$server."&cod=$cod \n\nFinch� l'account non verr� confermato non potrai accedere al gioco.\nSaluti,\n".$game_name." Staff";
				mail($_POST['email'],"Conferma account ".$game_name,$messaggio,$intestazione);
				$outputreg="<strong>Account creato con successo!!</strong><br />Prima di poter iniziare a giocare dovrai confermare l'iscrizione visitando il link contenuto nella mail che ti � stata inviata all'indirizzo di posta inserito.<br />Se non trovi la mail controlla nella cartella posta indesiderata antispam o simili.<br /><br />";
			}
		}
foreach($game_server as $chiave=>$elemento){
$infoserver['nome'][$chiave]=$elemento;
$db->database=$chiave;
$utenti=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti");
$infoserver['utenti'][$chiave]=$utenti['id'];
$adesso=strtotime("now");
$sereg=$adesso-604800;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE dataiscrizione>'".$sereg."'");
$infoserver['utentilw'][$chiave]=$online['id'];
$seonline=$adesso-600;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
$infoserver['online'][$chiave]=$online['id'];
$seonline=$adesso-86400;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
$infoserver['online24'][$chiave]=$online['id'];
}//fine info server
require('game/template/est_pagina_home.php');	  
?>