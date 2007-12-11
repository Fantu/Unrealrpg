<?php
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$lg[0]."' AND password='".$lg[2]."' AND conferma=1 LIMIT 0,1");

if($user['userid']) {
$adesso=strtotime("now");
require_once('template/int_header.php');
} //fine if userid
else {
	header("Location: ../index.php?error=4");
	exit();
}
?>
