<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
		if(isset($_POST['registra'])){
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
			if(empty($errore)){
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
			else{
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
				$newsletter=(int)$_POST['newsletter'];
				if($newsletter!=0 AND $newsletter!=1)
				$newsletter=1;
				$ue=$db->QuerySelect("SELECT COUNT(userid) AS n FROM cacheuserid WHERE data<'".($adesso-5184000)."'");
				if($ue['n']>0){
				$ue=$db->QuerySelect("SELECT userid FROM cacheuserid WHERE data<'".($adesso-5184000)."' LIMIT 1");
				$db->QueryMod("INSERT INTO utenti (userid,username,password,codice,email,dataiscrizione,ipreg,ultimazione,refer,refertime,ultimologin,mailnews) VALUES ('".$ue['userid']."','".$username."','".$pass."','".$cod."','".$_POST['email']."','".$adesso."','".$ip."','".$adesso."','".$refer."','".$refertime."','".$adesso."','".$newsletter."')");
				}else{//fine se si prende userid reciclato
				$db->QueryMod("INSERT INTO utenti (username,password,codice,email,dataiscrizione,ipreg,ultimazione,refer,refertime,ultimologin,mailnews) VALUES ('".$username."','".$pass."','".$cod."','".$_POST['email']."','".$adesso."','".$ip."','".$adesso."','".$refer."','".$refertime."','".$adesso."','".$newsletter."')");
				}//se non si prende userid reciclato
				$messaggio=sprintf($lang['testo_mail_conferma'],$game_name,$game_link,$server,$cod,$game_name);
				mail($_POST['email'],$lang['Conferma_account'].$game_name,$messaggio,$game_intestazione_mail);
				$outputreg=$lang['account_creato_ok'];
			}
		}//fine registrazione

require('game/template/est_pagina_home.php');
?>