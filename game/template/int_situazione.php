<center><h2><?php echo $lang['Situazione']; ?></h2></center><br />
<br />
<?php echo $lang['Personaggio']; ?>: <?php echo $user['username']; ?><br />
<?php echo $lang['Razza']; ?>: <?php echo $razze['nome'][$usercar['razza']]; ?><br />
<?php echo $lang['Classe']; ?>: <?php echo $classi['nome'][$usercar['classe']]; ?><br />
<?php echo $lang['Livello']; ?>: <?php echo $usercar['livello']; ?><br />
<?php echo $lang['Esperienza']; ?>: <?php echo $usercar['exp']; ?><br />
<?php echo $lang['Salute']; ?>: <?php echo $usercar['salute']; ?><br />
<?php echo $lang['Energia']; ?>: <?php echo $usercar['energia']; echo "/"; echo $usercar['energiamax']; ?><br />