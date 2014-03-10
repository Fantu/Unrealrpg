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
<a href="index.php?loc=combact"><?php if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "<strong>";} echo $lang['combact']; if(($evento['tipo']==4 AND $evento['type']==2) OR $evento['tipo']==5){echo "</strong>";} ?></a>
<?php $menu->View('m','oggetti'); ?>
<a href="index.php?loc=messaggi"><?php if($snm['id']>0){echo "<strong>";} echo $lang['messaggi']; if($snm['id']>0){echo "</strong>";} ?></a>
<?php
$menu->View('v','utenti');
$menu->View('m','info');
$menu->View('v','opzioni'); ?>
<ul><li><a href="#"><?php echo $lang['Link']; ?></a><ul>
<li><a href="https://github.com/Fantu/Unrealrpg/issues" target="_blank"><?php echo $lang['Bugtracker']; ?></a></li>
<?php if(isset($game_forum)){
    echo "<li><a href=\"".$game_forum."\" target=\"_blank\">Forum</a></li>";
} ?>
</ul></li></ul>
<?php $menu->View('v','logout'); ?>
</div>
