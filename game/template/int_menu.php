<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div id="menu">
<?php
$menu->View('v','situazione');
$menu->View('m','citta');
$menu->View('m','lavori');
$menu->View('m','magia');
$menu->View('m','regno'); ?>
<a href="index.php?loc=combact"><?php if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "<strong>";} echo $lang['Combattimenti']; if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "</strong>";} ?></a>
<?php $menu->View('m','oggetti'); ?>
<a href="index.php?loc=messaggi"><?php if($snm['id']>0){echo "<strong>";} echo $lang['Messaggi']; if($snm['id']>0){echo "</strong>";} ?></a>
<?php
$menu->View('v','utenti');
$menu->View('m','info');
$menu->View('v','opzioni'); ?>
<a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a>
<?php $menu->View('v','logout'); ?>
</div>