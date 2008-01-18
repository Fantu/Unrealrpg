<center><h2><?php echo $lang['Opzioni']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<form action="" method="post" name="cambiasesso">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['Sesso']; ?>: </div></td>
<td>
<select name="sesso" id="sesso">
<?php foreach($sessi['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td>
<input type="submit" name="cambias" value="<?php echo $lang['Cambia_sesso']; ?>" />
</td>
</tr>
</table>
</form>
