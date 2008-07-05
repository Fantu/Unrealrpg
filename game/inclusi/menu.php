<?php
$snm=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");

require('template/int_menu.php');
?>