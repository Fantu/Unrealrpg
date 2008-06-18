<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_tempio.php');
if (isset($_POST['prega'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore.=$lang['tempio_errore1'];
if ($user['monete']<$ore)
$errore.=$lang['tempio_errore2'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,ore) VALUES ('".$user['userid']."','".$adesso."','3600','3','2','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine prega
if (isset($_POST['chierici'])){
$errore="";
$paga=100;
if ($user['monete']<$paga)
$errore.=$lang['tempio_errore3'];
if ($user['resuscita']>0)
$errore.=$lang['tempio_errore4'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE utenti SET monete=monete-'".$paga."',resuscita='1' WHERE userid='".$user['userid']."'");
}
}//fine chierici
require('template/int_tempio.php');
?>