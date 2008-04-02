<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_situazione.php');
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$expnewmin=100+($usercar['minatore']*1500);
if($usercar['expminatore']>99) {
	if($usercar['expminatore']>=$expnewmin)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.minatore=t1.minatore+'1',t1.expminatore=t1.expminatore-'".$expnewmin."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv minatore
$expnewmin2=100+($usercar['alchimista']*1500);
if($usercar['expalchimista']>99) {
	if($usercar['expalchimista']>=$expnewmin2)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.alchimista=t1.alchimista+'1',t1.expalchimista=t1.expalchimista-'".$expnewmin2."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv alchimista
$expnewmin3=100+($usercar['fabbro']*1500);
if($usercar['expfabbro']>99) {
	if($usercar['expfabbro']>=$expnewmin3)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.fabbro=t1.fabbro+'1',t1.expfabbro=t1.expfabbro-'".$expnewmin3."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv fabbro
$expnewmin4=100+($usercar['magica']*1500);
if($usercar['expmagica']>99) {
	if($usercar['expmagica']>=$expnewmin4)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.magica=t1.magica+'1',t1.expmagica=t1.expmagica-'".$expnewmin4."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv magica
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$percmin1=floor((100/$expnewmin)*$usercar['expminatore']);
$percmin2=100-$percmin1;
$percmin3=floor((100/$expnewmin2)*$usercar['expalchimista']);
$percmin4=100-$percmin3;
$percmin5=floor((100/$expnewmin3)*$usercar['expfabbro']);
$percmin6=100-$percmin5;
$percmin7=floor((100/$expnewmin4)*$usercar['expmagica']);
$percmin8=100-$percmin7;
$expnewlevel=$usercar['livello']*100;
$quantimess=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");
if($quantimess['id']==0){
$newmsg=$lang['nessun_nuovo_msg'];
} elseif($quantimess['id']==1){
$newmsg="<a href=\"index.php?loc=messaggi\">".$lang['un_nuovo_msg']."</a>";
}else{
$newmsg="<a href=\"index.php?loc=messaggi\">".sprintf($lang['nuovi_msg'],$quantimess['id'])."</a>";
}//fine nuovi msg
if($eventi['id']>0){
	$eventi=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."' LIMIT 1");
	if($eventi['tipo']==5){
	$evento=$lang['eventi_dettagli'.$eventi['dettagli']];
	}else{
	$evento=$lang['eventi_dettagli'.$eventi['dettagli']].date($lang['dataora'],($eventi['datainizio']+$eventi['secondi']));}
	if($eventi['ore']>1)
	$evento.=" ".sprintf($lang['ore_in_coda'],($eventi['ore']-1))." ";
	if(($eventi['datainizio']+600)>$adesso AND $eventi['tipo']!=3){
	if($_GET['annullaevento']==1){
	$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
	header("Location: index.php?loc=situazione");
	exit();
	}
	if ($eventi['tipo']!=5 AND $eventi['tipo']!=3 AND $eventi['tipo']!=4)
	$evento.=" <a href=\"index.php?loc=situazione&amp;annullaevento=1\">".$lang['Annulla']."</a>";}
}
if(!$evento)
$evento=$lang['nessun_evento'];
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 1");
if($user['plus']==0){$tempoproxlav=$game_proxlav_normal;}else{$tempoproxlav=$game_proxlav_plus;}
$tempoproxlav=$tempoproxlav*$userlav['oreultimolav'];
if (($userlav['ultimolavoro']+$tempoproxlav)<$adesso){
$proxlavdata=$lang['Adesso'];
}else
{$proxlavdata=date($lang['dataora'],($userlav['ultimolavoro']+$tempoproxlav));}
$lavoroincorso=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$user['userid']."' AND tipo='1'");
if ($lavoroincorso['id']>0)
$proxlavdata=$lang['stai_gia_lavorando'];
$proxlav=$lang['prossimo_lavoro'].$proxlavdata;
$newscom=$db->QuerySelect("SELECT news,comunicazione FROM config LIMIT 1");
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>