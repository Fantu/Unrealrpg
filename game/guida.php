<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('inclusi/personaggio.php');
require_once('language/'.$language.'/lang_guida.php');
require('template/int_guida.php');
?>