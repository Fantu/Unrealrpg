<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Libro_incantesimi']; ?></h2></center><br />
<?php
if($semagie==1){echo $lang['nessuna_magia_presente'];}else{
foreach($elementi as $chiaveel=>$elementoel){ 
echo $elementoel."<br />";
foreach($tipimagia as $chiavetm=>$elementotm){echo $elementotm."<br />";
foreach($magie as $elemento){
if($magie[$elemento['magid']]['tipo']==$elementotm AND $magie[$elemento['magid']]['elemento']==$elementoel){
echo $lang['magia'.$elemento['magid']]." - ".$lang['dmagia'.$elemento['magid']];
}//se corrispondente
}//mostra ogni magia
}//per ogni tipo 
}//per ogni elemento
}/*fine mostra incantesimi*/?>
<br />