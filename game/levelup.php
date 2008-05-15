<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_situazione.php');

$expnewlevel=$usercar['livello']*200;
if($usercar['exp']<$expnewlevel){
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}

require('template/int_levelup.php');
?>