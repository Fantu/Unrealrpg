<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_oggetti_nomi.php');

$catoggetti_nome=array(
1=>array(1),
2=>array(1),
3,
4=>array(1,2),
5=>array(1,2,3,4,5)
);

$materiali_nome=array(
1=>$lang['Rame'],
2=>$lang['Ferro'],
3=>$lang['Acciaio']
);

$materiali_num=array(
1=>array(1=>1,2=>1,3=>0),
2=>array(1=>1,2=>0,3=>1),
3=>array(1=>1,2=>0,3=>2)
);

$oggdf_nome=array(
1=>$lang['Piccone'],
2=>$lang['Pugnale'],
3=>$lang['Daga']
);

$oggdf_num=array(
1=>array(1=>2,2=>1),
2=>array(1=>5,2=>1),
3=>array(1=>5,2=>2)
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
if($usura>=$oggetto['usura']){
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
if($ogg['equip']==1){
$oggineq=$db->QueryCiclo("SELECT * FROM equipaggiamento WHERE userid='".$userid."' LIMIT 1");
foreach($oggineq[0] as $chiave=>$elemento){
if($chiave!="userid"){
if($elemento==$ogg['id']){
$campo=$chiave;
}//se corrisponde
}//se non è l'id
}//per ogni equip
$db->QueryMod("UPDATE equipaggiamento SET ".$campo."='0' WHERE userid='".$userid."' LIMIT 1");
}
}else{
$db->QueryMod("UPDATE inoggetti SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."' LIMIT 1");
}
}//fine per ogni oggetto usato
}/*fine se ci sono oggetti usati*/else{
$oggpersi=$lang['nessuno_gettato']."<br />";}
return $oggpersi;
}/*fine Checkusurarottura*/

function Usaoggetto($userid,$oggid) {
global $db,$lang;
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$nomeogg=$lang['oggetto'.$oggetto['id'].'_nome'];
switch($oggetto['tipo']){
		case 4://pozioni generiche
			switch($oggetto['categoria']){
			case 1://pozioni curative
			$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$oggid."' AND equip='0' ORDER BY usura DESC LIMIT 1");
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$salute=$car['saluteattuale']+$oggetto['recsalute'];
			if($salute>$car['salute'])
			$salute=$car['salute'];
			$db->QueryMod("UPDATE caratteristiche SET saluteattuale='".$salute."' WHERE userid='".$userid."'");
			$output=sprintf($lang['utilizzato_4_1'],$nomeogg,$oggetto['recsalute']);
			break;
			case 2://pozioni energetiche
			$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$oggid."' AND equip='0' ORDER BY usura DESC LIMIT 1");
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$energia=$car['energia']+$oggetto['recenergia'];
			if($energia>$car['energiamax'])
			$energia=$car['energiamax'];
			$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."' WHERE userid='".$userid."'");
			$output=sprintf($lang['utilizzato_4_2'],$nomeogg,$oggetto['recenergia']);
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