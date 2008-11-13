<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_opzioni.php');
if (isset($_POST['cambias'])){
$errore="";
$sesso=$_POST['sesso'];
if($sesso<0 AND $sesso>2)
$errore.=$lang['opzioni_error1']."<br />";
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
$db->QueryMod("UPDATE caratteristiche SET sesso='".$sesso."' WHERE userid='".$user['userid']."'");
$outputerrori="<span>".$lang['sesso_modificato']."</span><br /><br />";
}
}//fine cambia sesso

if(isset($_POST['cambiap'])){
$errore="";
$vpassword=htmlspecialchars($_POST['vpassword'],ENT_QUOTES);
$vpass=md5($vpassword);
$npassword=htmlspecialchars($_POST['npassword'],ENT_QUOTES);
$rpassword=htmlspecialchars($_POST['rpassword'],ENT_QUOTES);
$npass=md5($npassword);
if($vpass!=$user['password'])
$errore.=$lang['opzioni_error3']."<br />";
if($npassword!=$rpassword)
$errore.=$lang['opzioni_error4']."<br />";
if(strlen($npassword)<6 OR strlen($npassword)>20)
$errore.=$lang['opzioni_error5']."<br />";
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
$db->QueryMod("UPDATE utenti SET password='".$npass."' WHERE userid='".$user['userid']."'");
header("Location: ../index.php");
exit();
}
}//fine cambia password

switch($_GET['attivaplus']){
case "1":
$punti=3;
$tattivazioneplus=604800;
break;
case "2":
$punti=10;
$tattivazioneplus=2592000;
break;
case "3":
$punti=100;
$tattivazioneplus=31536000;
break;
}

$news=(int)$_GET['newsletter'];
if(isset($_GET['newsletter']) AND $news!=$user['mailnews']){
$db->QueryMod("UPDATE utenti SET mailnews='".$news."' WHERE userid='".$user['userid']."' LIMIT 1");
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}

$vac=(int)$_GET['vacanza'];
if(isset($_GET['vacanza']) AND $vac!=$user['vacanza']){
$db->QueryMod("UPDATE utenti SET vacanza='".$vac."' WHERE userid='".$user['userid']."' LIMIT 1");
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}

if(!empty($tattivazioneplus)){
if($user['puntiplus']<$punti)
$errore.=$lang['opzioni_error2']."<br />";
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
if($user['plus']==0){
$db->QueryMod("UPDATE utenti SET plus=('".$adesso."'+'".$tattivazioneplus."'),puntiplus=puntiplus-'".$punti."' WHERE userid='".$user['userid']."'");
}else{
$db->QueryMod("UPDATE utenti SET plus=plus+'".$tattivazioneplus."',puntiplus=puntiplus-'".$punti."' WHERE userid='".$user['userid']."'");
}
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}
}//fine attivazione plus con punti plus

$linkref=$game_link."/index.php?refer=".$user['userid']."&amp;server=".$config['id'];

if($user['mailnews']==0)
$newsletters=$lang['newsletter_disattiva']." <a href=\"index.php?loc=opzioni&amp;newsletter=1\">".$lang['attiva']."</a>";
else
$newsletters=$lang['newsletter_attiva']." <a href=\"index.php?loc=opzioni&amp;newsletter=0\">".$lang['disattiva']."</a>";

if($user['vacanza']==0)
$vacanza=$lang['vacanza_disattiva']." <a href=\"index.php?loc=opzioni&amp;vacanza=1\">".$lang['attiva']."</a>";
else
$vacanza=$lang['vacanza_attiva']." <a href=\"index.php?loc=opzioni&amp;vacanza=0\">".$lang['disattiva']."</a>";

require_once('inclusi/personaggio.php');
require('template/int_opzioni.php');
?>