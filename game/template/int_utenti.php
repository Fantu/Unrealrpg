<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $infoutenti; ?><br />
<div id="lutenti" align="center">
<?php if($ricerca==1){/*inizio mostra risultati ricerca*/ ?>
<br />
<br />
<?php echo $lang['risultati_nome_cercato']; ?>
<br />
<table border="1" cellspacing="2" cellpadding="2" align="center">
  <tr>
    <td><?php echo $lang['Nome']; ?></td>
    <td><?php echo $lang['Stato']; ?></td>
    <td><?php echo $lang['Livello']; ?></td>
  </tr>
<?php foreach($utentit['nome'] as $chiave=>$elemento){ ?>
<tr>
<td>
<ul>
<li><a class="alutenti" href="index.php?loc=visualizzautente&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $utentit['nome'][$chiave]; ?></a>
<?php if($utentit['userid'][$chiave]!=$user['userid']){ ?><ul><li><a class="alutenti" href="index.php?loc=messaggi&amp;do=scrivi&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $lang['scrivi_msg']; ?></a></li>
<?php if($utentit['online'][$chiave]==1){ ?><li><a class="alutenti" href="index.php?loc=combact&amp;do=sfida&amp;id=<?php echo $utentit['userid'][$chiave]; ?>"><?php echo $lang['sfida']; ?></a></li><?php } ?></ul><?php } ?>
</li>
</ul>
</td>
<td><?php if($utentit['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</td>
<td><?php echo $utentit['livello'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>
<?php }/*fine mostra risultati ricerca*/ ?>
<br />
<br />
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
<br />
<?php echo $prec; ?>  <?php echo $prox; ?>
<br />
<table border="1" cellspacing="2" cellpadding="2" align="center">
  <tr>
    <td><a href="index.php?loc=utenti&amp;ordine=personaggio"><?php echo $lang['Nome']; ?></a></td>
    <td><a href="index.php?loc=utenti&amp;ordine=stato"><?php echo $lang['Stato']; ?></a></td>
    <td><a href="index.php?loc=utenti&amp;ordine=livello"><?php echo $lang['Livello']; ?></a></td>
  </tr>
<?php foreach($utenti['nome'] as $chiave=>$elemento){ ?>
<tr>
<td>
<ul>
<li><a class="alutenti" href="<?php echo $utenti['link'][$chiave]; ?>"><?php echo $utenti['nome'][$chiave]; ?></a>
<?php if($utenti['userid'][$chiave]!=$user['userid']){ ?><ul><li><a class="alutenti" href="index.php?loc=messaggi&amp;do=scrivi&amp;id=<?php echo $utenti['userid'][$chiave]; ?>"><?php echo $lang['scrivi_msg']; ?></a></li>
<?php if($utenti['online'][$chiave]==1){ ?><li><a class="alutenti" href="index.php?loc=combact&amp;do=sfida&amp;id=<?php echo $utenti['userid'][$chiave]; ?>"><?php echo $lang['sfida']; ?></a></li><?php } ?></ul><?php } ?>
</li>
</ul>
</td>
<td><?php if($utenti['online'][$chiave]==1){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>
</td>
<td><?php echo $utenti['livello'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni utente della lista*/ ?>
</table>
<?php echo $prec; ?>  <?php echo $prox; ?>
<br />
</div>