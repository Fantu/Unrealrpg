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
<div align="center"><?php if($combactview==1) echo $titleoutputcombact; ?></div><br />
<?php echo $outputcombact; ?>
<br />