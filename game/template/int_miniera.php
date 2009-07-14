<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['miniera_nuova']; ?>
<br />
<?php echo $lang['desc_miniera_nuova']; ?>
<br />
<form action="" method="post" name="lavminnuova">
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
<input type="submit" name="lavorainnuova" value="<?php echo $lang['lavora_miniera']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['miniera_vecchia']; ?>
<br />
<?php echo $lang['desc_miniera_vecchia']; ?>
<br />
<form action="" method="post" name="lavminvecchia">
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
<?php echo $lang['seleziona_piccone']; ?> <select name="piccone" id="piccone">
<option value="0" selected="selected">--------</option>
<?php if($picconi){
foreach($picconi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="lavorainvecchia" value="<?php echo $lang['lavora_miniera']; ?>" />
</td>
</tr>
</table>
</form>