<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php
if (!empty($config['news']))
echo "<span><strong>".$lang['news']."</strong>".$config['news']."</span><br /><br />";
if (!empty($config['comunicazione']))
echo "<span><strong>".$lang['comunicazione']."</strong>".$config['comunicazione']."</span><br /><br />";
?>
<div align="center">
<?php echo $newmsg; ?><br />
<br />
<?php echo $event; ?><br />
</div>
<br />
<?php echo $lang['Nome']; ?>: <?php echo $user['username']; ?><br />
<?php echo $lang['Razza']; ?>: <?php echo $razze['nome'][$usercar['razza']]; ?><br />
<?php echo $lang['Classe']; ?>: <?php echo $classi['nome'][$usercar['classe']]; ?><br />
<?php echo $lang['Sesso']; ?>: <?php echo $sessi['nome'][$usercar['sesso']]; ?><br />
<?php echo $lang['Livello']; ?>: <?php
if($usercar['exp']>=$expnewlevel)
echo "<a href=\"index.php?loc=levelup\">".$usercar['livello']."</a>";
else
echo $usercar['livello'];
?><br />
<?php echo $lang['Esperienza']; ?>: <?php echo $usercar['exp']; echo "/"; echo $expnewlevel; ?><br />
<?php echo $lang['Salute']; ?>: <?php if($usercar['saluteattuale']<1){echo $lang['morto'];}else{echo $usercar['saluteattuale']; echo "/"; echo $usercar['salute'];} ?><br />
<?php echo $lang['Energia']; ?>: <?php echo $usercar['energia']; echo "/"; echo $usercar['energiamax']; ?><br />
<?php echo $lang['Mana']; ?>: <?php echo $usercar['manarimasto']; echo "/"; echo $usercar['mana']; ?><br />
<?php echo $lang['Reputazione']; ?>: <?php echo $usercar['reputazione'];?><br />
<?php echo $lang['Monete']; ?>: <?php echo $user['monete']; ?><br />
<br />
<?php echo $lang['Attfisico']; ?>: <?php echo $usercar['attfisico']; ?><br />
<?php echo $lang['Attmagico']; ?>: <?php echo $usercar['attmagico']; ?><br />
<?php echo $lang['Diffisica']; ?>: <?php echo $usercar['diffisica']; ?><br />
<?php echo $lang['Difmagica']; ?>: <?php echo $usercar['difmagica']; ?><br />
<?php echo $lang['Velocita']; ?>: <?php echo $usercar['velocita']; ?><br />
<?php echo $lang['Agilita']; ?>: <?php echo $usercar['agilita']; ?><br />
<?php echo $lang['Intelligenza']; ?>: <?php echo $usercar['intelligenza']; ?><br />
<?php echo $lang['Destrezza']; ?>: <?php echo $usercar['destrezza']; ?><br />
<br />
<table border="0">
<tr><td colspan="2"><?php echo $lang['elenco_ab']; ?></td></tr>
<tr><td><?php echo $lang['ab_minatore']; ?>: <?php echo $usercar['minatore']; ?></td>
<td><table align="center" border="0" cellspacing="0"><tr><td width="<?php echo $percmin1; ?>" class="sfondoverde"></td><td width="<?php echo $percmin2; ?>" class="sfondorosso"></td></tr>
</table></tr>
<tr><td><?php echo $lang['ab_alchimista']; ?>: <?php echo $usercar['alchimista']; ?></td>
<td><table align="center" border="0" cellspacing="0"><tr><td width="<?php echo $percmin3; ?>" class="sfondoverde"></td><td width="<?php echo $percmin4; ?>" class="sfondorosso"></td></tr>
</table></tr>
<tr><td><?php echo $lang['ab_fabbro']; ?>: <?php echo $usercar['fabbro']; ?></td>
<td><table align="center" border="0" cellspacing="0"><tr><td width="<?php echo $percmin5; ?>" class="sfondoverde"></td><td width="<?php echo $percmin6; ?>" class="sfondorosso"></td></tr>
</table></tr>
<tr><td><?php echo $lang['ab_magica']; ?>: <?php echo $usercar['magica']; ?></td>
<td><table align="center" border="0" cellspacing="0"><tr><td width="<?php echo $percmin7; ?>" class="sfondoverde"></td><td width="<?php echo $percmin8; ?>" class="sfondorosso"></td></tr>
</table></tr>
</table>
<br />