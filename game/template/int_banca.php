<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Banca']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['saldo_utente']; echo " ".$user['monete']; ?><br />
<br />
<?php echo $lang['depositare']; ?>
<br />
<form action="" method="post" name="deposita">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['quanto_depositare']; ?></div></td>
</tr>
<tr>
<td>
<input name="dadepositare" type="text" value="1" size="4" maxlength="5" />
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
<?php echo $infointeressi; ?><br />
<br />
<?php if ($userbank['conto']>0){ 
echo $lang['prelevare']; ?>
<br />
<form action="" method="post" name="preleva">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['quanto_prelevare']; ?></div></td>
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
<?php }/*fine se il conto non è vuoto*/ ?>
<br />
<?php echo $lang['desc_prestito']; ?>
<br />
<form action="" method="post" name="prendiprestito">
<table border="0">
<tr>
<td><div align="right"><?php echo $lang['quanto_prestito_chiedere']; ?></div></td>
</tr>
<tr>
<td>
<input name="inprestito" type="text" value="1" size="4" maxlength="5" />
</td>
</tr>
<tr>
<td>
<input type="submit" name="chiediprestito" value="<?php echo $lang['Chiedi_prestito']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<?php if ($userbank['prestito']>0){
echo $lang['restituzione_prestito']." ".$prestito; ?>
<br />
<form action="" method="post" name="daiprestito">
<table border="0">
<tr>
<td>
<input type="submit" name="restituisciprestito" value="<?php echo $lang['Restituisci_prestito']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<?php }/*fine se ha debiti*/ ?>
<br />
<br />
<?php echo $lang['Lotteria']; ?><br />
<?php echo $lang['desc_lotteria']; ?><br />
<?php if ($userbank['lotteria']==0){ ?>
<form action="" method="post" name="lotteria">
<table border="0">
<tr>
<td>
<input type="submit" name="comprabiglietto" value="<?php echo $lang['Compra_biglietto']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<?php }else{/*fine se non ha il biglietto*/
echo $lang['hai_gia_biglietto'];} ?>
<br />
<?php echo $infopartecipanti;} ?><br />
<?php echo $infovincitore;} ?><br />
<br />