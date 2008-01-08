<center><h2><?php echo $lang['Guida']; ?></h2></center><br />
<br />
<?php echo $lang['elenco_razze']; ?><br />
<?php foreach($razze['nome'] as $chiave=>$elemento){ ?>
<?php echo $razze['nome'][$chiave]; ?>:<br />
<?php echo $razze['descrizione'][$chiave]; ?><br />
<?php }?>
<br /><br />
<?php echo $lang['val_fissi_iniziali']; ?><br />
<?php echo $lang['Livello']; ?> 1<br />
<?php echo $lang['Salute']; ?> 100<br />
<?php echo $lang['Energia']; ?> 1000<br />
<?php echo $lang['Monete']; ?> 50<br />
<br /><br />
<?php echo $lang['elenco_classi']; ?><br />
<br />
<?php foreach($classi['nome'] as $chiave=>$elemento){ ?>
<?php echo $classi['nome'][$chiave]; ?>:<br />
<?php echo $classi['descrizione'][$chiave]; ?><br />
<?php echo $lang['Agilita']; ?> <?php echo $classi['agilita'][$chiave]; ?><br />
<?php echo $lang['Attfisico']; ?> <?php echo $classi['attfisico'][$chiave]; ?><br />
<?php echo $lang['Attmagico']; ?> <?php echo $classi['attmagico'][$chiave]; ?><br />
<?php echo $lang['Diffisica']; ?> <?php echo $classi['diffisica'][$chiave]; ?><br />
<?php echo $lang['Difmagica']; ?> <?php echo $classi['difmagica'][$chiave]; ?><br />
<?php echo $lang['Mana']; ?> <?php echo $classi['mana'][$chiave]; ?><br />
<br />
<?php }?>