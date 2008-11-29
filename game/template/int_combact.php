<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Combattimenti']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<div align="center" style="text-align:center">
<?php if($outputsfida){ echo $outputsfida; ?>
<br />
<br />
<br />
<?php }/*se c'è outputsfida*/ if($combactview==1 OR $combactview==2){ echo $titleoutputcombact; ?><br />
<br />
<?php echo $outputcombact; ?>
<br />
<?php } if($combactview==2){
echo "<a name=\"fondo\">".$lang['seleziona_tattica']."</a>"; ?>
<div id="tattic">
<table border="0" align="center">
<tr><td>
<ul>
<li><a href="#"><?php echo $lang['tattica_attacco']; ?></a>
<ul>
<li><a href="index.php?loc=combact&amp;tattica=1&amp;subtatt=1#fondo"><?php echo $lang['tattica_attacco_cac']; ?></a></li>
<li><a href="index.php?loc=combact&amp;tattica=1&amp;subtatt=2#fondo"><?php echo $lang['tattica_attacco_adi']; ?></a></li>
</ul></li>
<li><a href="index.php?loc=combact&amp;tattica=3#fondo"><?php echo $lang['tattica_difesa']; ?></a></li>
<?php if($userequip['poz']!=0){ ?><li><a href="index.php?loc=combact&amp;tattica=4#fondo"><?php echo $lang['tattica_pozione']; ?></a></li><?php }/*se pozione in equip*/ ?>
<?php if($batt['difcpu']==0){ ?><li><a href="index.php?loc=combact&amp;tattica=2#fondo"><?php echo $lang['tattica_resa']; ?></a></li><?php }/*se non contro cpu*/ ?>
</ul>
</td></tr>
</table>
</div>
<?php echo $viewtattic; } ?>
</div>
<br />
<br />
<br />
<center><a href="index.php?loc=archiviorep"><?php echo $lang['archivio_report']; ?></a></center>