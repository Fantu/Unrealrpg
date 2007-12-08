<?php echo $outputerrori; ?>
<form action="" method="post" name="creapersonaggio">
<table border="0">
<tr>
<td><div align="right">Razza: </div></td>
<td>
<select name="razza" id="razza">
<option value="none" selected="selected">--------</option>
<?php foreach($razze['nome'] as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>"; ?>
</select></td>
</tr>
<tr>
<td>
<input type="submit" name="crea" value="Crea" />
</td>
</tr>
</table>
</form>