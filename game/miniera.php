<?php
require('language/it/lang_miniera.php');
if (isset($_POST['lavorainnuova'])){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$usermin=$db->QuerySelect("SELECT * FROM miniera WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['miniera_errore2'];
if ($adesso<($usermin['ultimolavnuova']+21600))
$errore .= $lang['miniera_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$paga=5;
$energia=100-(5*$usercar['minatore']);
if ($energia<50)
$energia=50;
$salute=(rand(5,20))-(1*$usercar['minatore'])-(rand(0,floor($usercar['diffisica']/20)));
if ($salute<1)
$salute=1;
$exp=rand(5,(2+floor($usercar['saluteattuale']/10)+floor($usercar['energia']/100)+floor($usercar['attfisico']/10)));
$exp+=(5*(rand(0,(1+$usercar['minatore']))));
$db->QueryMod("UPDATE miniera t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavnuova='".$adesso."',t3.expminatore=t3.expminatore+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."' WHERE t1.userid='".$user['userid']."'");
$testo="<span>".sprintf($lang['report_lavminieranuova'],$paga,$exp,$energia,$salute)."</span><br /><br />";
$titolo=$lang['report_lavoro_nuova'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$user['userid']."','".$titolo."','".$testo."','0','".$adesso."')");
}
}//fine lavora in miniera nuova

require('template/int_miniera.php');
?>