<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$menu=htmlspecialchars($_GET['menu'],ENT_QUOTES);
switch($menu){
case "citta":
$titolo=$lang['Citta'];
$link[]='<a href="index.php?loc=banca">'.$lang['Banca'].'</a>';
$link[]='<a href="index.php?loc=tempio">'.$lang['Tempio'].'</a>';
$link[]='<a href="index.php?loc=mercato">'.$lang['Mercato'].'</a>';
$link[]='<a href="index.php?loc=locanda">'.$lang['Locanda'].'</a>';
break;
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
case "confini":
$titolo=$game_server[$user['server']];
$link[]='<a href="index.php?loc=confini">'.$lang['Confini'].'</a>';
break;
}
require('template/int_submenu.php');
?>