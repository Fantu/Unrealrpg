<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_inventario.php');
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

if (isset($_POST['vendi'])){
$errore="";
$quanti=(int)$_POST['quanti'];
$oggselect=(int)$_POST['oggselect'];
$numogg=$db->QuerySelect("SELECT oggid,count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='".$oggselect."' GROUP BY oggid");
if ($oggselect<1)
$errore .= $lang['inventario_errore1'];
if ($quanti<1)
$errore .= $lang['inventario_errore2'];
if ($quanti>$numogg['numero'])
$errore .= $lang['inventario_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$monete=$costoogg['costo']*$quanti;	
$outputerrori=sprintf($lang['report_compera'],$quanti,$lang['oggetto'.$oggselect.'_nome'],$prezzo);
$db->QueryMod("UPDATE utenti SET monete=monete-'".$prezzo."' WHERE userid='".$user['userid']."'");	

$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$oggselect."','".$user['userid']."')");

}
}//fine vendi

require('template/int_inventario.php');
?>