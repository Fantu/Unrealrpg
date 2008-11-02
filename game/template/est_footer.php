<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit(); ?>
<?php echo $lang['Informazioni_sui_server']; ?>
<table width="750" border="0" align="center">
<tr>
<td><?php echo $lang['Nome']."</td><td>".$lang['Utenti_registrati']."</td><td>".$lang['Ultima_settimana']."</td><td>".$lang['Utenti_online']."</td><td>".$lang['Ultimo_giorno']; ?></td>
</tr>
<?php foreach($game_server as $chiave=>$elemento){ ?>
<tr>
<td><?php echo $infoserver['nome'][$chiave]."</td><td>".$infoserver['utenti'][$chiave]."</td><td>".$infoserver['utentilw'][$chiave]."</td><td>".$infoserver['online'][$chiave]."</td><td>".$infoserver['online24'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni server*/ ?>
</table>
<br /><br />
<?php echo sprintf($lang['altre_lingue'],$game_name); foreach($lingue as $chiave=>$elemento) echo $lingue[$chiave]; ?>