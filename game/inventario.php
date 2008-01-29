<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$seoggetti=$db->QuerySelect("SELECT COUNT(*) AS id FROM inoggetti WHERE userid='".$user['userid']."'");
if ($seoggetti['id']==0){
$nessunogg=$lang['nessun_oggetto_posseduto'];
}else{
require('language/it/lang_oggetti_nomi.php');	
$oggposseduti=$db->QueryCiclo("SELECT oggid,count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg=$db->QueryCicloResult($oggposseduti)) {
$i++;
$oggetti['numero'][$i]=$ogg['numero'];
$oggetti['nome'][$i]="<a href=\"mostraoggetto.php?ogg=".$ogg['oggid']."&amp;da=inventario\">".$lang['oggetto'.$ogg['oggid'].'_nome']."</a>";
}
}
require('template/int_inventario.php');
?>