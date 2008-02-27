<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
		if( $_POST['step']=="registrazione" ) {
			$errore="";
			$server=(int)$_POST['server'];
			foreach($game_server as $chiave=>$elemento){
			if ($chiave==$server){$esistenza=1;}
			}
			if($esistenza==1){
			$db->database=$server;}
			else{
				$errore.=$lang['reg_error1'];}
				if(!$_POST['username'])
					$errore.=$lang['reg_error2'];
				if( strlen($_POST['username'])<3 )
					$errore.=$lang['reg_error3'];
				if(!$_POST['password'])
					$errore.=$lang['reg_error4'];
				if(strlen($_POST['password'])<6)
					$errore.=$lang['reg_error5'];
				if(!$_POST['email'])
					$errore.=$lang['reg_error6'];
				if(!eregi("^.+@.+\..{2,3}$",$_POST['email']))	
					$errore.=$lang['reg_error7'];
			if( empty($errore) ) {
				$username=htmlspecialchars($_POST['username'],ENT_QUOTES);
				$a=$db->QuerySelect("SELECT maxutenti AS Max, utenti AS Ut FROM config WHERE id='".$server."'");	
				$a2=$db->QuerySelect("SELECT COUNT(*) AS Us1 FROM utenti WHERE username='".$username."'");				
				if($a2['Us1']>0)
					$errore.=$lang['reg_error8'];
				if($a['Ut']>=$a['Max'])
					$errore.=$lang['reg_error9'];
			}
			
			if($errore){
				$outputreg="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
			else {
				$ip=$_SERVER['REMOTE_ADDR'];
				$password=htmlspecialchars($_POST['password'],ENT_QUOTES);
				$pass=md5($password);
				$cod=md5($_POST['username']);
				$refer=0;
				$refertime=0;
				if($_COOKIE['urbgrefer']){
				$refer=htmlspecialchars($_COOKIE['urbgrefer'],ENT_QUOTES);
				$refertime=$adesso+172800;
				}
				$db->QueryMod("INSERT INTO utenti (username,password,codice,email,dataiscrizione,ipreg,server,ultimazione,refer,refertime,ultimologin,language) VALUES ('".$username."','".$pass."','".$cod."','".$_POST['email']."','".$adesso."','".$ip."','".$server."','".$adesso."','".$refer."','".$refertime."','".$adesso."','".$language."')");
				$messaggio=sprintf($lang['testo_mail_conferma'],$game_name,$game_link,$server,$cod,$game_name);
				mail($_POST['email'],$lang['Conferma_account'].$game_name,$messaggio,$game_intestazione_mail);
				$outputreg=$lang['account_creato_ok'];
			}
		}
foreach($game_server as $chiave=>$elemento){
if($language==$game_server_lang[$chiave]){
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
}
}//fine info server
<?php foreach($game_language as $chiave=>$elemento){
if($chiave!=$anguage)
$lingue[$chiave]="<a href=\"index_".$chiave.".php\">".$elemento."</a> "}
}//fine per ogni lingua
require('game/template/est_pagina_home.php');	  
?>