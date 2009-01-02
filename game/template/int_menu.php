<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div id="menu">
<?php 
$menu->View('v','situazione');
$menu->View('m','citta');
$menu->View('m','lavori');
$menu->View('m','magia');
$menu->View('m','regno'); ?>
<a href="index.php?loc=combact"><?php if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "<strong>";} echo $lang['Combattimenti']; if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "</strong>";} ?></a>
<ul>
<li><a href="index.php?loc=submenu&amp;menu=oggetti"><?php echo $lang['Oggetti']; ?></a><ul>
<li><a href="index.php?loc=inventario"><?php echo $lang['Inventario']; ?></a></li>
<li><a href="index.php?loc=equipaggiamento"><?php echo $lang['Equipaggiamento']; ?></a></li>
</ul></li>
</ul>
<a href="index.php?loc=messaggi"><?php if($snm['id']>0){echo "<strong>";} echo $lang['Messaggi']; if($snm['id']>0){echo "</strong>";} ?></a>
<a href="index.php?loc=utenti"><?php echo $lang['Lista_utenti']; ?></a>
<ul>
<li><a href="index.php?loc=submenu&amp;menu=info"><?php echo $lang['Informazioni']; ?></a><ul>
<li><a href="index.php?loc=guida"><?php echo $lang['Guida']; ?></a></li>
<li><a href="index.php?loc=changelog"><?php echo $lang['Changelog']; ?></a></li>
</ul></li>
</ul>
<a href="index.php?loc=opzioni"><?php echo $lang['Opzioni']; ?></a>
<a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a>
<a href="index.php?loc=logout"><?php echo $lang['Logout']; ?></a>
</div>