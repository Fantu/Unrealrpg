<center><h2><?php echo $lang['Situazione']; ?></h2></center><br />
<br />
<div align="center">
<?php echo $newmsg; ?><br />
</div>
<br />
<?php echo $evento; ?>
<br />
<?php echo $lang['Personaggio']; ?>: <?php echo $user['username']; ?><br />
<?php echo $lang['Razza']; ?>: <?php echo $razze['nome'][$usercar['razza']]; ?><br />
<?php echo $lang['Classe']; ?>: <?php echo $classi['nome'][$usercar['classe']]; ?><br />
<?php echo $lang['Sesso']; ?>: <?php echo $sessi['nome'][$usercar['sesso']]; ?><br />
<?php echo $lang['Livello']; ?>: <?php echo $usercar['livello']; ?><br />
<?php echo $lang['Esperienza']; ?>: <?php echo $usercar['exp']; echo "/"; echo $expnewlevel; ?><br />
<?php echo $lang['Salute']; ?>: <?php echo $usercar['saluteattuale']; echo "/"; echo $usercar['salute']; ?><br />
<?php echo $lang['Energia']; ?>: <?php echo $usercar['energia']; echo "/"; echo $usercar['energiamax']; ?><br />
<?php echo $lang['Agilita']; ?>: <?php echo $classi['agilita'][$usercar['classe']]; ?><br />
<?php echo $lang['Attfisico']; ?>: <?php echo $classi['attfisico'][$usercar['classe']]; ?><br />
<?php echo $lang['Attmagico']; ?>: <?php echo $classi['attmagico'][$usercar['classe']]; ?><br />
<?php echo $lang['Diffisica']; ?>: <?php echo $classi['diffisica'][$usercar['classe']]; ?><br />
<?php echo $lang['Difmagica']; ?>: <?php echo $classi['difmagica'][$usercar['classe']]; ?><br />
<?php echo $lang['Mana']; ?>: <?php echo $classi['mana'][$usercar['classe']]; ?><br />
<?php echo $lang['Monete']; ?>: <?php echo $user['monete']; ?><br />
<table><tr><td><?php echo $lang['ab_minatore']; ?>: <?php echo $usercar['minatore']; echo " "; ?></td>
<td width="<?php echo $percmin1; ?>" class="sfondoverde"></td><td width="<?php echo $percmin2; ?>" class="sfondorosso"></td>
</tr></table>
<table><tr><td><?php echo $lang['ab_alchimista']; ?>: <?php echo $usercar['alchimista']; echo " "; ?></td>
<td width="<?php echo $percmin3; ?>" class="sfondoverde"></td><td width="<?php echo $percmin4; ?>" class="sfondorosso"></td>
</tr></table><br />