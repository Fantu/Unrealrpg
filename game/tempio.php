<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_tempio.php');
if (isset($_POST['prega'])){
$errore="";
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['tempio_errore1'];
if ($user['monete']<1)
$errore .= $lang['tempio_errore2'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo) VALUES ('".$user['userid']."','".$adesso."','3600','3','2')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();
}
}//fine prega
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_tempio.php');
}
?>