<?php
require_once('inclusi/funzioni_db.php');
require_once('inclusi/valori.php');
require_once('inclusi/funzioni.php');
$adesso=strtotime("now");
$db=new ConnessioniMySQL();
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
$config=$db->QuerySelect("SELECT * FROM config");
if($config['chiuso']==1){
	header("Location: ../index.php?error=12");
	exit();
}else{
	$int_security=$game_se_code;
	setcookie ("urbglogin", $user['userid']."|||".md5($user['username'])."|||".$user['password']."|||".$config['id']."|||".$config['language'],time()+10800);
	$db->QueryMod("UPDATE utenti SET ultimologin='".$adesso."',ipattuale='".$_SERVER['REMOTE_ADDR']."' WHERE userid='".$user['userid']."'");
	$language=$config['language'];
	require_once('inclusi/cancellazione.php');
	header("Location: index.php?loc=situazione");
	exit();
}
?>