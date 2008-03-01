<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_fucina.php');

$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if($user['plus']==0){$tempoproxlav=$game_proxlav_normal;}else{$tempoproxlav=$game_proxlav_plus;}
$tempoproxlav=$tempoproxlav*$userlav['oreultimolav'];
$oggforgiare=$db->QuerySelect("SELECT count(id) AS id FROM oggetti WHERE tipo='2' AND abilitanec<='".$usercar['fabbro']."'");
if($oggforgiare['id']>0){
$oggforgiare=$db->QueryCiclo("SELECT id FROM oggetti WHERE tipo='2' AND abilitanec<='".$usercar['fabbro']."'");
while($oggforgia=$db->QueryCicloResult($oggforgiare)) {
$oggettiforgia[$oggforgia['id']]=$lang['oggetto'.$oggforgia['id'].'_nome'];
}
}//fine può tentare di forgiare almeno un oggetto
if (isset($_POST['lavorafucapp'])){
$errore="";
$ore=(int)$_POST['ore'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore .= $lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['fucina_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore .= $lang['fucina_errore3'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE lavori SET oreultimolav='0' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$user['userid']."','".$adesso."','3600','6','1','4','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();
}
}//fine lavora in Fucina come apprendista

if (isset($_POST['lavorafucfab'])){
$errore="";
$ore=(int)$_POST['ore2'];
$oggettodaforgiare=(int)$_POST['oggettodf'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if ($usercar['energia']<100)
$errore.=$lang['fucina_errore1'];
if ($usercar['saluteattuale']<30)
$errore.=$lang['fucina_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore.=$lang['fucina_errore3'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($ore<1 OR $ore>3)
$errore.=$lang['global_errore2'];
if ($oggettodaforgiare<1)
$errore.=$lang['fucina_errore5'];
$oggettodf=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggettodaforgiare."' LIMIT 1");
if ($usercar['fabbro']<$oggettodf['abilitanec'])
$errore.=$lang['fucina_errore4'];
$carbone=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='2'");
if ($carbone['num']<($oggettodf['carbone']*$ore))
$errore.=sprintf($lang['fucina_errore6'],($oggettodf['carbone']*$ore));
$rame=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='3'");
if ($rame['num']<($oggettodf['rame']*$ore))
$errore.=sprintf($lang['fucina_errore7'],($oggettodf['rame']*$ore));
$ferro=$db->QuerySelect("SELECT count(*) AS num FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='4'");
if ($ferro['num']<($oggettodf['ferro']*$ore))
$errore.=sprintf($lang['fucina_errore8'],($oggettodf['ferro']*$ore));
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE lavori SET oreultimolav='0' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore,oggid) VALUES ('".$user['userid']."','".$adesso."','3600','9','1','7','".$ore."','".$oggettodaforgiare."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();
}
}//fine lavora in Fucina come fabbro

require('template/int_fucina.php');
?>