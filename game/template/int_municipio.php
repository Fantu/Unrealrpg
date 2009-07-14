<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['ronda_cittadina']; ?><br />
<br />
<?php echo $lang['desc_ronda_cittadina']; ?><br />
<form action="" method="post" name="lavronda">
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
<input type="submit" name="faironda" value="<?php echo $lang['fai_ronda']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<?php echo $nguardie; ?><br />
<br />
<?php echo $livcrimine; ?><br />
<br />
<?php echo $liveconomia; ?><br />
<br />
<?php echo $montesoreria; ?><br />
<br />
<br />
<?php echo $lang['desc_bacheca']; ?><br />
<br />
<?php echo $bacheca; ?><br />
<br />