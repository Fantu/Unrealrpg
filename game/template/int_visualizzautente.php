<center><h2><?php echo $datiutente['username']; ?></h2></center><br />
<br />
<?php echo $lang['Razza']; ?>: <?php echo $razze['nome'][$datiutente['razza']]; ?><br />
<?php echo $lang['Classe']; ?>: <?php echo $classi['nome'][$datiutente['classe']]; ?><br />
<?php echo $lang['Sesso']; ?>: <?php echo $sessi['nome'][$datiutente['sesso']]; ?><br />
<?php echo $lang['Livello']; ?>: <?php echo $datiutente['livello']; ?><br />
<?php echo $lang['Salute']; ?>: <?php echo $salute; ?><br />
<?php echo $lang['Energia']; ?>: <?php echo $energia; ?><br />
<?php echo $lang['Stato']; ?>: 
<?php if($datiutente['ultimazione']>($adesso-600)){ ?>
<img src="template/immagini/led_verde.gif" alt="Online" />
<?php }else{ ?>
<img src="template/immagini/led_rosso.gif" alt="Offline" />
<?php } ?>