<?php
require('inclusi/funzioni_db.php');
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
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
} else{$db->database=$server;}
if($_COOKIE['urbgloginc']){
$loginfalliti=(int)$_COOKIE['urbgloginc'];}else{$loginfalliti=0;}
if($loginfalliti>4){
header("Location: ../index.php?error=8");
exit();
}
$username=htmlspecialchars($_POST['login_username'],ENT_QUOTES);
$password=htmlspecialchars($_POST['login_password'],ENT_QUOTES);
$user=$db->QuerySelect("SELECT count(userid) AS numero FROM utenti WHERE username='".$username."' LIMIT 1");

if($user['numero']>0) {
$user=$db->QuerySelect("SELECT * FROM utenti WHERE username='".$username."' LIMIT 1");
if($user['password']!=md5($password)){
	header("Location: ../index.php?error=4");
	$loginfalliti++;
	setcookie ("urbgloginc",$loginfalliti,time()+3600);
	exit();
}//se password errata
}else{
	header("Location: ../index.php?error=1");
	$loginfalliti++;
	setcookie ("urbgloginc",$loginfalliti,time()+3600);
	exit();
}//se username inesistente

if($user['conferma']==0){
	header("Location: ../index.php?error=2");
	exit();
/*} else if($user['bloccato']>0 && strtotime("now")<$user['bloccato']) {
	header("Location: ../index.php?error=11&t=".$user['bloccato']);	
	exit();*/
}
$check=$db->QuerySelect("SELECT chiuso FROM config");
if($check['chiuso']==1){
	header("Location: ../index.php?error=12");
	exit();
} else {
	$int_security=$game_se_code;      
	setcookie ("urbglogin", $user['userid']."|||".md5($user['username'])."|||".$user['password']."|||".$user['server']."|||".$user['language'],time()+10800);
	$db->QueryMod("UPDATE utenti SET ultimologin='".$adesso."',ipattuale='".$_SERVER['REMOTE_ADDR']."' WHERE userid='".$user['userid']."'");
	$scaduto=$adesso-2592000;
	$quantimess=$db->QuerySelect("SELECT COUNT(id) AS id FROM messaggi WHERE data<'".$scaduto."'");
	if($quantimess['id']>0){
	$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."'");
	}
	$scaduto=$adesso-604800;
	$quantimess=$db->QuerySelect("SELECT COUNT(id) AS id FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
	if($quantimess['id']>0){
	$db->QueryMod("DELETE FROM messaggi WHERE data<'".$scaduto."' AND letto='1'");
	}
	$quantirep=$db->QuerySelect("SELECT COUNT(id) AS id FROM battlereport WHERE data<'".$scaduto."'");
	if($quantirep['id']>0){
	$repscaduti=$db->QueryCiclo("SELECT id FROM battlereport WHERE data<'".$scaduto."'");
	while($reps=$db->QueryCicloResult($repscaduti)) {
	$db->QueryMod("DELETE FROM battlereport WHERE id='".$reps['id']."' LIMIT 1");
	unlink("inclusi/log/report/".$user['server']."/".$reps['id'].".log");
	}
	}
	$language=$user['language'];
	require('inclusi/cancellazione.php');
	header("Location: index.php?loc=situazione");
	exit();	
}
?>