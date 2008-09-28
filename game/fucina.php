<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_fucina.php');

if (isset($_POST['lavorafucapp'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['fucina_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
$regno=$db->QuerySelect("SELECT banca FROM config");
if($regno['banca']<1)
$errore.=$lang['global_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$user['userid']."','".$adesso."','3600','6','1','4','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine lavora in Fucina come apprendista

if (isset($_POST['lavorafucfab'])){
$errore="";
$ore=(int)$_POST['ore2'];
$oggettodaforgiare=(int)$_POST['oggettodf'];
$materiale=(int)$_POST['materiale'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['fucina_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if ($oggettodaforgiare<1 OR $oggettodaforgiare>6)
$errore.=$lang['fucina_errore5'];
if ($materiale<1 OR $materiale>4)
$errore.=$lang['fucina_errore9'];
if ($usercar['fabbro']<1)
$errore.=$lang['fucina_errore4'];
if($errore==""){
$seoggdf=$db->QuerySelect("SELECT COUNT(id) AS num FROM oggetti WHERE tipo='".$oggdf_num[$oggettodaforgiare][1]."' AND categoria='".$oggdf_num[$oggettodaforgiare][2]."' AND materiale='".$materiale."' AND abilitanec<='".$usercar['fabbro']."'");
if ($seoggdf['num']<1)
$errore.=$lang['fucina_errore10'];
if($materiali_num[$materiale][1]>0){
$carbone=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='2'");
if ($carbone['num']<($materiali_num[$materiale][1]*$ore))
$errore.=sprintf($lang['fucina_errore6'],($materiali_num[$materiale][1]*$ore));
}//se necessario carbone
if($materiali_num[$materiale][2]>0){
$rame=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='3'");
if ($rame['num']<($materiali_num[$materiale][2]*$ore))
$errore.=sprintf($lang['fucina_errore7'],($materiali_num[$materiale][2]*$ore));
}//se necessario rame
if($materiali_num[$materiale][3]>0){
$ferro=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='4'");
if ($ferro['num']<($materiali_num[$materiale][3]*$ore))
$errore.=sprintf($lang['fucina_errore8'],($materiali_num[$materiale][3]*$ore));
}//se necessario ferro
if($materiali_num[$materiale][4]>0){
$mithrill=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='10'");
if ($ferro['num']<($materiali_num[$materiale][4]*$ore))
$errore.=sprintf($lang['fucina_errore11'],($materiali_num[$materiale][4]*$ore));
}//se necessario mithrill
}// se non ci sono gli errori precedenti
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore,oggid,type) VALUES ('".$user['userid']."','".$adesso."','3600','9','1','7','".$ore."','".$oggettodaforgiare."','".$materiale."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine lavora in Fucina come fabbro

require('template/int_fucina.php');
?>