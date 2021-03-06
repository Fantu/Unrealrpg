<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_oggetti_nomi.php');

// categories and subcategories of the market
$catoggetti_nome=array(
    1=>array(1),// Raw materials with subcategories: 1=>Minerals
    2=>array(1),// Tools with subcategories: 1=>Picks
    3,// Miscellaneous
    4=>array(1,2),// Generic potions with subcategories: 1=>Heling potions, 2=>Energy potions
    5=>array(1,2,3,4,5),// Hand to hand weapons with subcategories: 1=>Daggers, 2=>Short swords, 3=>Swords , 4=>Axes , 5=>Maces
    7=>array(1,2),// Long distance weapons with subcategories: 1=>Knives, 2=>Bows
    6=>array(1,2)// Defensive equip with subcategories: 1=>Armors, 2=>Shields
);

$materiali_nome=array(
1=>$lang['Rame'],
2=>$lang['Ferro'],
3=>$lang['Acciaio'],
4=>$lang['Mithrill']
);

$materiali_num=array(
1=>array(1=>1,2=>1,3=>0,4=>0),
2=>array(1=>1,2=>0,3=>1,4=>0),
3=>array(1=>2,2=>0,3=>2,4=>0),
4=>array(1=>3,2=>0,3=>0,4=>1)
);

$oggdf_nome=array(
1=>$lang['Piccone'],
2=>$lang['Pugnale'],
3=>$lang['Daga'],
4=>$lang['Spada'],
5=>$lang['Ascia'],
6=>$lang['Mazza'],
7=>$lang['Armatura'],
8=>$lang['Scudo']
);

$oggdf_num=array(
1=>array(1=>2,2=>1),
2=>array(1=>5,2=>1),
3=>array(1=>5,2=>2),
4=>array(1=>5,2=>3),
5=>array(1=>5,2=>4),
6=>array(1=>5,2=>5),
7=>array(1=>6,2=>1),
8=>array(1=>6,2=>2)
);

