<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_equipaggiamento.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');

$userequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$user['userid']."' LIMIT 1");

//----------------------------
//IMPOSTAZIONE EQUIPAGGIAMENTO
//----------------------------

if (isset($_POST['impocac'])){
$errore="";
$acac=(int)$_POST['acac'];
if ($acac<0)
$errore.=$lang['equip_errore1'];
if($errore=="" AND $acac>0){
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$acacsel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$acac."' LIMIT 1");
if ($usercar['attfisico']<$acacsel['forzafisica'])
$errore.=$lang['equip_errore2'];
}//se arma selezionata
if ($eventi['id']>0 AND $evento['tipo']!=4)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($userequip['cac']!=0){
$datrasf=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['cac']."' LIMIT 1");
$db->QueryMod("DELETE FROM equip WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO inoggetti (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}//se c'è già un oggetto impo
$db->QueryMod("UPDATE equipaggiamento SET cac='".$acac."' WHERE userid='".$user['userid']."' LIMIT 1");
if($acac!=0){
$datrasf=$db->QuerySelect("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$acac."' LIMIT 1");
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO equip (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}
echo "<script language=\"javascript\">window.location.href='index.php?loc=equipaggiamento'</script>";
exit();
}
}//fine imposta arma corpo a corpo

if (isset($_POST['impoarm'])){
$errore="";
$armatura=(int)$_POST['arm'];
if ($armatura<0)
$errore.=$lang['equip_errore1'];
if($errore=="" AND $armatura>0){
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$armsel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$armatura."' LIMIT 1");
if ($usercar['attfisico']<$armsel['forzafisica'])
$errore.=$lang['equip_errore2'];
}//se armatura selezionata
if ($eventi['id']>0 AND $evento['tipo']!=4)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($userequip['arm']!=0){
$datrasf=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['arm']."' LIMIT 1");
$db->QueryMod("DELETE FROM equip WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO inoggetti (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}//se c'è già un oggetto impo
$db->QueryMod("UPDATE equipaggiamento SET arm='".$armatura."' WHERE userid='".$user['userid']."' LIMIT 1");
if($armatura!=0){
$datrasf=$db->QuerySelect("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$armatura."' LIMIT 1");
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO equip (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}
echo "<script language=\"javascript\">window.location.href='index.php?loc=equipaggiamento'</script>";
exit();
}
}//fine imposta armatura

if (isset($_POST['imposcu'])){
$errore="";
$scudo=(int)$_POST['scu'];
if ($scudo<0)
$errore.=$lang['equip_errore1'];
if($errore=="" AND $scudo>0){
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$scusel=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$scudo."' LIMIT 1");
if ($usercar['attfisico']<$scusel['forzafisica'])
$errore.=$lang['equip_errore2'];
}//se scudo selezionato
if ($eventi['id']>0 AND $evento['tipo']!=4)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($userequip['scu']!=0){
$datrasf=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['scu']."' LIMIT 1");
$db->QueryMod("DELETE FROM equip WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO inoggetti (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}//se c'è già un oggetto impo
$db->QueryMod("UPDATE equipaggiamento SET scu='".$scudo."' WHERE userid='".$user['userid']."' LIMIT 1");
if($scudo!=0){
$datrasf=$db->QuerySelect("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$scudo."' LIMIT 1");
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO equip (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}
echo "<script language=\"javascript\">window.location.href='index.php?loc=equipaggiamento'</script>";
exit();
}
}//fine imposta scudo

if (isset($_POST['impopoz'])){
$errore="";
$pozione=(int)$_POST['poz'];
if ($pozione<0)
$errore.=$lang['equip_errore1'];
if ($eventi['id']>0 AND $evento['tipo']!=4)
$errore.=$lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($userequip['poz']!=0){
$datrasf=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['poz']."' LIMIT 1");
$db->QueryMod("DELETE FROM equip WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO inoggetti (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}//se c'è già un oggetto impo
$db->QueryMod("UPDATE equipaggiamento SET poz='".$pozione."' WHERE userid='".$user['userid']."' LIMIT 1");
if($pozione!=0){
$datrasf=$db->QuerySelect("SELECT * FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$pozione."' LIMIT 1");
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$datrasf['id']."' LIMIT 1");
$db->QueryMod("INSERT INTO equip (oggid,userid,usura) VALUES ('".$datrasf['oggid']."','".$datrasf['userid']."','".$datrasf['usura']."')");
}
echo "<script language=\"javascript\">window.location.href='index.php?loc=equipaggiamento'</script>";
exit();
}
}//fine imposta pozione

//-------------------------------
//VISUALIZZAZIONE EQUIPAGGIAMENTO
//-------------------------------

$seogg=$db->QuerySelect("SELECT count(id) AS id FROM inoggetti WHERE userid='".$user['userid']."'");
if($seogg['id']>0){
$oggacac=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='5'");
while($ogg=$db->QueryCicloResult($oggacac)) {
$armicact[$ogg['id']]=$ogg['id'];
}
$oggetti=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg2=$db->QueryCicloResult($oggetti)) {
if(isset($armicact[$ogg2['oggid']]))
$armicac[$ogg2['oggid']]=$lang['oggetto'.$ogg2['oggid'].'_nome'];
}
$oggarm=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='6' AND categoria='1'");
while($ogg=$db->QueryCicloResult($oggarm)) {
$armt[$ogg['id']]=$ogg['id'];
}
$oggetti=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg2=$db->QueryCicloResult($oggetti)) {
if(isset($armt[$ogg2['oggid']]))
$armature[$ogg2['oggid']]=$lang['oggetto'.$ogg2['oggid'].'_nome'];
}
$oggscu=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='6' AND categoria='2'");
while($ogg=$db->QueryCicloResult($oggscu)) {
$scut[$ogg['id']]=$ogg['id'];
}
$oggetti=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg2=$db->QueryCicloResult($oggetti)) {
if(isset($scut[$ogg2['oggid']]))
$scudi[$ogg2['oggid']]=$lang['oggetto'.$ogg2['oggid'].'_nome'];
}
$oggpoz=$db->QueryCiclo("SELECT * FROM oggetti WHERE tipo='4'");
while($ogg=$db->QueryCicloResult($oggpoz)) {
$pozt[$ogg['id']]=$ogg['id'];
}
$oggetti=$db->QueryCiclo("SELECT oggid FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg2=$db->QueryCicloResult($oggetti)) {
if(isset($pozt[$ogg2['oggid']]))
$pozioni[$ogg2['oggid']]=$lang['oggetto'.$ogg2['oggid'].'_nome'];
}
}//se ci sono oggetti

