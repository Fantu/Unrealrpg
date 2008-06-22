<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_situazione.php');

$expinc=1+floor($usercar['livello']/2);
$expnewlevel=$expinc*(120*$usercar['livello']);
if($usercar['exp']<$expnewlevel){
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}

if (isset($_POST['sali'])){
$errore="";
$salute=(int)$_POST['salute'];
$energia=(int)$_POST['energia'];
$mana=(int)$_POST['mana'];
if (($salute+$energia+$mana)!=10)
$errore.=$lang['levelup_errore1'];
$caratteristichelup=array('attfisico','attmagico','diffisica','difmagica','velocita','agilita','intelligenza','destrezza');
$somma=0;
$troppi=0;
foreach($caratteristichelup as $chiave=>$elemento){
$carattuale=(int)$_POST[$caratteristichelup[$chiave]];
if($carattuale>10)
$troppi=1;
$somma+=$carattuale;
}//per caratteristica
if ($troppi==1)
$errore.=$lang['levelup_errore2'];
if ($somma!=20)
$errore.=$lang['levelup_errore3'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else{
$salute=round($usercar['salute']/100*$salute);
$energia=round($usercar['energiamax']/100*$energia);
$mana=round($usercar['mana']/100*$mana);
foreach($caratteristichelup as $chiave=>$elemento){
$carattuale=(int)$_POST[$caratteristichelup[$chiave]];
if($carattuale>0){
$incremento=round($usercar[$caratteristichelup[$chiave]]/100*$carattuale);
$setcaratteristiche.=",".$caratteristichelup[$chiave]."=".$caratteristichelup[$chiave]."+".$incremento;
}
}//per caratteristica
$db->QueryMod("UPDATE caratteristiche SET livello=livello+'1',salute=salute+'".$salute."',energiamax=energiamax+'".$energia."',mana=mana+'".$mana."'".$setcaratteristiche.",exp=exp-'".$expnewlevel."' WHERE userid='".$user['userid']."' LIMIT 1");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}//incremento di livello se ok
}//fine incrementa di livello

require('template/int_levelup.php');
?>