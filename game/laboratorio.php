<?php
require('language/it/lang_laboratorio.php');
if (isset($_POST['lavoralabapp'])){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$userlab=$db->QuerySelect("SELECT * FROM laboratorio WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['lab_errore2'];
if ($adesso<($userlab['ultimolavapp']+21600))
$errore .= $lang['lab_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$paga=5;
$energia=100-(5*$usercar['alchimista']);
if ($energia<50)
$energia=50;
$salute=(rand(2,10))-(1*$usercar['alchimista'])-(rand(0,floor($usercar['difmagica']/10)));
if ($salute<1)
$salute=1;
$exp=rand(5,(2+floor($usercar['saluteattuale']/10)+floor($usercar['energia']/100)+floor($usercar['attmagico']/10)));
$exp+=(5*(rand(0,$usercar['alchimista'])));
$db->QueryMod("UPDATE laboratorio t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavapp='".$adesso."',t3.expalchimista=t3.expalchimista+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."' WHERE t1.userid='".$user['userid']."'");
$testo="<span>".sprintf($lang['report_lavlabapp'],$paga,$exp,$energia,$salute)."</span><br /><br />";
$titolo=$lang['report_lavoro_labapp'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$user['userid']."','".$titolo."','".$testo."','0','".$adesso."')");
}
}//fine lavora come apprendista

require('template/int_laboratorio.php');
?>