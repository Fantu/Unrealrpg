<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
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
    <td><div align="center"><?php echo $lang['sfida']; ?></div></td>
    <td><div align="center"><?php echo $lang['Livello']; ?></div></td>
  </tr>
<?php foreach($utentit['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><div align="center"><a href="index.php?loc=visualizzautente&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $utentit['nome'][$chiave]; ?></a></div></td>
<td><div align="center"><?php if($utentit['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</div></td>
<td><div align="center"><a href="index.php?loc=messaggi&amp;do=scrivi&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><img src="template/immagini/mess.gif" alt="<?php echo $lang['scrivi_msg']; ?>" /></a></div></td>
<td><div align="center"><?php if($utentit['online'][$chiave]==1){ ?><a href="index.php?loc=combact&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $lang['sfida']; ?></a><?php } ?></div></td>
<td><div align="center"><?php echo $utentit['livello'][$chiave]; ?></div></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>
<?php }/*fine mostra risultati ricerca*/ ?>
<br />
<br />
<?php echo $infoutenti; ?><br />
<br />
<br />
<div align="center">
<form action="index.php?loc=utenti" method="post" name="formcu">
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
<?php echo $prec; ?>  <?php echo $prox; ?>
<br />
<table width="500" border="1" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><a href="index.php?loc=utenti&amp;ordine=personaggio"><?php echo $lang['Personaggio']; ?></a></div></td>
    <td><div align="center"><a href="index.php?loc=utenti&amp;ordine=stato"><?php echo $lang['Stato']; ?></a></div></td>
    <td><div align="center"><?php echo $lang['scrivi_msg']; ?></div></td>
    <td><div align="center"><?php echo $lang['sfida']; ?></div></td>
    <td><div align="center"><a href="index.php?loc=utenti&amp;ordine=livello"><?php echo $lang['Livello']; ?></a></div></td>
  </tr>
<?php foreach($utenti['nome'] as $chiave=>$elemento){ ?>
<tr>
<td><div align="center"><a href="<?php echo $utenti['link'][$chiave]; ?>"><?php echo $utenti['nome'][$chiave]; ?></a></div></td>
<td><div align="center"><?php if($utenti['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</div></td>
<td><div align="center"><a href="index.php?loc=messaggi&amp;do=scrivi&amp;id=<?php echo $utenti['userid'][$chiave]; ?>"><img src="template/immagini/mess.gif" alt="<?php echo $lang['scrivi_msg']; ?>" /></a></div></td>
<td><div align="center"><?php if($utentit['online'][$chiave]==1){ ?><a href="index.php?loc=combact&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $lang['sfida']; ?></a><?php } ?></div></td>
<td><div align="center"><?php echo $utentit['livello'][$chiave]; ?></div></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>