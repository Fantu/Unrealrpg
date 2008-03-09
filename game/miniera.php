<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_miniera.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');
$oggpicconi=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='2' AND categoria='1'");
while($oggpiccone=$db->QueryCicloResult($oggpicconi)) {
$picconit[$oggpiccone['oggid']]=$oggpiccone['oggid'];
}
$oggpicconi=$db->QueryCiclo("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($oggpiccone=$db->QueryCicloResult($oggpicconi)) {
if(isset($picconit['oggid']))
$picconi[$oggpiccone['oggid']]=$lang['oggetto'.$oggpiccone['oggid'].'_nome'];
}
/*$seoggpicconi=$db->QuerySelect("SELECT count(t1.oggid) AS id FROM inoggetti AS t1 JOIN oggetti t2 ON t1.oggid=t2.id WHERE t1.userid='".$user['userid']."' AND t2.tipo='2' AND t2.categoria='1' GROUP BY t1.oggid");
if($seoggpicconi['id']>0){
$oggpicconi=$db->QueryCiclo("SELECT t1.oggid AS oggid FROM inoggetti AS t1 JOIN oggetti t2 ON t1.oggid=t2.id WHERE t1.userid='".$user['userid']."' AND t2.tipo='2' AND t2.categoria='1' GROUP BY t1.oggid");
while($oggpiccone=$db->QueryCicloResult($oggpicconi)) {
$picconi[$oggpiccone['oggid']]=$lang['oggetto'.$oggpiccone['oggid'].'_nome'];
}
}//fine se ha almeno un piccone*/
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if($user['plus']==0){$tempoproxlav=$game_proxlav_normal;}else{$tempoproxlav=$game_proxlav_plus;}
$tempoproxlav=$tempoproxlav*$userlav['oreultimolav'];
if (isset($_POST['lavorainnuova'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore .= $lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['miniera_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore .= $lang['miniera_errore3'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE lavori SET oreultimolav='0' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$user['userid']."','".$adesso."','3600','1','1','1','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();
}
}//fine lavora in miniera nuova
if (isset($_POST['lavorainvecchia'])){
$errore="";
$ore=(int)$_POST['ore2'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<200)
$errore .= $lang['miniera_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['miniera_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore .= $lang['miniera_errore3'];
$torcia=$db->QuerySelect("SELECT count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='1'");
if ($torcia['numero']<$ore)
$errore .= $lang['miniera_errore4'];
$piccone=(int)$_POST['piccone'];
if ($piccone<1)
$errore .= $lang['miniera_errore5'];
$picconesel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$piccone."' LIMIT 1");
if ($usercar['attfisico']<$picconesel['forzafisica'])
$errore .= $lang['miniera_errore6'];
if ($usercar['minatore']<1)
$errore .= $lang['miniera_errore7'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE lavori SET oreultimolav='0' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid,ore) VALUES ('".$user['userid']."','".$adesso."','3600','5','1','3','".$piccone."','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();
}
}//fine lavora in miniera vecchia
require('template/int_miniera.php');
?>