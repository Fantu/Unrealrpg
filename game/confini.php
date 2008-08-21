<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');
require_once('inclusi/funzioni_combact.php');
$do=htmlspecialchars($_GET['do'],ENT_QUOTES);

switch($do){
case "prova":
Startcombact($user['userid'],1,$user['server'],1);
echo "<script language=\"javascript\">window.location.href='index.php?loc=combact'</script>";
exit();
break;//fine prova
}

require('template/int_confini.php');
?>