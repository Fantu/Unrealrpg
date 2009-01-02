<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$sottomenu=htmlspecialchars($_GET['menu'],ENT_QUOTES);
$titolo=$lang[$sottomenu];
$link=$menu->Sm($sottomenu);
require('template/int_submenu.php');
?>