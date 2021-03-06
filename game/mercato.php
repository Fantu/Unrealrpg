<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_mercato.php');
require_once('language/'.$language.'/lang_oggetti_categorie.php');
require_once('language/'.$language.'/lang_oggetti_nomi.php');
require_once('inclusi/funzioni_oggetti.php');
$step=(int)$_GET['step'];
switch($_GET['step']){
    case 1:
        $categoria=(int)$_GET['categoria'];
        $linkindietro="<a href=\"index.php?loc=mercato\">".$lang['mercato']."</a> - <b>".$lang['tipo'.$categoria]."</b>";
        if(is_array($catoggetti_nome[$categoria])){// if there are subcategories
            foreach($catoggetti_nome[$categoria] as $chiave=>$elemento){
                $i++;
                $catoggetti[$i]="<a href=\"index.php?loc=mercato&amp;step=2&amp;categoria=".$categoria."&amp;sottocategoria=".$elemento."\">".$lang['categoria'.$categoria.'-'.$elemento]."</a>";
            }
        }else{
            $sottocat=0;
            $mostraogg=1;
        }
        break;
    case 2:
        $categoria=(int)$_GET['categoria'];
        $sottocat=(int)$_GET['sottocategoria'];
        $linkindietro="<a href=\"index.php?loc=mercato\">".$lang['mercato']."</a> - <a href=\"index.php?loc=mercato&amp;step=1&amp;categoria=".$categoria."\">".$lang['tipo'.$categoria]."</a>";
        $mostraogg=1;
        break;
    default:
        foreach($catoggetti_nome as $chiave=>$elemento){
            $i++;
            $catoggetti[$i]="<a href=\"index.php?loc=mercato&amp;step=1&amp;categoria=".$chiave."\">".$lang['tipo'.$chiave]."</a>";
        }
        break;
}

if($mostraogg==1){// items list to show
    $seoggetti=$db->QuerySelect("SELECT COUNT(*) AS id FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
    if($seoggetti['id']==0){
        $nessunogg=$lang['nessun_oggetto_esistente'];
    }else{
        $oggposseduti=$db->QueryCiclo("SELECT id,costo FROM oggetti WHERE tipo='".$categoria."' AND categoria='".$sottocat."'");
        while($ogg=$db->QueryCicloResult($oggposseduti)){
            $i++;
            $oggetti['id'][$i]=$ogg['id'];
            $oggetti['nome'][$i]="<a href=\"index.php?loc=mostraoggetto&amp;ogg=".$ogg['id']."&amp;da=mercato&amp;cat=".$categoria."&amp;scat=".$sottocat."\">".$lang['oggetto'.$ogg['id'].'_nome']."</a>";
            $oggetti['costo'][$i]=$ogg['costo'];
        }
    }
}

if (isset($_POST['compra'])){// processes buy object
    $errore="";
    $quanti=(int)$_POST['quanti'];
    $oggselect=(int)$_POST['oggselect'];
    if ($oggselect<1)
        $errore.=$lang['mercato_errore2'];
    if($errore==""){// check other errors
        $costoogg=$db->QuerySelect("SELECT costo FROM oggetti WHERE id='".$oggselect."' LIMIT 1");
        $prezzo=$costoogg['costo']*$quanti;
        if($eventi['id']>0)
            $errore.=$lang['global_errore1'];
        if($user['monete']<$prezzo)
            $errore.=$lang['mercato_errore1'];
        if($quanti<1)
            $errore.=$lang['mercato_errore3'];
    }
    if($errore){
        $outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
    }else{
        $outputerrori=sprintf($lang['report_compera'],$quanti,$lang['oggetto'.$oggselect.'_nome'],$prezzo);
        $db->QueryMod("UPDATE utenti SET monete=monete-'".$prezzo."' WHERE userid='".$user['userid']."'");
        $user['monete']-=$prezzo;
        $db->QueryMod("UPDATE config SET banca=banca+'".$prezzo."'");
        $noggc="oggetto".$oggselect."_nome";
        $parlog=array(0=>$quanti,1=>'$'.$noggc,2=>$prezzo);
        $log->Utenti($user['userid'],10,$parlog);
        for($i=1; $i<=$quanti; $i++){// for each piece
            $db->QueryMod("INSERT INTO inoggetti (oggid,userid) VALUES ('".$oggselect."','".$user['userid']."')");
        }
    }
}
?>