function Checkusurarottura($userid,$cpu) {
    global $db,$lang;
    $check=0;
    // check inventory (only for player)
    if($cpu==0){
        $oggusati=$db->QuerySelect("SELECT count(id) AS numero FROM inoggetti WHERE userid='".$userid."' AND inuso='1'");
        if($oggusati['numero']>0){/* if there are object used */
            $check=1;
            $oggusati=$db->QueryCiclo("SELECT * FROM inoggetti WHERE userid='".$userid."' AND inuso='1'");
            while($ogg=$db->QueryCicloResult($oggusati)) {
                $oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$ogg['oggid']."' LIMIT 1");
                $rotto=0;
                $usura=$ogg['usura']+1;
                if($usura>=$oggetto['usura']){
                    $rotto=1;
                    $oggpersi.=sprintf($lang['oggetto_usurato'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
                }else{
                    if($oggetto['probrottura']!=0){// if it breaks
                        $rottura=floor($oggetto['probrottura']/$oggetto['usura']*($usura-1));
                        $prob=rand(0,10000);
                        if($prob<$rottura){// if it breaks
                            $rotto=1;
                            $oggpersi.=sprintf($lang['oggetto_rotto'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
                        }
                    }
                }
                if($rotto==1){
                    $db->QueryMod("DELETE FROM inoggetti WHERE id='".$ogg['id']."'");
                }else{
                    $db->QueryMod("UPDATE inoggetti SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."' LIMIT 1");
                }
            }// end for each object used
        }/* end if there are object used */
    }
    // check equipment
    if($cpu==0)
        $oggusati=$db->QuerySelect("SELECT count(id) AS numero FROM equip WHERE userid='".$userid."' AND inuso='1'");
    else
        $oggusati=$db->QuerySelect("SELECT count(id) AS numero FROM equipcpu WHERE cpuid='".$userid."' AND inuso='1'");
    if($oggusati['numero']>0){/* if there are object used */
        $check=1;
        if($cpu==0)
            $oggusati=$db->QueryCiclo("SELECT * FROM equip WHERE userid='".$userid."' AND inuso='1'");
        else
            $oggusati=$db->QueryCiclo("SELECT * FROM equipcpu WHERE cpuid='".$userid."' AND inuso='1'");
    while($ogg=$db->QueryCicloResult($oggusati)) {
        $oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$ogg['oggid']."' LIMIT 1");
        $rotto=0;
        $usura=$ogg['usura']+1;
        if($usura>=$oggetto['usura']){// if it has reached the maximum wear
            $rotto=1;
            $oggpersi.=sprintf($lang['oggetto_usurato'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
        }else{
            if($oggetto['probrottura']!=0){// if the object can break
                $rottura=floor($oggetto['probrottura']/$oggetto['usura']*($usura-1));
                $prob=rand(0,10000);
                if($prob<$rottura){// if it breaks
                    $rotto=1;
                    $oggpersi.=sprintf($lang['oggetto_rotto'],$lang['oggetto'.$ogg['oggid'].'_nome'])."<br />";
                }
            }
        }
        if($rotto==1){
            if($cpu==0){
                $db->QueryMod("DELETE FROM equip WHERE id='".$ogg['id']."'");
                $oggineq=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$userid."' LIMIT 1");
            }else{
                $db->QueryMod("DELETE FROM equipcpu WHERE id='".$ogg['id']."'");
                $oggineq=$db->QuerySelect("SELECT * FROM equipagcpu WHERE cpuid='".$userid."' LIMIT 1");
            }
            // search the field of equipment to be reset
            foreach($oggineq as $chiave=>$elemento){
                if($chiave!="userid"){
                    if($elemento==$ogg['oggid'])
                        $campo=$chiave;
                }// if is not the id
            }// for each equip
            if($cpu==0)
                $db->QueryMod("UPDATE equipaggiamento SET ".$campo."='0' WHERE userid='".$userid."' LIMIT 1");
            else
                $db->QueryMod("UPDATE equipagcpu SET ".$campo."='0' WHERE cpuid='".$userid."' LIMIT 1");
        }else{
            if($cpu==0)
                $db->QueryMod("UPDATE equip SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."' LIMIT 1");
            else
                $db->QueryMod("UPDATE equipcpu SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."' LIMIT 1");
        }
    }// end for each object used
    }/* end if there are object used */
    if($check==0)
        $oggpersi=$lang['nessuno_gettato']."<br />";
    return $oggpersi;
}/* end Checkusurarottura*/

function Usaoggetto($userid,$oggid) {
global $db,$lang;
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$oggid."' LIMIT 1");
$nomeogg=$lang['oggetto'.$oggetto['id'].'_nome'];
$ok=1;
switch($oggetto['tipo']){
		case 4://pozioni generiche
			switch($oggetto['categoria']){
			case 1://pozioni curative
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$salute=$car['saluteattuale']+$oggetto['recsalute'];
			if($salute>$car['salute'])
			$salute=$car['salute'];
			$db->QueryMod("UPDATE caratteristiche SET saluteattuale='".$salute."' WHERE userid='".$userid."'");
			$output=sprintf($lang['utilizzato_4_1'],$nomeogg,$oggetto['recsalute']);
			break;
			case 2://pozioni energetiche
			$car=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
			$energia=$car['energia']+$oggetto['recenergia'];
			if($energia>$car['energiamax'])
			$energia=$car['energiamax'];
			$db->QueryMod("UPDATE caratteristiche SET energia='".$energia."' WHERE userid='".$userid."'");
			$output=sprintf($lang['utilizzato_4_2'],$nomeogg,$oggetto['recenergia']);
			break;
			default:
			$ok=0;
			$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
			break;
			}
		break;
		default:
		$ok=0;
		$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
		break;
		}
if($ok==1){
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$userid."' AND oggid='".$oggid."' ORDER BY usura DESC LIMIT 1");
}//se usato
return $output;
}/*fine Usaoggetto*/
?>
