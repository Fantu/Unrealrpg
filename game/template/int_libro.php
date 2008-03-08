<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<center><h2><?php echo $lang['Libro_incantesimi']; ?></h2></center><br />
<?php
if($semagie!=1){echo $lang['nessuna_magia_presente'];}else{
foreach($elementi as $chiaveel=>$elementoel){
if(is_array($outputmagie[$elementoel])){
echo $elementoel."<br />";
foreach($tipimagia as $chiavetm=>$elementotm){
if(is_array($outputmagie[$elementoel][$elementotm])){
echo $elementotm."<br />";
foreach($outputmagie[$elementoel][$elementotm] as $chiave=>$elemento){
echo $lang['magia'.$chiave]." - ".$lang['dmagia'.$chiave]."<br />";
}//mostra ogni magia
}//se qualche magia per tipo
}//per ogni tipo 
}//se qualche magia per elemento
}//per ogni elemento
}/*fine mostra incantesimi*/?>
<br />