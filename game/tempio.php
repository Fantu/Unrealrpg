<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_tempio.php');
$resuscita=$user['resuscita'];
if(isset($_POST['prega'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
if($usercar['energia']<100)
$errore.=$lang['tempio_errore1'];
if($user['monete']<$ore)
$errore.=$lang['tempio_errore2'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,ore) VALUES ('".$user['userid']."','".$adesso."','3600','3','2','".$ore."')");	
$parlog=array(0=>$ore);
$log->Utenti($user['userid'],8,$parlog);
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine prega
if(isset($_POST['chierici'])){
$errore="";
$paga=100;
if($user['monete']<$paga)
$errore.=$lang['tempio_errore3'];
if($resuscita>0)
$errore.=$lang['tempio_errore4'];
if($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
$db->QueryMod("UPDATE utenti SET monete=monete-'".$paga."',resuscita='1' WHERE userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$paga."'");
$resuscita=1;
$parlog=array(0=>$paga);
$log->Utenti($user['userid'],9,$parlog);
}
}//fine chierici

if($usercar['fede']==0){
$pfede=$lang['Eretico'];
}elseif($usercar['fede']>0 AND $usercar['fede']<=100){
$pfede=$lang['Infedele'];
}elseif($usercar['fede']>100 AND $usercar['fede']<=500){
$pfede=$lang['Ateo'];
}elseif($usercar['fede']>500 AND $usercar['fede']<=1000){
$pfede=$lang['Credente'];
}elseif($usercar['fede']>1000 AND $usercar['fede']<=2000){
$pfede=$lang['Praticante'];
}elseif($usercar['fede']>2000 AND $usercar['fede']<=10000){
$pfede=$lang['Fedele'];
}elseif($usercar['fede']>10000 AND $usercar['fede']<=30000){
$pfede=$lang['Devoto'];
}elseif($usercar['fede']>30000 AND $usercar['fede']<=100000){
$pfede=$lang['Pio'];
}elseif($usercar['fede']>100000){
$pfede=$lang['Illuminato'];
}
$pfede=sprintf($lang['liv_fede'],$pfede);
?>