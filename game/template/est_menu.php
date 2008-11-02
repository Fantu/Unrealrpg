<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div id="estmenu">
<a href="index_<?php echo $language; ?>.php?pag=home"><?php echo "Home"; ?></a>
<a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a>
</div>