<center><h2><?php echo $lang['Opzioni']; ?></h2></center><br />
<?php echo $outputerrori; ?>
<?php if($usercar['sesso']==0){ ?>
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
<?php }/*fine cambio sesso*/ ?>
<?php if($user['plus']>0){ ?>
<br />
<br />
<span><?php echo $lang['plus_fino_a'].date("d/m/y - H:i",$user['plus']); ?></span><br />
<?php }else{ ?>
<br />
<br />
<span><?php echo $lang['plus_non_attivo']; ?></span><br />
<?php }/*fine scadenza account plus*/ ?>
<br />
<br />
<span><?php echo sprintf($lang['quanti_punti_plus'],$user['puntiplus']); ?></span><br />