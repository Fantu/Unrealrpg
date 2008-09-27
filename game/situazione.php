<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_situazione.php');
$expnewmin=100+($usercar['minatore']*1200);
if($usercar['expminatore']>99) {
	if($usercar['expminatore']>=$expnewmin)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.minatore=t1.minatore+'1',t1.expminatore=t1.expminatore-'".$expnewmin."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv minatore
$expnewmin2=100+($usercar['alchimista']*1200);
if($usercar['expalchimista']>99) {
	if($usercar['expalchimista']>=$expnewmin2)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.alchimista=t1.alchimista+'1',t1.expalchimista=t1.expalchimista-'".$expnewmin2."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv alchimista
$expnewmin3=100+($usercar['fabbro']*1200);
if($usercar['expfabbro']>99) {
	if($usercar['expfabbro']>=$expnewmin3)
	$db->QueryMod("UPDATE caratteristiche t1 SET t1.fabbro=t1.fabbro+'1',t1.expfabbro=t1.expfabbro-'".$expnewmin3."' WHERE t1.userid='".$user['userid']."'");
}//fine controllo aumento liv fabbro
$expnewmin4=100+($usercar['magica']*1200);
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
$expinc=1+floor($usercar['livello']/2);
$expnewlevel=$expinc*(120*$usercar['livello']);
if($snm['id']==0){
$newmsg=$lang['nessun_nuovo_msg'];
} elseif($snm['id']==1){
$newmsg="<a href=\"index.php?loc=messaggi\">".$lang['un_nuovo_msg']."</a>";
}else{
$newmsg="<a href=\"index.php?loc=messaggi\">".sprintf($lang['nuovi_msg'],$snm['id'])."</a>";
}//fine nuovi msg
if($eventi['id']>0){
	if($evento['tipo']==5 OR $evento['tipo']==8){
	$event=$lang['eventi_dettagli'.$evento['dettagli']];
	}else{
	$event=$lang['eventi_dettagli'.$evento['dettagli']].date($lang['dataora'],($evento['datainizio']+$evento['secondi']));}
	if($evento['ore']>1)
	$event.=" ".sprintf($lang['ore_in_coda'],($evento['ore']-1))." ";
	if(($evento['datainizio']+600)>$adesso AND $evento['tipo']!=3){
	if($_GET['annullaevento']==1){
	$db->QueryMod("DELETE FROM eventi WHERE userid='".$user['userid']."'");
	header("Location: index.php?loc=situazione");
	exit();
	}
	if ($evento['tipo']!=5 AND $evento['tipo']!=3 AND $evento['tipo']!=4 AND $evento['tipo']!=9)
	$event.=" <a href=\"index.php?loc=situazione&amp;annullaevento=1\">".$lang['Annulla']."</a>";}
}
if(!$event)
$event=$lang['nessun_evento'];
$newscom=$db->QuerySelect("SELECT news,comunicazione FROM config LIMIT 1");
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>