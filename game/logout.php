<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
setcookie ("userlogin", "", time() - 10800);
$db->QueryMod("UPDATE utenti SET ultimazione=ultimazione-'600' WHERE userid='".$user['userid']."'");
$db->QueryMod("DELETE FROM sessione WHERE id='".md5($user['userid'])."' LIMIT 1");
echo "<script language=\"javascript\">window.location.href='../index.php'</script>";
exit();
?>