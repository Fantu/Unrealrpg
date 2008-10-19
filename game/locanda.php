<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_locanda.php');

if(isset($_POST['dormi'])){
$errore="";
$ore=(int)$_POST['ore'];
if($ore<1 OR $ore>8)
$errore.=$lang['locanda_errore1'];
if($eventi['id']>0)
$errore .=$lang['global_errore1'];
$monete=ceil($ore/2);
if($user['monete']<$monete)
$errore.=sprintf($lang['locanda_errore2'],$ore,$monete);
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE utenti SET monete=monete-'".$monete."' WHERE userid='".$userid."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$monete."'");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,ore) VALUES ('".$user['userid']."','".$adesso."','3600','14','7','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine lavora in miniera nuova

require('template/int_locanda.php');
?>