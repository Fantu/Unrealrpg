<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_mostraoggetto.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');
require_once('language/'.$language.'/lang_oggetti_categorie.php');
$da=htmlspecialchars($_GET['da'],ENT_QUOTES);
if($da=='inventario'){
$indietro="<a href=\"index.php?loc=inventario\">".$lang['Inventario']."</a>";
}else{
$cat=(int)$_GET['cat'];
$scat=(int)$_GET['scat'];
if($scat==0){
$indietro="<a href=\"index.php?loc=mercato&amp;step=1&amp;categoria=".$cat."\">".$lang['tipo'.$cat]."</a>";
}else{
$indietro="<a href=\"index.php?loc=mercato&amp;step=2&amp;categoria=".$cat."&amp;sottocategoria=".$scat."\">".$lang['categoria'.$cat.'-'.$scat]."</a>";
}
}
$oggid=(int)$_GET['ogg'];
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$oggetti['nome']=$lang['oggetto'.$oggetto['id'].'_nome'];
$oggetti['costo']=$oggetto['costo'];
$oggetti['usura']=$oggetto['usura'];
$oggetti['energia']=$oggetto['energia'];
$oggetti['forzafisica']=$oggetto['forzafisica'];
$oggetti['bonuseff']=$oggetto['bonuseff'];
$oggetti['probtrovare']=$oggetto['probtrovare'];
$oggetti['probrottura']=$oggetto['probrottura'];
$oggetti['recsalute']=$oggetto['recsalute'];
$oggetti['recenergia']=$oggetto['recenergia'];
$oggetti['danno']=$oggetto['danno'];

require('template/int_mostraoggetto.php');
?>