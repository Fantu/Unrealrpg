<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $titolo; ?></h2></center><br />
<div align="center">
<?php foreach($link as $chiave=>$elemento){ ?>
<br/>
<?php echo $elemento; ?>
<?php }/* fine per ogni link*/ ?>
</div>
<br />