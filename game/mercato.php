<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_mercato.php');
require('language/it/lang_oggetti_categorie.php');
require('inclusi/funzioni_oggetti.php');
/*$step=(int)$_GET['step'];
switch($_GET['step']){
default:
break;
}*/
foreach($catoggetti_nome as $chiave=>$elemento){
echo $lang['tipo'.$chiave]."<br />";
}
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_mercato.php');
}
?>