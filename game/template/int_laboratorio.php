<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['lav_apprendista']; ?>
<br />
<?php echo $lang['desc_lav_apprendista']; ?>
<br />
<form action="" method="post" name="lavlabapp">
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
<input type="submit" name="lavoralabapp" value="<?php echo $lang['lav_apprendista']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['lav_alchimista']; ?>
<br />
<?php echo $lang['desc_lav_alchimista'];
echo "<br />";
if($pozioni){ ?>
<br />
<form action="" method="post" name="lavlabalc">
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
<?php echo $lang['seleziona_pozione']; ?> <select name="pozione" id="pozione">
<option value="0" selected="selected">--------</option>
<?php
foreach($pozioni as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="lavoralabalc" value="<?php echo $lang['lav_alchimista']; ?>" />
</td>
</tr>
</table>
</form>
<?php }else{echo $lang['nessuna_pozione_poss'];} ?>
<br />