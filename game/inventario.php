<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_inventario.php');
if (isset($_POST['vendi'])){
$errore="";
$quanti=(int)$_POST['quanti'];
$oggselect=(int)$_POST['oggselect'];
$numogg=$db->QuerySelect("SELECT oggid,usura,count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$oggselect."' GROUP BY oggid");
if ($oggselect<1)
$errore .= $lang['inventario_errore1'];
if ($quanti<1)
$errore .= $lang['inventario_errore2'];
if ($quanti>$numogg['numero'])
$errore .= $lang['inventario_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$cogg=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggselect."' ORDER BY usura DESC LIMIT 1");	
if($cogg['usura']>1){
$monete=floor(($cogg['costo']/2)/$cogg['usura']*($cogg['usura']-$numogg['usura']));
}else{
$monete=floor($cogg['costo']/2);
}
if($quanti>1){
$numero=$quanti-1;
$monete+=floor($numero*($cogg['costo']/2));
}
$outputerrori=sprintf($lang['report_vendita'],$quanti,$lang['oggetto'.$oggselect.'_nome'],$monete);
$db->QueryMod("UPDATE utenti SET monete=monete+'".$monete."' WHERE userid='".$user['userid']."'");	
$db->QueryMod("DELETE FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$oggselect."' LIMIT ".$quanti);
}
}//fine vendi

$seoggetti=$db->QuerySelect("SELECT COUNT(*) AS id FROM inoggetti WHERE userid='".$user['userid']."'");
if ($seoggetti['id']==0){
$nessunogg=$lang['nessun_oggetto_posseduto'];
}else{
require('language/it/lang_oggetti_nomi.php');	
$oggposseduti=$db->QueryCiclo("SELECT oggid,count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' GROUP BY oggid");
while($ogg=$db->QueryCicloResult($oggposseduti)) {
$i++;
$oggetti['id'][$i]=$ogg['oggid'];
$oggetti['numero'][$i]=$ogg['numero'];
$oggetti['nome'][$i]="<a href=\"game.php?act=mostraoggetto&amp;ogg=".$ogg['oggid']."&amp;da=inventario\">".$lang['oggetto'.$ogg['oggid'].'_nome']."</a>";
}
}//fine mostra oggetti

require('template/int_inventario.php');
?>