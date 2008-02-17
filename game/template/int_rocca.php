<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Rocca_arcano']; ?></h2></center><br />
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