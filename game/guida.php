<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('inclusi/personaggio.php');
require('language/it/lang_guida.php');
require('template/int_guida.php');
?>