<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_mostraoggetto.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');
require_once('language/'.$language.'/lang_oggetti_categorie.php');
$da=htmlspecialchars($_GET['da'],ENT_QUOTES);
switch($da){
case 'inventario':
$indietro="<a href=\"index.php?loc=inventario\">".$lang['Inventario']."</a>";
break;
case 'mercato':
$cat=(int)$_GET['cat'];
$scat=(int)$_GET['scat'];
if($scat==0){
$indietro="<a href=\"index.php?loc=mercato&amp;step=1&amp;categoria=".$cat."\">".$lang['tipo'.$cat]."</a>";
}else{
$indietro="<a href=\"index.php?loc=mercato&amp;step=2&amp;categoria=".$cat."&amp;sottocategoria=".$scat."\">".$lang['categoria'.$cat.'-'.$scat]."</a>";
}
break;
case 'equip':
$indietro="<a href=\"index.php?loc=equipaggiamento\">".$lang['Equipaggiamento']."</a>";
break;
}
$oggid=(int)$_GET['ogg'];
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$nomeoggetto=$lang['oggetto'.$oggetto['id'].'_nome'];

require('template/int_mostraoggetto.php');
?>