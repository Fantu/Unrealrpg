<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $nomeoggetto; ?></h2></center><br />
<?php echo $lang['Costo']; ?>: <?php echo $oggetto['costo']; ?><br />
<?php echo $lang['Usura']; ?>: <?php echo $oggetto['usura']; ?><br />
<?php echo $lang['energianec']; ?>: <?php echo $oggetto['energia']; ?><br />
<?php echo $lang['forzafisicanec']; ?>: <?php echo $oggetto['forzafisica']; ?><br />
<?php echo $lang['destrezzanec']; ?>: <?php echo $oggetto['destrezza']; ?><br />
<?php echo $lang['bonuseff']; ?>: <?php echo $oggetto['bonuseff']; ?>&#37;<br />
<?php echo $lang['probtrovare']; ?>: <?php echo $oggetto['probtrovare']; ?><br />
<?php echo $lang['probrottura']; ?>: <?php echo $oggetto['probrottura']; ?><br />
<?php echo $lang['recsalute']; ?>: <?php echo $oggetto['recsalute']; ?><br />
<?php echo $lang['recenergia']; ?>: <?php echo $oggetto['recenergia']; ?><br />
<?php echo $lang['danno']; ?>: <?php echo $oggetto['danno']; ?><br />
<?php echo $lang['difesafisica']; ?>: <?php echo $oggetto['difesafisica']; ?><br />
<br />
<br />
<?php echo $indietro; ?>