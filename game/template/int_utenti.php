<center><h2><?php echo $lang['Lista_utenti']; ?></h2></center><br />
<br />
In sviluppo...<br />
<br />
<table width="500" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><?php echo $lang['Personaggio']; ?></div></td>
  </tr>
<?php foreach($utenti['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><?php echo $utenti['nome'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>