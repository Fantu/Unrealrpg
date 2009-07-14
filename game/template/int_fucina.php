<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['fucina_app']; ?>
<br />
<?php echo $lang['desc_fucina_app']; ?>
<br />
<form action="" method="post" name="lavfucinaapp">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_ore_lavoro']; ?> <select name="ore" id="ore">
<option value="1" selected="selected">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="lavorafucapp" value="<?php echo $lang['lavora_fucina']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['fucina_fab']; ?>
<br />
<?php echo $lang['desc_fucina_fab']; ?>
<br />
<form action="" method="post" name="lavfucinafab">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_ore_lavoro']; ?> <select name="ore2" id="ore2">
<option value="1" selected="selected">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
</select>
</td>
</tr>
<tr>
<td>
<?php echo $lang['seleziona_oggetto_da_forgiare']; ?> <select name="oggettodf" id="oggettodf">
<option value="0" selected="selected">--------</option>
<?php
foreach($oggdf_nome as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<?php echo $lang['seleziona_materiale']; ?> <select name="materiale" id="materiale">
<option value="0" selected="selected">--------</option>
<?php
foreach($materiali_nome as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="lavorafucfab" value="<?php echo $lang['lavora_fucina']; ?>" />
</td>
</tr>
</table>
</form>