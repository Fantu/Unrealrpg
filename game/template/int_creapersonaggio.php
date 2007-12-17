<?php echo $outputerrori; ?>
<form action="" method="post" name="creapersonaggio">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['Razza']; ?>: </div></td>
<td>
<select name="razza" id="razza">
<option value="none" selected="selected">--------</option>
<?php foreach($razze['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td><div align="right"><?php echo $lang['Classe']; ?>: </div></td>
<td>
<select name="classe" id="classe">
<option value="none" selected="selected">--------</option>
<?php foreach($classi['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td>
<input type="submit" name="crea" value="Crea" />
</td>
</tr>
</table>
</form>
<br /><br /><br />
Inizierai con tali valori fissi per tutti:<br />
<?php echo $lang['Livello']; ?> 1<br />
<?php echo $lang['Salute']; ?> 100<br />
<?php echo $lang['Energia']; ?> 1000<br />
<?php echo $lang['Monete']; ?> 50<br />
<br /><br />
La razza la puoi scegliere tra le seguenti:<br />
<?php foreach($razze['nome'] as $chiave=>$elemento){ ?>
<?php echo $razze['nome']; ?>:<br />
<?php echo $razze['descrizione']; ?><br />
<?php }?>
<br /><br />
La classe la puoi scegliere tra le seguenti:<br />
<br />
<?php foreach($classi['nome'] as $chiave=>$elemento){ ?>
<?php echo $classi['nome']; ?>:<br />
<?php echo $classi['descrizione']; ?><br />
<?php echo $lang['Agilita']; ?> <?php echo $classi['agilita']; ?><br />
<?php echo $lang['Attfisico']; ?> <?php echo $classi['attfisico']; ?><br />
<?php echo $lang['Attmagico']; ?> <?php echo $classi['attmagico']; ?><br />
<?php echo $lang['Diffisica']; ?> <?php echo $classi['diffisica']; ?><br />
<?php echo $lang['Difmagica']; ?> <?php echo $classi['difmagica']; ?><br />
<?php echo $lang['Mana']; ?> <?php echo $classi['mana']; ?><br />
<br />
<?php }?>