<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
if($datiutente){
?>
<center><h2><?php echo $datiutente['username']; ?></h2></center><br />
<br />
<?php echo $lang['Razza']; ?>: <?php echo $razze['nome'][$datiutente['razza']]; ?><br />
<?php echo $lang['Classe']; ?>: <?php echo $classi['nome'][$datiutente['classe']]; ?><br />
<?php echo $lang['Sesso']; ?>: <?php echo $sessi['nome'][$datiutente['sesso']]; ?><br />
<?php echo $lang['Livello']; ?>: <?php echo $datiutente['livello']; ?><br />
<?php echo $lang['Salute']; ?>: <?php echo $salute; ?><br />
<?php echo $lang['Energia']; ?>: <?php echo $energia; ?><br />
<?php echo $lang['Reputazione']; ?>: <?php echo $datiutente['reputazione']; ?><br />
<?php echo $lang['Stato']; ?>: 
<?php if($datiutente['ultimazione']>($adesso-600)){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php }
if ($utente!=$user['userid']){ ?>
<br /><br />
<a href="index.php?loc=messaggi&amp;do=scrivi&amp;id=<?php echo $utente; ?>"><?php echo $lang['scrivi_msg']; ?></a>
<br /><br />
<?php if($datiutente['ultimazione']>($adesso-600)){ ?>
<a href="index.php?loc=combact&amp;do=sfida&amp;id=<?php echo $utente; ?>"><?php echo $lang['sfida']; ?></a>
<br /><br />
<?php }/*se online*/
}//se diverso da se stesso
}/*se utente esiste*/else{ echo $lang['utente_inesistente']; } ?>
<br />
<br />
<a href="<?php echo $linkindietro; ?>"><?php echo $lang['Indietro']; ?></a>