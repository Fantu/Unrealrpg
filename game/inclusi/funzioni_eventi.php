<?php
function Completalavminnuova($userid) {
global $db,$adesso;
require('language/it/lang_miniera.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 0,1");	
$paga=5;
$energia=100-(5*$usercar['minatore']);
if ($energia<50)
$energia=50;
$salute=(rand(2,10))-($usercar['minatore'])-(rand(0,floor($usercar['diffisica']/20)));
if ($salute<1)
$salute=1;
$exp=rand(5,(2+floor($usercar['saluteattuale']/10)+floor($usercar['energia']/100)+floor($usercar['attfisico']/10)));
$exp+=(5*(rand(0,(1+$usercar['minatore']))));
$esplosione=rand(10,100)-($usercar['minatore']*5)-($usercar['attfisico']/2);
$danni=0;
if($esplosione>10){
$esplosione=rand(10,100)-($usercar['agilita']/5)-($usercar['attfisico']/2);
if($esplosione<10){
$testo="<span>".$lang['report_incidente_min1']."</span><br /><br />";
}else{
$danni=rand(5,30)-rand(0,floor($usercar['diffisica']/10));
if ($danni<1)
$danni=1;	
$testo="<span>".sprintf($lang['report_incidente_min2'],$danni)."</span><br /><br />";	
}
$titolo=$lang['report_incidente_miniera'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");	
}//fine incidente
$testo="<span>".sprintf($lang['report_lavminieranuova'],$paga,$exp,$energia,$salute)."</span><br /><br />";
$titolo=$lang['report_lavoro_nuova'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$userid."','".$titolo."','".$testo."','0','".$adesso."')");
$salute+=$danni;
$db->QueryMod("UPDATE lavori t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.ultimolavoro='".$adesso."',t3.expminatore=t3.expminatore+'".$exp."',t2.monete=t2.monete+'".$paga."',t3.energia=t3.energia-'".$energia."',t3.saluteattuale=t3.saluteattuale-'".$salute."' WHERE t1.userid='".$userid."'");
} //fine Completalavminnuova
?>