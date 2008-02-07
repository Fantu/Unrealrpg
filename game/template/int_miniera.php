<center><h2><?php echo $lang['Miniera']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['miniera_nuova']; ?>
<br />
<?php echo $lang['desc_miniera_nuova']; ?>
<br />
<form action="" method="post" name="lavminnuova">
<table border="0">
<tr>
<td>
<input type="submit" name="lavorainnuova" value="<?php echo $lang['lavora_miniera']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['miniera_vecchia']; ?>
<br />
<?php echo $lang['desc_miniera_vecchia']; ?>
<br />
<form action="" method="post" name="lavminvecchia">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_piccone']; ?> <select name="piccone" id="piccone">
<option value="0" selected="selected">--------</option>
<?php if($seoggpicconi['id']>0){
foreach($picconi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="lavorainvecchia" value="<?php echo $lang['lavora_miniera']; ?>" />
</td>
</tr>
</table>
</form>