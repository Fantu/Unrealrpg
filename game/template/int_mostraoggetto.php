<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $oggetti['nome']; ?></h2></center><br />
<?php echo $lang['Costo']; ?>: <?php echo $oggetti['costo']; ?><br />
<?php echo $lang['Usura']; ?>: <?php echo $oggetti['usura']; ?><br />
<?php echo $lang['energianec']; ?>: <?php echo $oggetti['energia']; ?><br />
<?php echo $lang['forzafisicanec']; ?>: <?php echo $oggetti['forzafisica']; ?><br />
<?php echo $lang['bonuseff']; ?>: <?php echo $oggetti['bonuseff']; ?>&#37;<br />
<?php echo $lang['probtrovare']; ?>: <?php echo $oggetti['probtrovare']; ?><br />
<?php echo $lang['probrottura']; ?>: <?php echo $oggetti['probrottura']; ?><br />
<?php echo $lang['recsalute']; ?>: <?php echo $oggetti['recsalute']; ?><br />
<?php echo $lang['recenergia']; ?>: <?php echo $oggetti['recenergia']; ?><br />
<br />
<br />
<?php echo $indietro; ?>