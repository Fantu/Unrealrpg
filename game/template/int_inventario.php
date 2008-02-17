<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Inventario']; ?></h2></center><br />
<br />
<?php echo $outputerrori; ?>
<br />
<br />
<div align="center">
<?php if(!empty($nessunogg)){ echo $nessunogg."<br />";}else{ ?>
<form action="" method="post" name="formvendi">
<table align="center" border="1">	
<?php
foreach($oggetti['nome'] as $chiave=>$elemento){?>
<tr><td><input type="radio" name="oggselect" value="<?php echo $oggetti['id'][$chiave]; ?>" />
<?php echo $oggetti['numero'][$chiave]." ".$oggetti['nome'][$chiave]."<br /></td></tr>";
} ?>
</table>
<br />
<?php echo $lang['Quanti']; ?> <input name="quanti" type="text" maxlength="2" size="3" value="1" />
<input type="submit" name="vendi" value="<?php echo $lang['Vendi']; ?>" />
<input type="submit" name="usa" value="<?php echo $lang['Usa']; ?>" />
</form>
<?php }/*fine se ci sono oggetti*/ ?>
</div>