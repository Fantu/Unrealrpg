<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$s=$db->QuerySelect("SELECT count(id) AS n FROM sessione WHERE id='".$uc[0]."' LIMIT 1");
if($s['n']==0){
echo "<script language=\"javascript\">window.location.href='../index.php?error=3'</script>"; exit();
}//se sessione non esistente
$s=$db->QuerySelect("SELECT * FROM sessione WHERE id='".$uc[0]."' LIMIT 1");
if($s['password']!=$uc[1]){
echo "<script language=\"javascript\">window.location.href='../index.php?error=3'</script>"; exit();
}//se password non corrisponde
if($s['ip']!=$_SERVER['REMOTE_ADDR']){
echo "<script language=\"javascript\">window.location.href='../index.php?error=3'</script>"; exit();
}//se ip non corrisponde
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$s['userid']."' AND conferma=1 LIMIT 1");
if($user['userid']){
$db->QueryMod("UPDATE utenti SET ultimazione='".$adesso."' WHERE userid='".$user['userid']."'");
require_once('inclusi/controllo_eventi.php');
Controllaeventi(2);
$eventi=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE userid='".$user['userid']."'");
if($user['personaggio']==1) {
if(($user['refertime']!=0) AND ($user['refertime']<$adesso)){
	$refercheck=explode("|",$user['refer']);
	if($user['server']==$refercheck[1]){
	$referuserid=(int)$refercheck[0];
	$refercheck2=$db->QuerySelect("SELECT COUNT(userid) AS id FROM utenti WHERE userid='".$referuserid."'");
	if($refercheck2['id']>0){
	$revisit=$adesso+2592000;
	$db->QueryMod("UPDATE utenti SET refertime='".$revisit."' WHERE userid='".$user['userid']."'");
	$db->QueryMod("UPDATE utenti SET puntiplus=puntiplus+'2' WHERE userid='".$referuserid."'");
	}else{//fine se referente esiste
	$db->QueryMod("UPDATE utenti SET refertime='0',refer='0' WHERE userid='".$user['userid']."'");
	}//se non esiste annullamento refer
	}//fine se server è lo stesso
}//fine se ora del controllo ref
if($user['plus']<$adesso){
$db->QueryMod("UPDATE utenti SET plus='0' WHERE userid='".$user['userid']."'");
$user=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$user['userid']."' LIMIT 1");
}//se account plus scaduto
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if($eventi['id']==0){
if ($usercar['saluteattuale']<1){
require('inclusi/morte.php');
}//se morto
if ($adesso>($usercar['decfede']+3600)){
	if ($usercar['fede']>0){
		$differenzaora=$adesso-$usercar['decfede'];
		$ore=floor($differenzaora/3600);
		$fede=$usercar['fede']-($ore*8);
		if ($fede<0)
		$fede=0;
		$db->QueryMod("UPDATE caratteristiche SET decfede=decfede+'".($ore*3600)."',fede='".$fede."' WHERE userid='".$user['userid']."'");
	}//se ha fede
	else{$db->QueryMod("UPDATE caratteristiche SET decfede='".$adesso."' WHERE userid='".$user['userid']."'");}
}//fine decremento fede
recenergiasalute($user['userid'],$usercar);
}else{/*fine se non ci sono eventi in corso*/
$evento=$db->QuerySelect("SELECT * FROM eventi WHERE userid='".$user['userid']."' LIMIT 1");
}//se ci sono eventi in corso
}//fine se personaggio creato
require_once('template/int_header.php');
}//fine if userid
else{
header("Location: ../index.php?error=13");
exit();
}
?>
