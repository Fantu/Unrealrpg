<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$menu=htmlspecialchars($_GET['menu'],ENT_QUOTES);
switch($menu){
case "lavori":
$titolo=$lang['Lavori'];
$link[]='<a href="index.php?loc=miniera">'.$lang['Miniera'].'</a>';
$link[]='<a href="index.php?loc=laboratorio">'.$lang['Laboratorio'].'</a>';
$link[]='<a href="index.php?loc=fucina">'.$lang['Fucina'].'</a>';
break;
case "magia":
$titolo=$lang['Magia'];
$link[]='<a href="index.php?loc=rocca">'.$lang['Rocca_arcano'].'</a>';
$link[]='<a href="index.php?loc=libro">'.$lang['Libro_incantesimi'].'</a>';
break;
case "oggetti":
$titolo=$lang['Oggetti'];
$link[]='<a href="index.php?loc=inventario">'.$lang['Inventario'].'</a>';
$link[]='<a href="index.php?loc=equipaggiamento">'.$lang['Equipaggiamento'].'</a>';
break;
case "info":
$titolo=$lang['Informazioni'];
$link[]='<a href="index.php?loc=guida">'.$lang['Guida'].'</a>';
$link[]='<a href="index.php?loc=changelog">'.$lang['Changelog'].'</a>';
break;
}
require('template/int_submenu.php');
?>