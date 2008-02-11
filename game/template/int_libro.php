<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
?>
<center><h2><?php echo $lang['Libro_incantesimi']; ?></h2></center><br />
In sviluppo...<br />