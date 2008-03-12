<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
//require_once('language/'.$language.'/lang_combact.php');

require('template/int_combact.php');
?>