<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Combattimenti']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $outputsfida; ?>
<br />
<br />
<br />
<div align="center"><?php if($combactview==1 OR $combactview==2) echo $titleoutputcombact; ?></div><br />
<br />
<?php echo $outputcombact; ?>
<br />
<?php if($combactview==2){ ?>
<div align="center" id="tattic">
<?php echo "<a href=\"#fondo\">".$lang['seleziona_tattica']."</a>"; ?>
<table border="0" align="center">
<tr><td>
<ul>
<li><a href="#"><?php echo $lang['tattica_attacco']; ?></a>
<ul>
<li><a href="index.php?loc=combact&amp;tattica=1&amp;subtatt=1"><?php echo $lang['tattica_attacco_cac']; ?></a></li>
</ul></li>
<li><a href="index.php?loc=combact&amp;tattica=3"><?php echo $lang['tattica_difesa']; ?></a></li>
<li><a href="index.php?loc=combact&amp;tattica=2"><?php echo $lang['tattica_resa']; ?></a></li>
</ul>
</td></tr>
</table>
<?php echo $viewtattic; } ?>
</div>
<br />
<br />
<br />
<center><a href="index.php?loc=archiviorep"><?php echo $lang['archivio_report']; ?></a></center>