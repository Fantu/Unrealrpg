<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div id="menu">
<a href="index.php?loc=situazione"><?php echo $lang['Situazione']; ?></a>
<a href="index.php?loc=banca"><?php echo $lang['Banca']; ?></a>
<li><a href="#"><?php echo "Lavori"; ?></a><ul>
<li><a href="index.php?loc=miniera"><?php echo $lang['Miniera']; ?></a></li>
<li><a href="index.php?loc=laboratorio"><?php echo $lang['Laboratorio']; ?></a></li>
<li><a href="index.php?loc=fucina"><?php echo $lang['Fucina']; ?></a></li>
</ul></li>
<a href="index.php?loc=tempio"><?php echo $lang['Tempio']; ?></a>
<a href="index.php?loc=rocca"><?php echo $lang['Rocca_arcano']; ?></a>
<a href="index.php?loc=libro"><?php echo $lang['Libro_incantesimi']; ?></a>
<a href="index.php?loc=combact"><?php echo $lang['Combattimenti']; ?></a>
<a href="index.php?loc=mercato"><?php echo $lang['Mercato']; ?></a>
<a href="index.php?loc=inventario"><?php echo $lang['Inventario']; ?></a>
<a href="index.php?loc=equipaggiamento"><?php echo $lang['Equipaggiamento']; ?></a>
<a href="index.php?loc=messaggi"><?php echo $lang['Messaggi']; ?></a>
<a href="index.php?loc=utenti"><?php echo $lang['Lista_utenti']; ?></a>
<a href="index.php?loc=guida"><?php echo $lang['Guida']; ?></a>
<a href="index.php?loc=changelog"><?php echo $lang['Changelog']; ?></a>
<a href="index.php?loc=opzioni"><?php echo $lang['Opzioni']; ?></a>
<a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a>
<a href="index.php?loc=logout"><?php echo $lang['Logout']; ?></a>
</div>