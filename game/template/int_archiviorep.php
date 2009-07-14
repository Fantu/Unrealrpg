<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<div align="center">
<?php if($link){
foreach($link as $chiave=>$elemento){ ?>
<br/>
<?php echo $elemento; ?>
<?php }/* fine per ogni report*/
}else{/*se ci sono report*/
echo $lang['nessun_report_presente'];} ?>
</div>
<br />