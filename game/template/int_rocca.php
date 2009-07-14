<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['roccastudia']; ?>
<br />
<?php echo $lang['desc_rocca_studia']; ?>
<br />
<form action="" method="post" name="lavroccastudia">
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
<?php echo $lang['seleziona_elemento']; ?> <select name="elemento" id="elemento">
<option value="0" selected="selected">--------</option>
<?php
foreach($elementi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="roccastudia" value="<?php echo $lang['roccastudia']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['roccapratica']; ?>
<br />
<?php echo $lang['desc_rocca_pratica']; ?>
<br />
<form action="" method="post" name="lavroccapratica">
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
<?php echo $lang['seleziona_elemento']; ?> <select name="elemento2" id="elemento2">
<option value="0" selected="selected">--------</option>
<?php
foreach($elementi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<?php echo $lang['seleziona_tipo']; ?> <select name="tipo" id="tipo">
<option value="0" selected="selected">--------</option>
<?php
foreach($tipimagia as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="roccapratica" value="<?php echo $lang['roccapratica']; ?>" />
</td>
</tr>
</table>
</form>