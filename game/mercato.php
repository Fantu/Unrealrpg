<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_mercato.php');
require('language/it/lang_oggetti_categorie.php');
require('inclusi/funzioni_oggetti.php');
$step=(int)$_GET['step'];
switch($_GET['step']){
case 1:
$categoria=(int)$_GET['categoria'];
if(is_array($catoggetti_nome[$categoria])){
foreach($catoggetti_nome[$categoria] as $chiave=>$elemento){
$i++;
$langcatsel="categoria".$categoria."-".$chiave;
$catoggetti[$i]="<a href=\"game.php?act=mercato&amp;step=2&amp;categoria=".$chiave."\">"$lang[$langcatsel]."</a>";
}
}//fine se ci sono sottocategorie
else
{
$sottocat=0;
$mostraogg=1;
}
break;
default:
foreach($catoggetti_nome as $chiave=>$elemento){
$i++;
$catoggetti[$i]="<a href=\"game.php?act=mercato&amp;step=1&amp;categoria=".$chiave."\">"$lang['tipo'.$chiave]."</a>";
}
break;
}

if($mostraogg==1){
$seoggetti=$db->QuerySelect("SELECT COUNT(*) AS id FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
if ($seoggetti['id']==0){
$nessunogg=$lang['nessun_oggetto_esistente'];
}else{
require('language/it/lang_oggetti_nomi.php');	
$oggposseduti=$db->QueryCiclo("SELECT oggid AS numero FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
while($ogg=$db->QueryCicloResult($oggposseduti)) {
$i++;
$oggetti['nome'][$i]=$lang['oggetto'.$ogg['oggid'].'_nome'];
}
}
}

if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_mercato.php');
}
?>