<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_miniera.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');
$seoggpicconi=$db->QuerySelect("SELECT count(id) AS id FROM inoggetti WHERE userid='".$user['userid']."'");
if($seoggpicconi['id']>0){
$oggpicconi=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='2' AND categoria='1'");
while($oggpiccone=$db->QueryCicloResult($oggpicconi)) {
$picconit[$oggpiccone['id']]=$oggpiccone['id'];
}//per ogni piccone
$oggpicconi2=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($oggpiccone2=$db->QueryCicloResult($oggpicconi2)) {
if(isset($picconit[$oggpiccone2['oggid']]))
$picconi[$oggpiccone2['oggid']]=$lang['oggetto'.$oggpiccone2['oggid'].'_nome'];
}//per ogni proprio oggetto
}//se ci sono picconi

if(isset($_POST['lavorainnuova'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if($usercar['energia']<100)
$errore.=$lang['miniera_errore1'];
if($usercar['saluteattuale']<30)
$errore.=$lang['miniera_errore2'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($config['banca']<1)
$errore.=$lang['global_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$user['userid']."','".$adesso."','3600','1','1','1','".$ore."')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine lavora in miniera nuova
if(isset($_POST['lavorainvecchia'])){
$errore="";
$ore=(int)$_POST['ore2'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if($usercar['energia']<200)
$errore.=$lang['miniera_errore1'];
if($usercar['saluteattuale']<30)
$errore.=$lang['miniera_errore2'];
$torcia=$db->QuerySelect("SELECT count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='1'");
if($torcia['numero']<$ore)
$errore.=$lang['miniera_errore4'];
$piccone=(int)$_POST['piccone'];
if($piccone<1)
$errore.=$lang['miniera_errore5'];
if($errore==""){
$picconesel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$piccone."' LIMIT 1");
if($usercar['attfisico']<$picconesel['forzafisica'])
$errore.=$lang['miniera_errore6'];
}//se piccone selezionato
if($usercar['minatore']<1)
$errore.=$lang['miniera_errore7'];
if($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$user['userid']."','".$adesso."','3600','5','1','3','".$piccone."','".$ore."')");
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine lavora in miniera vecchia
require('template/int_miniera.php');
?>