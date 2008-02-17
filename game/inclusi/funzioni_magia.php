<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_magia.php');

$elementi=array(1=>$lang['Acqua'],2=>$lang['Aria'],3=>$lang['Terra'],4=>$lang['Fuoco']);
?>