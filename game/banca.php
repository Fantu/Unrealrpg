<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_banca.php');
$checklotteria = $db->QuerySelect("SELECT lotteria FROM config");
if($checklotteria['lotteria']==0){$db->QueryMod("UPDATE config SET lotteria='".$adesso."'");}else{
if($checklotteria['lotteria']<($adesso+604800)){
$partecipanti=$db->QuerySelect("SELECT COUNT(userid) AS num FROM banca WHERE lotteria>0");
if($partecipanti['num']>0){
$estratto=0;
if($partecipanti['num']>1)
$estratto=rand(0,($partecipanti['num']-1));
$vincita=$partecipanti['num'];
if($vincita>100)
$vincita=100;
$vincitore=$db->QuerySelect("SELECT userid FROM banca WHERE lotteria>0 LIMIT ".$estratto.",1");
$db->QueryMod("UPDATE config SET lotteria='".$adesso."', banca=banca-'".$vincita."'");
$db->QueryMod("UPDATE banca SET lotteria='0',vincitore='0'");
$db->QueryMod("UPDATE banca SET conto=conto+'".$vincita."',vincitore='1' WHERE userid='".$vincitore['userid']."'");
}//se c'è almeno un partecipante
}//fine estrazione
}//fine controllo se estrazione
$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 1");
if (($userbank['interessi']+86400)<$adesso){
	$differenzaora=$adesso-$userbank['interessi'];
	$giorni=floor($differenzaora/86400);
	$interessi=floor(($userbank['conto']/100)*0.5);
	if($interessi>0)
	$interessi=$interessi*$giorni;
	if ($interessi>0){
		$db->QueryMod("UPDATE banca SET conto=conto+'".$interessi."',interessi=interessi+'".(86400*$giorni)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE banca SET interessi='".$adesso."' WHERE userid='".$user['userid']."'");}
	$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 1");
}
$infointeressi=$lang['info_interessi']." ".date($lang['dataora'],($userbank['interessi']+86400));
if (isset($_POST['deposita'])){
$errore="";
$dadepositare=(int)$_POST['dadepositare'];
if (!is_numeric($dadepositare)){
$errore .= $lang['banca_errore1'];}
else{
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if ($dadepositare<1)
$errore .= $lang['banca_errore2'];
if ($dadepositare>$user['monete'])
$errore .= $lang['banca_errore3'];
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.conto=t1.conto+'".$dadepositare."',t1.interessi='".$adesso."',t2.monete=t2.monete-'".$dadepositare."',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$dadepositare."'");
}
}//fine deposita
if (isset($_POST['preleva'])){
$errore="";
$daprelevare=(int)$_POST['daprelevare'];
if (!is_numeric($daprelevare)){
$errore .= $lang['banca_errore1'];}
else{
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if ($daprelevare<1)
$errore .= $lang['banca_errore4'];
$userbank=$db->QuerySelect("SELECT conto FROM banca WHERE userid='".$user['userid']."' LIMIT 1");
if ($daprelevare>$userbank['conto'])
$errore .= $lang['banca_errore5'];
$deposito = $db->QuerySelect("SELECT banca FROM config");
if ($daprelevare>$deposito['banca'])
$errore .= $lang['banca_errore6'];
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.conto=t1.conto-'".$daprelevare."',t2.monete=t2.monete+'".$daprelevare."',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$daprelevare."'");
}
}//fine preleva
if (isset($_POST['chiediprestito'])){
$errore="";
$prestito=(int)$_POST['inprestito'];
if (!is_numeric($prestito)){
$errore .= $lang['banca_errore1'];}
else{
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
$prestitopossibile=($usercar['livello']*100)-$userbank['prestito'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if ($prestito<1)
$errore .= $lang['banca_errore7'];
$deposito = $db->QuerySelect("SELECT banca FROM config");
if ($prestito>$deposito['banca'])
$errore .= $lang['banca_errore6'];
if ($prestito>$prestitopossibile)
$errore .= $lang['banca_errore8']." ".$prestitopossibile."<br />";
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.prestito=t1.prestito+'".$prestito."',t2.monete=t2.monete+'".$prestito."',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$prestito."'");
}
}//fine chiedi prestito
if (isset($_POST['restituisciprestito'])){
$errore="";
$prestito=$userbank['prestito']+(floor(($userbank['prestito']/100)*10));
if ($user['monete']<$prestito)
$errore .= $lang['banca_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.prestito=t1.prestito-'".$prestito."',t2.monete=t2.monete-'".$prestito."',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$prestito."'");
}
}//fine restituisci prestito
if (isset($_POST['comprabiglietto'])){
$errore="";
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if($userbank['conto']<1)
$errore.=$lang['banca_errore9'];
if($userbank['lotteria']>0)
$errore.=$lang['banca_errore10'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca t1 JOIN caratteristiche t3 on t1.userid=t3.userid SET t1.conto=t1.conto-'1',t1.lotteria='1',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'1'");
}
}//fine compra biglietto lotteria
$partecipanti=$db->QuerySelect("SELECT COUNT(userid) AS num FROM banca WHERE lotteria>0");
$infopartecipanti=sprintf($lang['info_partecipanti'],$partecipanti['num']);
$vincitore=$db->QuerySelect("SELECT COUNT(userid) AS num FROM banca WHERE vincitore>0 LIMIT 1");
if($vincitore['num']>0){
$vincitore=$db->QuerySelect("SELECT userid AS num FROM banca WHERE vincitore>0 LIMIT 1");
$vincitore=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$vincitore['userid']."' LIMIT 1");
$nomevincitore=$vincitore['username'];}else
{$nomevincitore=$lang['nessuno'];}
$infovincitore=sprintf($lang['info_vincitore'],$nomevincitore);
$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 1");
$prestito=$userbank['prestito']+(floor(($userbank['prestito']/100)*10));
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
require('template/int_banca.php');
?>