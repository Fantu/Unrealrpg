<?php
if (isset($_POST['deposita'])){
$errore="";
$dadepositare=$_POST['dadepositare'];
if (is_int($dadepositare))
$errore .= $lang['banca_errore1'];
if ($dadepositare<10)
$errore .= $lang['banca_errore2'];
if ($dadepositare>$user['monete'])
$errore .= $lang['banca_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca SET conto=conto+'".$dadepositare."' WHERE userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca+'".$dadepositare."'");
}
}//fine deposita
if (isset($_POST['preleva'])){
$errore="";
$daprelevare=$_POST['daprelevare'];
if (is_int($daprelevare))
$errore .= $lang['banca_errore1'];
if ($daprelevare<10)
$errore .= $lang['banca_errore4'];
if ($daprelevare>$userbank['conto'])
$errore .= $lang['banca_errore5'];
$deposito = $db->QuerySelect("SELECT banca FROM config");
if ($daprelevare>$deposito['banca'])
$errore .= $lang['banca_errore6'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE banca SET conto=conto-'".$daprelevare."' WHERE userid='".$user['userid']."'");
$db->QueryMod("UPDATE config SET banca=banca-'".$daprelevare."'");
}
}//fine preleva
$userbank=$db->QuerySelect("SELECT * FROM banca WHERE userid='".$user['userid']."' LIMIT 0,1");
require('template/int_banca.php');
?>