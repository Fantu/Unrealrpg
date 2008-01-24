<center><h2><?php echo $lang['Inventario']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['Prega']; ?>
<br />
<?php echo $lang['desc_tempio_prega']; ?>
<br />
<form action="" method="post" name="tempioprega">
<table border="0">
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
<?php if($user['resuscita']=='0'){ ?>
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