<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
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
<?php echo $lang['plus_fino_a'].date("d/m/y - H:i",$user['plus']); ?><br />
<?php }else{ ?>
<br />
<br />
<?php echo $lang['plus_non_attivo']; ?><br />
<?php }/*fine scadenza account plus*/ ?>
<br />
<br />
<?php echo sprintf($lang['quanti_punti_plus'],$user['puntiplus']); ?><br />
<br />
<?php echo $lang['desc_attivare_plus_con_punti']; ?>
<br />
<?php if($user['puntiplus']<3){
echo $lang['non_puoi_attivare_nessun_plus'];
}else{ ?>
<a href="index.php?loc=opzioni&amp;attivaplus=1"><?php echo $lang['attiva_plus_con_punti1']; ?></a>
<?php }
if($user['puntiplus']>9){ ?>
<a href="index.php?loc=opzioni&amp;attivaplus=2"><?php echo $lang['attiva_plus_con_punti2']; ?></a>
<?php }
if($user['puntiplus']>99){ ?>
<a href="index.php?loc=opzioni&amp;attivaplus=3"><?php echo $lang['attiva_plus_con_punti3']; ?></a>
<?php } ?>
<br />
<br />
<?php echo sprintf($lang['desc_link_refer'],$game_name,$game_server[$config['id']]); ?><br />
<?php echo "<blockquote>".$linkref."</blockquote>"; ?><br />
<br />
<?php echo $newsletters; ?><br />
<br />
<?php echo $vacanza; ?><br />
<br />
<?php echo $lang['cambia_password']; ?><br />
<form action="" method="post" name="cambiapsw">
<?php echo $lang['vecchia_password']." "; ?><input name="vpassword" type="password" maxlength="20" /><br />
<?php echo $lang['nuova_password']." "; ?><input name="npassword" type="password" maxlength="20" /><br />
<?php echo $lang['ripeti_password']." "; ?><input name="rpassword" type="password" maxlength="20" /><br />
<input type="submit" name="cambiap" value="<?php echo $lang['cambia_password']; ?>" />
</form>
<br />