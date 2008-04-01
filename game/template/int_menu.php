<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div id="menu">
<table width="142"  border="1" cellspacing="1" cellpadding="1" class="tabmenu">		  
	<tr>
    <td><div align="center"><a href="index.php?loc=situazione"><?php echo $lang['Situazione']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=banca"><?php echo $lang['Banca']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=miniera"><?php echo $lang['Miniera']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=laboratorio"><?php echo $lang['Laboratorio']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=tempio"><?php echo $lang['Tempio']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=fucina"><?php echo $lang['Fucina']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=rocca"><?php echo $lang['Rocca_arcano']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=libro"><?php echo $lang['Libro_incantesimi']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=combact"><?php echo $lang['Combattimenti']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=mercato"><?php echo $lang['Mercato']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=inventario"><?php echo $lang['Inventario']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=equipaggiamento"><?php echo $lang['Equipaggiamento']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=messaggi"><?php echo $lang['Messaggi']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=utenti"><?php echo $lang['Lista_utenti']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=guida"><?php echo $lang['Guida']; ?></a></div></td>
	</tr>				
	<tr>
    <td><div align="center"><a href="index.php?loc=changelog"><?php echo $lang['Changelog']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=opzioni"><?php echo $lang['Opzioni']; ?></a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a></div></td>
	</tr>
	<tr>
    <td><div align="center"><a href="index.php?loc=logout"><?php echo $lang['Logout']; ?></a></div></td>
	</tr>		
</table>
</div>