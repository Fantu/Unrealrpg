<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
if ($user['resuscita']=='0'){
$tempor=86400-$usercar['fede'];
}else{
$tempor=10800;
$db->QueryMod("UPDATE utenti SET resuscita='0' WHERE userid='".$user['userid']."' LIMIT 1");
}
if($user['plus']!=0){$tempor-=3600;}
if ($tempor<3600)
$tempor=3600;
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo) VALUES ('".$user['userid']."','".$adesso."','".$tempor."','4','3')");
header("Location: index.php?loc=situazione");
exit();
?>