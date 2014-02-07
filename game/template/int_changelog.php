<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div>
<?php echo sprintf($lang['leggi_changelog_interi'],"<a href=\"index.php?loc=changelog&amp;completa=1\">","</a>"); ?><br/>
<br/>
<?php if($_GET['completa']==1){include(MAIN_PATH.'/game/language/'.$language.'/versioni.txt');}else{include('language/'.$language.'/versioni.txt');} ?>
</div>
