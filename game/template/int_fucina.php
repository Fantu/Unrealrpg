<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
?>
<center><h2><?php echo $lang['Fucina']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['fucina_app']; ?>
<br />
<?php echo $lang['desc_fucina_app']; ?>
<br />
<form action="" method="post" name="lavfucinaapp">
<table border="0">
<tr>
<td>
<input type="submit" name="lavorafucapp" value="<?php echo $lang['lavora_fucina']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />