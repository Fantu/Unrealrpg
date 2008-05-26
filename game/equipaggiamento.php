<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_equipaggiamento.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');

$userequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$user['userid']."' LIMIT 1");

if (isset($_POST['impocac'])){
$errore="";
$acac=(int)$_POST['acac'];
if ($acac<1)
$errore.=$lang['equip_errore1'];
if($errore==""){
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$acacsel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$acac."' LIMIT 1");
if ($usercar['attfisico']<$acacsel['forzafisica'])
$errore.=$lang['equip_errore2'];
}//se arma selezionata
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($userequip['cac']!=0){$db->QueryMod("UPDATE inoggetti SET equip='0' WHERE userid='".$user['userid']."' AND oggid='".$userequip['cac']."' AND equip='1' LIMIT 1");}
$db->QueryMod("UPDATE equipaggiamento SET cac='".$acac."' WHERE userid='".$user['userid']."' LIMIT 1");
$db->QueryMod("UPDATE inoggetti SET equip='1' WHERE userid='".$user['userid']."' AND oggid='".$acac."' AND equip='0' LIMIT 1");
echo "<script language=\"javascript\">window.location.href='index.php?loc=equipaggiamento'</script>";
exit();
}
}//fine imposta arma corpo a corpo

$seogg=$db->QuerySelect("SELECT count(id) AS id FROM inoggetti WHERE userid='".$user['userid']."' AND equip='0'");
if($seogg['id']>0){
$oggacac=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='5'");
while($ogg=$db->QueryCicloResult($oggacac)) {
$armicact[$ogg['id']]=$ogg['id'];
}
$oggacac2=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' AND equip='0' GROUP BY oggid");
while($ogg2=$db->QueryCicloResult($oggacac2)) {
if(isset($armicact[$ogg2['oggid']]))
$armicac[$ogg2['oggid']]=$lang['oggetto'.$ogg2['oggid'].'_nome'];
}
}//se ci sono armi corpo a corpo

if($userequip['cac']!=0){
$usuraogg='';
if($user['plus']>0){
$usuraoggsel=$db->QuerySelect("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$userequip['cac']."' AND equip='1' LIMIT 1");
$usuraogg='title="'.$usuraoggsel['usura'].'"';
}
$armacacimpo="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$userequip['cac']."&amp;da=equip\"".$usuraogg.">".$lang['oggetto'.$userequip['cac'].'_nome']."</a>";
$desc_impocac=sprintf($lang['armacacimpo'],$armacacimpo);
}else{
$desc_impocac=$lang['noarmacacimpo'];
}

require('template/int_equipaggiamento.php');
?>