<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Locanda']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['prendi_stanza']; ?>
<br />
<?php echo $lang['desc_prendi_stanza']; ?>
<br />
<form action="" method="post" name="loc_dormi">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_ore_lavoro']; ?> <select name="ore" id="ore">
<option value="1" selected="selected">1</option>
<option value="2">2</option>
<option value="3">3</option>
<option value="4">4</option>
<option value="5">5</option>
<option value="6">6</option>
<option value="7">7</option>
<option value="8">8</option>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="dormi" value="<?php echo $lang['dormi']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />