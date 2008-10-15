<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $nomeoggetto; ?></h2></center><br />
<?php echo $lang['Costo'].": ".$oggetto['costo']; ?><br />
<?php echo $lang['Usura'].": ".$oggetto['usura']; ?><br />
<?php echo $lang['energianec'].": ".$oggetto['energia']; ?><br />
<?php if($oggetto['forzafisica']>0){ echo $lang['forzafisicanec'].": ".$oggetto['forzafisica']; } ?><br />
<?php if($oggetto['destrezza']>0){ echo $lang['destrezzanec'].": ".$oggetto['destrezza']; } ?><br />
<?php echo $lang['bonuseff'].": ".$oggetto['bonuseff']; ?>&#37;<br />
<?php echo $lang['probtrovare'].": ".$oggetto['probtrovare']; ?><br />
<?php echo $lang['probrottura'].": ".$oggetto['probrottura']; ?><br />
<?php echo $lang['recsalute'].": ".$oggetto['recsalute']; ?><br />
<?php echo $lang['recenergia'].": ".$oggetto['recenergia']; ?><br />
<?php echo $lang['danno'].": ".$oggetto['danno']; ?><br />
<?php echo $lang['difesafisica'].": ".$oggetto['difesafisica']; ?><br />
<br />
<br />
<?php echo $indietro; ?>