<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_mercato.php');
require('language/it/lang_oggetti_categorie.php');
require('language/it/lang_oggetti_nomi.php');
require('inclusi/funzioni_oggetti.php');
$step=(int)$_GET['step'];
switch($_GET['step']){
case 1:
$categoria=(int)$_GET['categoria'];
if(is_array($catoggetti_nome[$categoria])){
foreach($catoggetti_nome[$categoria] as $chiave=>$elemento){
$i++;
$catoggetti[$i]="<a href=\"game.php?act=mercato&amp;step=2&amp;categoria=".$categoria."&amp;sottocategoria=".$elemento."\">".$lang['categoria'.$categoria.'-'.$elemento]."</a>";
}
}//fine se ci sono sottocategorie
else
{
$sottocat=0;
$mostraogg=1;
}
break;
case 2:
$categoria=(int)$_GET['categoria'];
$sottocat=(int)$_GET['sottocategoria'];
$mostraogg=1;
break;
default:
foreach($catoggetti_nome as $chiave=>$elemento){
$i++;
$catoggetti[$i]="<a href=\"game.php?act=mercato&amp;step=1&amp;categoria=".$chiave."\">".$lang['tipo'.$chiave]."</a>";
}
break;
}

if($mostraogg==1){
$seoggetti=$db->QuerySelect("SELECT COUNT(*) AS id FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
if ($seoggetti['id']==0){
$nessunogg=$lang['nessun_oggetto_esistente'];
}else{	
$oggposseduti=$db->QueryCiclo("SELECT id,costo FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
while($ogg=$db->QueryCicloResult($oggposseduti)) {
$i++;
$oggetti['id'][$i]=$ogg['id'];
$oggetti['nome'][$i]=$lang['oggetto'.$ogg['id'].'_nome'];
$oggetti['costo'][$i]=$ogg['costo'];
}
}
}//fine mostra lista oggetti

if (isset($_POST['compra'])){
$errore="";
$quanti=(int)$_POST['quanti'];
$oggselect=(int)$_POST['oggselect'];
$costoogg=$db->QuerySelect("SELECT costo FROM oggetti WHERE id='".$oggselect."' LIMIT 1");
$prezzo=$costoogg['costo']*$quanti;
if ($user['monete']<$prezzo)
$errore .= $lang['mercato_errore1'];
if ($oggselect<1)
$errore .= $lang['mercato_errore2'];
if ($quanti<1)
$errore .= $lang['mercato_errore3'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$outputerrori=sprintf($lang['report_compera'],$quanti,$lang['oggetto'.$oggselect.'_nome'],$prezzo);
$db->QueryMod("UPDATE utenti SET monete=monete-'".$prezzo."' WHERE userid='".$user['userid']."'");	
for($i=1; $i<=$quanti; $i++){
$db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$oggselect."','".$user['userid']."')");
}
}
}//fine compra

if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_mercato.php');
}
?>