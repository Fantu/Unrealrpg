<?php
setcookie ("lglogin", "", time() - 10800);
$db->QueryMod("UPDATE utenti SET ultimazione=ultimazione-'600' WHERE userid='".$user['userid']."'");
echo "<script language=\"javascript\">window.location.href='../index.php'</script>";
exit();
?>