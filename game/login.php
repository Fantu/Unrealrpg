<?php
require_once('inclusi/valori.php');
$server=(int)$_POST['login_server'];
if(isset($game_server[$server])){$db->Setdb($server);}else{header("Location: ../index.php?error=3"); exit();}
if($_COOKIE['userloginc']){$loginfalliti=(int)$_COOKIE['userloginc'];}else{$loginfalliti=0;}
if($loginfalliti>4){header("Location: ../index.php?error=8"); exit();}
$username=htmlspecialchars($_POST['login_username'],ENT_QUOTES);
$password=htmlspecialchars($_POST['login_password'],ENT_QUOTES);
$user=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE username='".$username."' LIMIT 1");
if($user['n']==0){
	header("Location: ../index.php?error=1");
	$loginfalliti++;
	setcookie ("userloginc",$loginfalliti,time()+3600);
	exit();
}//se username inesistente
$user=$db->QuerySelect("SELECT * FROM utenti WHERE username='".$username."' LIMIT 1");
if($user['password']!=md5($password)){
	header("Location: ../index.php?error=4");
	$loginfalliti++;
	setcookie ("userloginc",$loginfalliti,time()+3600);
	exit();
}//se password errata

if($user['conferma']==0){
	header("Location: ../index.php?error=2");
	exit();
}
$config=$db->QuerySelect("SELECT * FROM config");
if($config['chiuso']==1){
	header("Location: ../index.php?error=12");
	exit();
}else{
	$int_security=$game_se_code;
	setcookie("userlogin",md5($user['userid'])."-".$user['password']."-".md5($config['id'])."-".md5($adesso),time()+10800);
	$db->QueryMod("UPDATE utenti SET ultimologin='".$adesso."' WHERE userid='".$user['userid']."'");
	$parlog=array(0=>$_SERVER['REMOTE_ADDR']);
	$log->Utenti($user['userid'],1,$parlog);
	$c=$db->QuerySelect("SELECT count(id) AS n FROM sessione WHERE id='".md5($user['userid'])."' LIMIT 1");
	if($c['n']!=0)
	$db->QueryMod("UPDATE sessione SET ip='".$_SERVER['REMOTE_ADDR']."',time='".$adesso."',password='".$user['password']."' WHERE id='".md5($user['userid'])."'");
	else
	$db->QueryMod("INSERT INTO sessione (id,userid,password,ip,time) VALUES ('".md5($user['userid'])."','".$user['userid']."','".$user['password']."','".$_SERVER['REMOTE_ADDR']."','".$adesso."')");
	$language=$config['language'];
	header("Location: index.php?loc=situazione");
	exit();
}
?>
