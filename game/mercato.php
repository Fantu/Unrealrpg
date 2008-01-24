<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}

if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_mercato.php');
}
?>