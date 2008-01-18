<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_opzioni.php');
if (isset($_POST['cambias'])){
$errore="";
$sesso=(int)$_POST['sesso'];
if (!is_numeric($sesso))
$errore .= $lang['opzioni_error1']."<br />";

if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE caratteristiche SET sesso='".$sesso."' WHERE userid='".$user['userid']."'");
$outputerrori="<span>".$lang['sesso_modificato']."</span><br /><br />";
}
}//fine cambia sesso
require('inclusi/personaggio.php');
require('template/int_opzioni.php');
?>