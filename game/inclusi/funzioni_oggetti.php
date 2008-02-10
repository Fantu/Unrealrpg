<?php
require_once('language/it/lang_oggetti_nomi.php');

$catoggetti_nome=array(
1=>array(1),
2=>array(1),
3,
4=>array(1,2),
);

function Checkusurarottura($userid) {
global $db,$lang;
$oggusati=$db->QuerySelect("SELECT count(oggid) AS numero FROM inoggetti WHERE userid='".$userid."' AND inuso='1'");
if($oggusati['numero']>0){
$oggusati=$db->QueryCiclo("SELECT * FROM inoggetti WHERE userid='".$userid."' AND inuso='1'");
while($ogg=$db->QueryCicloResult($oggusati)) {
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$ogg['oggid']."' LIMIT 1");
$rotto=0;
$usura=$ogg['usura']+1;
if($usura==$oggetto['usura']){
$rotto=1;
$oggpersi.=sprintf($lang['oggetto_usurato'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
}else{
$rottura=floor($oggetto['probrottura']/$oggetto['usura']*$usura);
$prob=rand(1,10000);
if($prob<$rottura){
$rotto=1;
$oggpersi.=sprintf($lang['oggetto_rotto'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
}
}
if($rotto==1){
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$ogg['id']."'");
}else{
$db->QueryMod("UPDATE inoggetti SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."'");
}
}//fine per ogni oggetto usato
}/*fine se ci sono oggetti usati*/else{
$oggpersi=$lang['nessuno_gettato'];}
return $oggpersi;
}/*fine Checkusurarottura*/

function Usaoggetto($userid,$oggid) {
global $db,$lang;
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$nomeogg=$lang['oggetto'.$oggetto['oggid'].'_nome'];
switch($oggetto['tipo']){
		case 4://pozioni generiche
			switch($oggetto['categoria']){
			case 1://pozioni curative
			$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$oggid."' ORDER BY usura DESC LIMIT 1");
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$salute=$car['saluteattuale']+$oggetto['recsalute'];
			if($salute>$car['salute'])
			$salute=$car['salute'];
			$db->QueryMod("UPDATE caratteristiche SET saluteattuale='".$salute."' WHERE userid='".$userid."'");
			$output="Hai utilizzato ".$nomeogg." e recuperato ".$oggetto['recsalute']." di salute";
			break;
			case 2://pozioni energetiche
			$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$oggid."' ORDER BY usura DESC LIMIT 1");
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$energia=$car['energia']+$oggetto['recenergia'];
			if($energia>$car['energiamax'])
			$energia=$car['energiamax'];
			$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."' WHERE userid='".$userid."'");
			$output="Hai utilizzato ".$nomeogg." e recuperato ".$oggetto['recenergia']." di energia;
			break;
			default:
			$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
			break;
			}	
		break;
		default:
		$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
		break;
		}
return $output;
}/*fine Usaoggetto*/
?>