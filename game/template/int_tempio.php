<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['Prega']; ?>
<br />
<?php echo $lang['desc_tempio_prega']; ?>
<br />
<?php echo $pfede; ?>
<br />
<form action="" method="post" name="tempioprega">
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
<input type="submit" name="prega" value="<?php echo $lang['Prega']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['Chierici']; ?>
<br />
<?php echo $lang['desc_tempio_chierici']; ?>
<br />
<?php if($resuscita=='0'){ ?>
<form action="" method="post" name="tempiochierici">
<table border="0">
<tr>
<td>
<input type="submit" name="chierici" value="<?php echo $lang['Paga_chierici']; ?>" />
</td>
</tr>
</table>
</form>
<?php }/*fine se chierici non pagati*/ ?>