if($userequip['cac']!=0){
$usuraogg='';
if($user['plus']>0){
$usuraoggsel=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['cac']."' LIMIT 1");
$usuraogg='title="'.$lang['usura_attuale'].$usuraoggsel['usura'].'"';
}
$armacacimpo="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$userequip['cac']."&amp;da=equip\"".$usuraogg.">".$lang['oggetto'.$userequip['cac'].'_nome']."</a>";
$desc_impocac=sprintf($lang['armacacimpo'],$armacacimpo);
}else{
$desc_impocac=$lang['noarmacacimpo'];
}

if($userequip['arm']!=0){
$usuraogg='';
if($user['plus']>0){
$usuraoggsel=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['arm']."' LIMIT 1");
$usuraogg='title="'.$lang['usura_attuale'].$usuraoggsel['usura'].'"';
}
$armimpo="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$userequip['arm']."&amp;da=equip\"".$usuraogg.">".$lang['oggetto'.$userequip['arm'].'_nome']."</a>";
$desc_impoarm=sprintf($lang['armimpo'],$armimpo);
}else{
$desc_impoarm=$lang['noarmimpo'];
}

if($userequip['scu']!=0){
$usuraogg='';
if($user['plus']>0){
$usuraoggsel=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['scu']."' LIMIT 1");
$usuraogg='title="'.$lang['usura_attuale'].$usuraoggsel['usura'].'"';
}
$scuimpo="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$userequip['scu']."&amp;da=equip\"".$usuraogg.">".$lang['oggetto'.$userequip['scu'].'_nome']."</a>";
$desc_imposcu=sprintf($lang['scuimpo'],$scuimpo);
}else{
$desc_imposcu=$lang['noscuimpo'];
}

if($userequip['poz']!=0){
$usuraogg='';
if($user['plus']>0){
$usuraoggsel=$db->QuerySelect("SELECT * FROM equip WHERE userid='".$user['userid']."' AND oggid='".$userequip['scu']."' LIMIT 1");
$usuraogg='title="'.$lang['usura_attuale'].$usuraoggsel['usura'].'"';
}
$pozimpo="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$userequip['poz']."&amp;da=equip\"".$usuraogg.">".$lang['oggetto'.$userequip['poz'].'_nome']."</a>";
$desc_impopoz=sprintf($lang['pozimpo'],$pozimpo);
}else{
$desc_impopoz=$lang['nopozimpo'];
}

require('template/int_equipaggiamento.php');
?>