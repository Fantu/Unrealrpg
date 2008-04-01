<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Equipaggiamento']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['Armi']; ?>
<br />
<br />
<?php echo $desc_impocac; ?>
<br />
<form action="" method="post" name="fimpocac">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_cac']; ?> <select name="acac" id="acac">
<option value="0" selected="selected">--------</option>
<?php if($armicac){
foreach($armicac as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="impocac" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />