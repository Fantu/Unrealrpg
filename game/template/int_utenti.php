<center><h2><?php echo $lang['Lista_utenti']; ?></h2></center><br />
<br />
<?php echo $outputerrori; ?>
<?php if($ricerca==1){/*inizio mostra risultati ricerca*/ ?>
<br />
<br />
<?php echo $lang['risultati_nome_cercato']; ?>
<br />
<table width="500" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><?php echo $lang['Personaggio']; ?></div></td>
    <td><div align="center"><?php echo $lang['Stato']; ?></div></td>
    <td><div align="center"><?php echo $lang['scrivi_msg']; ?></div></td>
    <td><div align="center"><?php echo $lang['Livello']; ?></div></td>
  </tr>
<?php foreach($utentit['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><div align="center">
<form action="visualizzautente.php" method="post" name="visualizzautente">
<input type="hidden" name="visualizzaid" value="<?php echo $utentit['userid'][$chiave]; ?>" />
<input type="submit" name="visualizza" value="<?php echo $utentit['nome'][$chiave]; ?>" />
</form>
</div></td>
<td><div align="center"><?php if($utentit['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</div></td>
<td><div align="center"><a href="game.php?act=messaggi&amp;do=scrivi&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><img src="template/immagini/mess.gif" alt="<?php echo $lang['scrivi_msg']; ?>" /></a></div></td>
<td><div align="center"><?php echo $utentit['livello'][$chiave]; ?></div></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>
<?php }/*fine mostra risultati ricerca*/ ?>
<br />
<br />
<div align="center">
<form action="game.php?act=utenti" method="post" name="formcu">
<table width="250" border="0" cellspacing="2" cellpadding="2" align="center">
  <tr>
    <td colspan="2"><div align="center"><?php echo $lang['cerca_utente_per_nome']; ?></div></td>
    </tr>
  <tr>
    <td width="50%">
      <div align="right">
        <input name="nome" type="text" id="nome" maxlength="20" />
      </div></td>
    <td width="50%"><input type="submit" name="cercau" value="<?php echo $lang['Cerca']; ?>" /></td>
  </tr>
</table>
</form>
</div>
<br />
<br />
<?php echo $lang['Lista_utenti']; ?>
<br />
<table width="500" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><a href="utenti.php?ordine=personaggio"><?php echo $lang['Personaggio']; ?></a></div></td>
    <td><div align="center"><a href="utenti.php?ordine=stato"><?php echo $lang['Stato']; ?></a></div></td>
    <td><div align="center"><?php echo $lang['scrivi_msg']; ?></div></td>
    <td><div align="center"><?php echo $lang['Livello']; ?></div></td>
  </tr>
<?php foreach($utenti['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><div align="center"><a href="visualizzautente.php?id=<?php echo $utenti['userid'][$chiave]; ?>"><?php echo $utenti['nome'][$chiave]; ?></a></div></td>
<td><div align="center"><?php if($utenti['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</div></td>
<td><div align="center"><a href="game.php?act=messaggi&amp;do=scrivi&amp;id=<?php echo $utenti['userid'][$chiave]; ?>"><img src="template/immagini/mess.gif" alt="<?php echo $lang['scrivi_msg']; ?>" /></a></div></td>
<td><div align="center"><?php echo $utentit['livello'][$chiave]; ?></div></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>