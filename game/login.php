<?php
require('inclusi/funzioni_db.php');
require('inclusi/valori.php');
$adesso=strtotime("now");
$db = new ConnessioniMySQL();
$esistenza=0;
$server=(int)$_POST['login_server'];		
	foreach($game_server as $chiave=>$elemento){
	if ($chiave==$server){$esistenza=1;}
	}
if($esistenza==0){
	header("Location: ../index.php?error=3");
	exit();
} else{
$db->database=$server;	
$username=htmlspecialchars($_POST['login_username'],ENT_QUOTES);
$password=htmlspecialchars($_POST['login_password'],ENT_QUOTES);
$user=$db->QuerySelect("SELECT count(userid) AS numero FROM utenti WHERE username='".$username."' AND password='".md5($password)."' LIMIT 1");
}
if($user['numero']==0) {
	header("Location: ../index.php?error=1");
	exit();
}
$user=$db->QuerySelect("SELECT * FROM utenti WHERE username='".$username."' AND password='".md5($password)."' LIMIT 1");
if($user['conferma']==0) {
	header("Location: ../index.php?error=2");
	exit();
/*} else if($user['bloccato']>0 && strtotime("now")<$user['bloccato']) {
	header("Location: ../index.php?error=11&t=".$user['bloccato']);	
	exit();*/
}
$check = $db->QuerySelect("SELECT chiuso FROM config");
if($check['chiuso']==1) {
	header("Location: ../index.php?error=12");
	exit();
} else {
	$int_security=$game_se_code;      
	setcookie ("urbglogin", $user['userid']."|||".md5($user['username'])."|||".$user['password']."|||".$user['server']."|||".$user['language'],time()+10800);
	$db->QueryMod("UPDATE utenti SET ultimologin='".$adesso."',ipattuale='".$_SERVER['REMOTE_ADDR']."' WHERE userid='".$user['userid']."'");
	$scaduto=$ora-2592000;
	$quantimess=$db->QuerySelect("SELECT COUNT(id) AS id FROM messaggi WHERE data<'".$scaduto."'");
	if($quantimess['id']>0){
	$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."'");
	}
	$scaduto=$ora-604800;
	$quantimess=$db->QuerySelect("SELECT COUNT(id) AS id FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
	if($quantimess['id']>0){
	$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
	}
	$language=$user['language'];
	require('inclusi/cancellazione.php');
	header("Location: index.php?loc=situazione");
	exit();	
}
?>