<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Levelup']; ?></h2></center><br />
<br />
<?php echo $outputerrori; ?>
<br />
<br />
<form action="" method="post" name="formlevelup">
<?php echo $lang['desc_tablevup1']; ?>
<table align="center" border="1">
<tr>
<td><?php echo $lang['caratteristica']; ?></td>
<td><?php echo $lang['valore_attuale']; ?></td>
<td><?php echo $lang['perc_scelta']; ?></td>
</tr>
<tr>
<td><?php echo $lang['Salute']; ?></td>
<td><?php echo $usercar['salute']; ?></td>
<td><input name="salute" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Energia']; ?></td>
<td><?php echo $usercar['energiamax']; ?></td>
<td><input name="energia" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Mana']; ?></td>
<td><?php echo $usercar['mana']; ?></td>
<td><input name="mana" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
</table>
<br />
<?php echo $lang['desc_tablevup2']; ?>
<table align="center" border="1">
<tr>
<td><?php echo $lang['caratteristica']; ?></td>
<td><?php echo $lang['valore_attuale']; ?></td>
<td><?php echo $lang['perc_scelta']; ?></td>
</tr>
<tr>
<td><?php echo $lang['Attfisico']; ?></td>
<td><?php echo $usercar['attfisico']; ?></td>
<td><input name="attfisico" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Attmagico']; ?></td>
<td><?php echo $usercar['attmagico']; ?></td>
<td><input name="attmagico" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Diffisica']; ?></td>
<td><?php echo $usercar['diffisica']; ?></td>
<td><input name="diffisica" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Difmagica']; ?></td>
<td><?php echo $usercar['difmagica']; ?></td>
<td><input name="difmagica" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Velocita']; ?></td>
<td><?php echo $usercar['velocita']; ?></td>
<td><input name="velocita" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Agilita']; ?></td>
<td><?php echo $usercar['agilita']; ?></td>
<td><input name="agilita" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Intelligenza']; ?></td>
<td><?php echo $usercar['intelligenza']; ?></td>
<td><input name="intelligenza" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
<tr>
<td><?php echo $lang['Destrezza']; ?></td>
<td><?php echo $usercar['destrezza']; ?></td>
<td><input name="destrezza" type="text" maxlength="2" size="3" value="0" /></td>
</tr>
</table>
<br />
<input type="submit" name="sali" value="<?php echo $lang['uplevel']; ?>" />
</form>