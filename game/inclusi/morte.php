<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if ($user['resuscita']=='0'){
$tempor=86400-$usercar['fede'];
if ($tempor<3600)
$tempor=3600;
}else{
$tempor=36000;	
}
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo) VALUES ('".$user['userid']."','".$adesso."','".$tempor."','4','3')");
header("Location: game.php?act=situazione");
exit();
?>