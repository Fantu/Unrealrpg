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
$errore="";
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if ((100/$usercar['salute']*$usercar['saluteattuale'])<40 OR (100/$usercar['energiamax']*$usercar['energia'])<40)
$errore.=$lang['quest_error1'];
$expinc=1+floor($usercar['livello']/2);
if ($usercar['exp']>=$expinc*(120*$usercar['livello']))
$errore.=$lang['quest_error2'];
if($errore){
	$outputerrori="<span>".$lang['outputerroriquest']."</span><br /><span>".$errore."</span><br /><br />";}
else {
Startcombact($user['userid'],1,$user['server'],1);
echo "<script language=\"javascript\">window.location.href='index.php?loc=combact'</script>";
exit();
}
break;//fine prova
}

require('template/int_confini.php');
?>