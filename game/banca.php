<?php
if (isset($_POST['deposita'])){
$errore="";
$dadepositare=$_POST['dadepositare'];
if (!is_numeric($dadepositare)){
$errore .= $lang['banca_errore1'];}
else{
if ($dadepositare<10)
$errore .= $lang['banca_errore2'];
if ($dadepositare>$user['monete'])
$errore .= $lang['banca_errore3'];
}
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
//$db->QueryMod("UPDATE banca,utenti,caratteristiche SET banca.conto=banca.conto+'".$dadepositare."',utenti.monete=utenti.monete-'".$dadepositare."',caratteristiche.energia=caratteristiche.energia-'1' WHERE banca.userid='".$user['userid']."' AND utenti.userid='".$user['userid']."' AND caratteristiche.userid='".$user['userid']."'");
$db->QueryMod("UPDATE banca t1 JOIN utenti t2 on t1.userid=t2.userid JOIN caratteristiche t3 on t2.userid=t3.userid SET t1.conto=t1.conto+'".$dadepositare."',t2.monete=t2.monete-'".$dadepositare."',t3.energia=t3.energia-'1' WHERE t1.userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$dadepositare."'");
}
}//fine deposita
if (isset($_POST['preleva'])){
$errore="";
$daprelevare=$_POST['daprelevare'];
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
$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 0,1");
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 0,1");
require('template/int_banca.php');
?>