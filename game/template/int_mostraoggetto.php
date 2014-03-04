<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $nomeoggetto; ?></h2></center><br />
<?php echo $lang['Costo'].": ".$oggetto['costo']; ?><br />
<?php echo $lang['Usura'].": ".$oggetto['usura']; ?><br />
<?php if($oggetto['energia']>0){ echo $lang['energianec'].": ".$oggetto['energia']."<br />"; } ?>
<?php if($oggetto['forzafisica']>0){ echo $lang['forzafisicanec'].": ".$oggetto['forzafisica']."<br />"; } ?>
<?php if($oggetto['destrezza']>0){ echo $lang['destrezzanec'].": ".$oggetto['destrezza']."<br />"; } ?>
<?php if($oggetto['bonuseff']>0){ echo $lang['bonuseff'].": ".$oggetto['bonuseff']."&#37;<br />"; } ?>
<?php if($oggetto['probtrovare']>0){ echo $lang['probtrovare'].": ".$oggetto['probtrovare']."<br />"; } ?>
<?php if($oggetto['probrottura']>0){ echo $lang['probrottura'].": ".number_format($percbreakdown,2,'.','')."%<br />"; } ?>
<?php if($oggetto['recsalute']>0){ echo $lang['recsalute'].": ".$oggetto['recsalute']."<br />"; } ?>
<?php if($oggetto['recenergia']>0){ echo $lang['recenergia'].": ".$oggetto['recenergia']."<br />"; } ?>
<?php if($oggetto['danno']>0){ echo $lang['danno'].": ".$oggetto['danno']."<br />"; } ?>
<?php if($oggetto['difesafisica']>0){ echo $lang['difesafisica'].": ".$oggetto['difesafisica']."<br />"; } ?>
<br />
<br />
<?php echo $indietro; ?>
