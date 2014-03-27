<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('game/language/'.$language.'/lang_esterno.php');
if(!empty($_GET['refer'])){
$refer=htmlspecialchars($_GET['refer'],ENT_QUOTES);
$server=htmlspecialchars($_GET['server'],ENT_QUOTES);
if(is_numeric($refer) AND is_numeric($server))
setcookie("urbgrefer", $refer."|".$server,time()+604800);
}//se refer
$pagina=htmlspecialchars($_GET['pag'],ENT_QUOTES);
if(!file_exists('pagine/'.$pagina.'.php') OR $pagina=="index")
$pagina="home";
require('game/template/est_header.php');
echo "<table width=\"730\" border=\"0\" align=\"center\"><tr><td width=\"160\" valign=\"top\">";
require('game/template/est_menu.php');
echo "</td><td width=\"570\"><div style=\"height:220px;overflow:auto;\">";
require('pagine/'.$pagina.'.php');
echo "</div></td></tr></table>";
foreach($game_server as $chiave=>$elemento){
if($language==$game_server_lang[$chiave]){
$infoserver['nome'][$chiave]=$elemento;
$db->Setdb($chiave);
$utenti=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti");
$infoserver['utenti'][$chiave]=$utenti['id'];
$sereg=$adesso-604800;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE dataiscrizione>'".$sereg."'");
$infoserver['utentilw'][$chiave]=$online['id'];
$seonline=$adesso-600;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
$infoserver['online'][$chiave]=$online['id'];
$seonline=$adesso-86400;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
$infoserver['online24'][$chiave]=$online['id'];
}
}//fine info server
$olangsfound=0;
foreach($game_language as $chiave=>$elemento){// for each language
    if($chiave!=$language AND in_array($chiave, $game_server_lang)){
        // if the language is different from selected and exists reign with it
        $lingue[$chiave]="<a href=\"index_".$chiave.".php\">".$elemento."</a> ";
        $olangsfound+=1;
    }
}
$end_time=time()+microtime();
$gen_time=number_format($end_time-$start_time, 4, '.', '');
$page_gen=sprintf($lang['tempo_gen_pagina'],$gen_time,$db->nquery);
require('game/template/est_footer.php');
if($_GET['error'])
    require("game/inclusi/errori.php");
?>
