<?php
require('language/it/lang_miniera.php');
if (isset($_POST['lavorainnuova'])){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['miniera_errore2'];
if ($adesso<($userlav['ultimolavoro']+21600))
$errore .= $lang['miniera_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro) VALUES ('".$user['userid']."','".$adesso."','3600','1','1','1')");	
header("Location: game.php?act=situazione");
exit();
}
}//fine lavora in miniera nuova
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_miniera.php');
}
?>