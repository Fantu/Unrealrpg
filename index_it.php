<?php
$start_time=time()+microtime();
require('game/inclusi/valori.php');
$int_security=$game_se_code;
$language="it";
setcookie ("urbglanguage", $language,time()+8640000);
require('pagine/index.php');
?>