<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['Nord'].": ".$lang['le_montagne']; ?><br />
<?php echo sprintf($lang['ocnord_desc'],round($secondi1/60)); ?><br /><br />
<?php echo $lang['Sud'].": Confine attualmente chiuso"; ?><br /><br />
<?php echo $lang['Ovest'].": Confine attualmente chiuso"; ?><br /><br />
<?php echo $lang['Est'].": Confine attualmente chiuso"; ?><br />
<br />
<br />
<form action="" method="post" name="foltreconfine">
<?php echo $lang['vai_verso']; ?>: 
<select name="direzione" id="direzione"  onchange="conteggio()">
<option value="0" selected="selected">--------</option>
<option value="1"><?php echo $lang['Nord']; ?></option>
</select>
<input type="submit" name="parti" value="<?php echo $lang['Parti']; ?>" />
</form>
<br />