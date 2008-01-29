<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/it/lang_mostraoggetto.php');
require_once('language/it/lang_oggetti_nomi.php');
require_once('language/it/lang_oggetti_categorie.php');
$da=htmlentities($_GET['da']);
if($da=='inventario'){
$indietro="<a href=\"game.php?act=inventario\">".$lang['Inventario']."</a>";
}else{
$cat=(int)$_GET['cat'];
$scat=(int)$_GET['scat'];
if($scat==0){
$indietro="<a href=\"game.php?act=mercato&amp;step=1&amp;categoria=".$cat."\">".$lang['tipo'.$cat]."</a>";
}else{
$indietro="<a href=\"game.php?act=mercato&amp;step=2&amp;categoria=".$cat."&amp;sottocategoria=".$scat."\">".$lang['categoria'.$cat.'-'.$scat]."</a>";
}
}
$oggid=(int)$_GET['ogg'];
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$oggetti['nome']=$lang['oggetto'.$oggetto['id'].'_nome'];
$oggetti['costo']=$oggetto['costo'];

require('template/int_mostraoggetto.php');
?>