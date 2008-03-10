<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
?>
<div align="right">
  <table width="500" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>Changelog:</td>
  </tr>
  <tr>
    <td>Per leggere i changelog completi pi&ugrave; aggiornati dell'intero progetto clicca <a href="index.php?loc=changelog&amp;completa=1">qui</a></td>
  </tr>  
  <tr>
    <td><?php if($_GET['completa']==1){include('/var/www/web5/web/rpgdev/game/language/'.$language.'/versioni.txt');}else{include('language/'.$language.'/versioni.txt');} ?></td>
  </tr>
</table>
</div>