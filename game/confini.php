<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');
require_once('inclusi/funzioni_combact.php');

$secondi1=2000/800*(800-$usercar['velocita']);

if (isset($_POST['parti'])){
$direzione=(int)$_POST['direzione'];
$errore="";
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if ((100/$usercar['salute']*$usercar['saluteattuale'])<40 OR (100/$usercar['energiamax']*$usercar['energia'])<40)
$errore.=$lang['quest_error1'];
$expinc=1+floor($usercar['livello']/2);
if ($usercar['exp']>=$expinc*(120*$usercar['livello']))
$errore.=$lang['quest_error2'];
if ($direzione!=1)
$errore.=$lang['quest_error3'];
if($errore){
	$outputerrori="<span>".$lang['outputerroriquest']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$secondi1+=rand(10,200);
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,questid) VALUES ('".$user['userid']."','".$adesso."','".$secondi."','15','8','1')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}//se nessun errore
}//fine parti

require('template/int_confini.php');
?>