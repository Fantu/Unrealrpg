<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Crea']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<form action="" method="post" name="creapersonaggio">
<table border="0">
<tr>
<td><?php echo $lang['Razza']; ?>: </td>
<td>
<select name="razza" id="razza">
<option value="none" selected="selected">--------</option>
<?php foreach($razze['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td><?php echo $lang['Classe']; ?>: </td>
<td>
<select name="classe" id="classe">
<option value="none" selected="selected">--------</option>
<?php foreach($classi['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td><?php echo $lang['Sesso']; ?>: </td>
<td>
<select name="sesso" id="sesso">
<?php foreach($sessi['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td>
<input type="submit" name="crea" value="<?php echo $lang['Crea']; ?>" />
</td>
</tr>
</table>
</form>
<br /><br /><br />
<?php echo $lang['inizio_con_val_fissi']; ?><br />
<?php echo $lang['Livello']; ?> 1<br />
<?php echo $lang['Salute']; ?> 100<br />
<?php echo $lang['Energia']; ?> 1000<br />
<?php echo $lang['Monete']; ?> 50<br />
<br /><br />
<?php echo $lang['inizio_con_razza']; ?><br />
<?php foreach($razze['nome'] as $chiave=>$elemento){ ?>
<?php echo $razze['nome'][$chiave]; ?>:<br />
<?php echo $razze['descrizione'][$chiave]; ?><br />
<?php }?>
<br /><br />
<?php echo $lang['inizio_con_classe']; ?><br />
<br />
<?php foreach($classi['nome'] as $chiave=>$elemento){ ?>
<?php echo $classi['nome'][$chiave]; ?>:<br />
<?php echo $classi['descrizione'][$chiave]; ?><br />
<?php echo $lang['Agilita']; ?> <?php echo $classi['agilita'][$chiave]; ?><br />
<?php echo $lang['Attfisico']; ?> <?php echo $classi['attfisico'][$chiave]; ?><br />
<?php echo $lang['Attmagico']; ?> <?php echo $classi['attmagico'][$chiave]; ?><br />
<?php echo $lang['Diffisica']; ?> <?php echo $classi['diffisica'][$chiave]; ?><br />
<?php echo $lang['Difmagica']; ?> <?php echo $classi['difmagica'][$chiave]; ?><br />
<?php echo $lang['Mana']; ?> <?php echo $classi['mana'][$chiave]; ?><br />
<?php echo $lang['Velocita']; ?> <?php echo $classi['velocita'][$chiave]; ?><br />
<?php echo $lang['Intelligenza']; ?> <?php echo $classi['intelligenza'][$chiave]; ?><br />
<?php echo $lang['Destrezza']; ?> <?php echo $classi['destrezza'][$chiave]; ?><br />
<br />
<?php }?>