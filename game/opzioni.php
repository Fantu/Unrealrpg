<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_opzioni.php');
if (isset($_POST['cambias'])){
$errore="";
$sesso=$_POST['sesso'];
if (!is_numeric($sesso))
$errore .= $lang['opzioni_error1']."<br />";

if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE caratteristiche SET sesso='".$sesso."' WHERE userid='".$user['userid']."'");
$outputerrori="<span>".$lang['sesso_modificato']."</span><br /><br />";
}
}//fine cambia sesso

switch($_GET['attivaplus']){
case "1":
$punti=3;
$tattivazioneplus=604800;
break;
case "2":
$punti=10;
$tattivazioneplus=2592000;
break;
case "3":
$punti=100;
$tattivazioneplus=31536000;
break;
}

if(!empty($tattivazioneplus)){
if ($user['puntiplus']<$punti)
$errore .= $lang['opzioni_error2']."<br />";
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
if($user['plus']==0){
$db->QueryMod("UPDATE utenti SET plus='".$adesso."' WHERE userid='".$user['userid']."'");
}else{
$db->QueryMod("UPDATE utenti SET plus=plus+'".$tattivazioneplus."' WHERE userid='".$user['userid']."'");	
}
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}
}//fine attivazione plus con punti plus

require('inclusi/personaggio.php');
require('template/int_opzioni.php');
?>