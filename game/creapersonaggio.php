<?php
if (isset($_POST['crea'])){
$errore="";
$razza=$_POST['razza'];
if ($razza=="none")
$errore .= "- Non hai selezionato la razza";

if($errore){
	$outputerrori="<span>Si sono verificati i seguenti errori:</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE utenti SET personaggio='1' WHERE userid='".$user['userid']."'");
$db->QueryMod("INSERT INTO caratteristiche (userid,password,codice,email,dataiscrizione,ipreg,server) VALUES ('".$user['userid']."','".$_POST['razza']."')");
header("Location: game.php?act=situazione");
exit();
}

}
require('inclusi/personaggio.php');
require('template/int_creapersonaggio.php');
?>