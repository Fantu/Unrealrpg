<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
?>
<center><h2><?php echo $lang['Laboratorio']; ?></h2></center><br />
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
if($pozioni){ ?>
<br />
<form action="" method="post" name="lavlabalc">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_pozione']; ?> <select name="piccone" id="piccone">
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