<center><h2><?php echo $lang['Lista_utenti']; ?></h2></center><br />
<br />
In sviluppo...<br />
<br />
<table width="500" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><?php echo $lang['Personaggio']; ?></div></td>
    <td><div align="center"><?php echo $lang['Stato']; ?></div></td>
  </tr>
<?php foreach($utenti['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><div align="center"><?php echo $utenti['nome'][$chiave]; ?></div></td>
<td><div align="center"><?php if($utenti['online'][$chiave]==1){ ?>
<img src="game/template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="game/template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</div></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>