<center><h2><?php echo $lang['Banca']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<?php echo $lang['depositare']; ?>
<br />
<form action="" method="post" name="deposita">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['quanto_depositare']; ?>: </div></td>
</tr>
<tr>
<td>
<input name="dadepositare" type="text" value="10" size="4" maxlength="5" />
</td>
</tr>
<tr>
<td>
<input type="submit" name="deposita" value="<?php echo $lang['Deposita']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<?php echo $lang['saldo_conto']; echo " ".$userbank['conto']; ?><br />
<br />
<?php echo $lang['prelevare']; ?>
<br />
<form action="" method="post" name="preleva">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['quanto_prelevare']; ?>: </div></td>
</tr>
<tr>
<td>
<input name="daprelevare" type="text" value="1" size="4" maxlength="5" />
</td>
</tr>
<tr>
<td>
<input type="submit" name="preleva" value="<?php echo $lang['Preleva']; ?>" />
</td>
</tr>
</table>
</form>