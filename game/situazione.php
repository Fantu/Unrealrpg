<?php
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
require('inclusi/personaggio.php');
require('template/int_situazione.php');
?>