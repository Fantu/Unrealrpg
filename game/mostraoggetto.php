<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_oggetti_nomi.php');
$da=htmlentities($_GET['da']);
if($da=='inventario'){
$indietro="<a href=\"game.php?act=inventario\">".$lang['Inventario']."</a>";
}else{
$indietro="<a href=\"game.php?act=mercato\">".$lang['Mercato']."</a>";	
}
$oggid=(int)$_GET['ogg'];
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$oggetti['nome']=$lang['oggetto'.$oggetto['id'].'_nome'];

require('template/int_mostraoggetto.php');
?>