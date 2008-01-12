<?php
require('inclusi/funzioni_db.php');
require('inclusi/valori.php');
$db = new ConnessioniMySQL();
$esistenza=0;		
	foreach($game_server as $chiave=>$elemento){
	if ($chiave==$_POST['login_server']){$esistenza=1;}
	}
if($esistenza==0){
	header("Location: ../index.php?error=3");
	exit();
} else{
$db->database=$_POST['login_server'];	
$_POST['login_username']=str_replace("'","\'",$_POST['login_username']);
$user = $db->QuerySelect("SELECT * FROM utenti WHERE username='".$_POST['login_username']."' AND password='".md5($_POST['login_password'])."' LIMIT 0,1");
}
if(!$user['userid']) {
	header("Location: ../index.php?error=1");
	exit();
}
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
	setcookie ("urbglogin", $user['userid']."|||".md5($user['username'])."|||".$user['password']."|||".$user['server'],time()+10800);
	$ora = strtotime("now");
	$db->QueryMod("UPDATE utenti SET ultimologin='".$ora."',ipattuale='".$_SERVER['REMOTE_ADDR']."' WHERE userid='".$user['userid']."'");

	header("Location: game.php");
	exit();	
}
?>