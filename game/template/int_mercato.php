<center><h2><?php echo $lang['Mercato']; ?></h2></center><br />
<?php
switch($_GET['step']){
case 1:
foreach($catoggetti_nome[$categoria] as $chiave=>$elemento){
$i++;
$catoggetti[$i]="<a href=\"game.php?act=mercato&amp;step=2&amp;categoria=".$chiave."\">"$lang['tipo'.$chiave]."</a>";
}
else
{
$sottocat=0;
$mostraogg=1;
}
break;
default:
foreach($catoggetti as $chiave=>$elemento){
echo $catoggetti[$chiave]."<br />";
}
break;
} ?>