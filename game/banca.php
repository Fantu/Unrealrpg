<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_banca.php');
$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 0,1");
if (($userbank['interessi']+86400)<$adesso){
	$differenzaora=$adesso-$userbank['interessi'];
	$giorni=floor($differenzaora/86400);
	$interessi=floor((($userbank['conto']/100)*0.5)*$giorni);
	if ($interessi>0){
		$db->QueryMod("UPDATE banca SET conto=conto+'".$interessi."',interessi=interessi+'".(86400*$giorni)."' WHERE userid='".$user['userid']."'");
	}
	else{$db->QueryMod("UPDATE banca SET interessi='".$adesso."' WHERE userid='".$user['userid']."'");}
}
if (isset($_POST['deposita'])){
$errore="";
$dadepositare=(int)$_POST['dadepositare'];
if (!is_numeric($dadepositare)){
$errore .= $lang['banca_errore1'];}
else{
if ($dadepositare<1)
$errore .= $lang['banca_errore2'];
if ($dadepositare>$user['monete'])
$errore .= $lang['banca_errore3'];
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
//$db->QueryMod("UPDATE banca,utenti,caratteristiche SET banca.conto=banca.conto+'".$dadepositare."',utenti.monete=utenti.monete-'".$dadepositare."',caratteristiche.energia=caratteristiche.energia-'1' WHERE banca.userid='".$user['userid']."' AND utenti.userid='".$user['userid']."' AND caratteristiche.userid='".$user['userid']."'");
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
if ($daprelevare<1)
$errore .= $lang['banca_errore4'];
$userbank=$db->QuerySelect("SELECT conto FROM banca WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($daprelevare>$userbank['conto'])
$errore .= $lang['banca_errore5'];
$deposito = $db->QuerySelect("SELECT banca FROM config");
if ($daprelevare>$deposito['banca'])
$errore .= $lang['banca_errore6'];
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
//$db->QueryMod("UPDATE banca,utenti,caratteristiche SET banca.conto=banca.conto-'".$daprelevare."',utenti.monete=utenti.monete+'".$daprelevare."',caratteristiche.energia=caratteristiche.energia-'1' WHERE banca.userid='".$user['userid']."' AND utenti.userid='".$user['userid']."' AND caratteristiche.userid='".$user['userid']."'");
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
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$prestitopossibile=($usercar['livello']*100)-$userbank['prestito'];
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

$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 0,1");
$prestito=$userbank['prestito']+(floor(($userbank['prestito']/100)*10));
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 0,1");
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_banca.php');
}
?>