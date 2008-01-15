<?php
require('language/it/lang_laboratorio.php');
if (isset($_POST['lavoralabapp'])){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['lab_errore2'];
if ($adesso<($userlav['ultimolavoro']+21600))
$errore .= $lang['lab_errore3'];
if ($usercar['mana']<10)
$errore .= $lang['lab_errore4'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro) VALUES ('".$user['userid']."','".$adesso."','3600','2','1','2')");	
header("Location: game.php?act=situazione");
exit();	
}
}//fine lavora come apprendista
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_laboratorio.php');
}
?>