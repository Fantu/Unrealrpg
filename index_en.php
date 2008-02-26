<?php
$start_time = microtime();
require('game/inclusi/valori.php');
$int_security=$game_se_code;
$language="en";
setcookie ("urbglanguage", $language,time()+8640000);
require('pagine/index.php');
?>