<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
setcookie ("lglogin", "", time() - 10800);
$db->QueryMod("UPDATE utenti SET ultimazione=ultimazione-'600' WHERE userid='".$user['userid']."'");
echo "<script language=\"javascript\">window.location.href='../index.php'</script>";
exit();
?>