<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('inclusi/personaggio.php');
require('language/'.$language.'/lang_utenti.php');
$utente=(int)$_GET['id'];
$u=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE userid='".$utente."'");
if($u['n']>0){
$datiutente=$db->QuerySelect("SELECT t1.userid AS userid,t1.username AS username,t1.ultimazione AS ultimazione,t2.livello AS livello,t2.razza AS razza,t2.classe AS classe,t2.sesso AS sesso,t2.salute AS salute,t2.energiamax AS energiamax,t2.saluteattuale AS saluteattuale,t2.energia AS energia,t2.reputazione AS reputazione FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.userid='".$utente."' LIMIT 1");
$percsalute=100/$datiutente['salute']*$datiutente['saluteattuale'];
$salute=testosalute($percsalute);
$percenergia=100/$datiutente['energiamax']*$datiutente['energia'];
$energia=testoenergia($percenergia);
}//se utente esiste
$cheordine=htmlspecialchars($_GET['ordine'],ENT_QUOTES);
$iniziale=(int)$_GET['inizio'];
$linkindietro="index.php?loc=utenti&amp;ordine=".$cheordine."&amp;inizio=".$iniziale;

require('template/int_visualizzautente.php');
?>