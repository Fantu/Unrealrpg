<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_laboratorio.php');
if($user['plus']==0){$tempoproxlav=$game_proxlav_normal;}else{$tempoproxlav=$game_proxlav_plus;}
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$oggpozioni=$db->QuerySelect("SELECT count(id) AS id FROM oggetti WHERE tipo='4' AND abilitanec<='".$usercar['alchimista']."'");
if($oggpozioni['id']>0){
$oggpozioni=$db->QueryCiclo("SELECT id FROM oggetti WHERE tipo='4' AND abilitanec<='".$usercar['alchimista']."'");
while($oggpozione=$db->QueryCicloResult($oggpozioni)) {
$pozioni[$oggpozione['id']]=$lang['oggetto'.$oggpozione['id'].'_nome'];
}
}//fine può tentare di produrre almeno 1 pozione
if (isset($_POST['lavoralabapp'])){
$errore="";
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['lab_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore .= $lang['lab_errore3'];
if ($usercar['mana']<10)
$errore .= $lang['lab_errore4'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro) VALUES ('".$user['userid']."','".$adesso."','3600','2','1','2')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();	
}
}//fine lavora come apprendista
if (isset($_POST['lavoralabalc'])){
$errore="";
$poziones=(int)$_POST['pozione'];
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 0,1");
$userlav=$db->QuerySelect("SELECT * FROM lavori WHERE userid='".$user['userid']."' LIMIT 0,1");
if ($usercar['energia']<100)
$errore .= $lang['lab_errore1'];
if ($usercar['saluteattuale']<30)
$errore .= $lang['lab_errore2'];
if ($adesso<($userlav['ultimolavoro']+$tempoproxlav))
$errore .= $lang['lab_errore3'];
if ($usercar['mana']<10)
$errore .= $lang['lab_errore4'];
if ($eventi['id']>0)
$errore .= $lang['global_errore1'];
$fiala=$db->QuerySelect("SELECT count(*) AS numero FROM inoggetti WHERE userid='".$user['userid']."' AND oggid='36' LIMIT 1");
if ($fiala['numero']<1)
$errore .= $lang['lab_errore5'];
$pozione=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$poziones."' LIMIT 1");
if ($user['monete']<floor($pozione['costo']/5))
$errore .= $lang['lab_errore6'];
if ($usercar['alchimista']<$pozione['abilitanec'])
$errore .= $lang['lab_errore7'];
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE inoggetti SET inuso='1' WHERE userid='".$user['userid']."' AND oggid='36' ORDER BY usura DESC LIMIT 1");
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,oggid) VALUES ('".$user['userid']."','".$adesso."','3600','7','1','5','".$poziones."')");	
echo "<script language=\"javascript\">window.location.href='game.php?act=situazione'</script>";
exit();	
}
}//fine lavora come alchimista
if($eventi['id']>0){
require('template/int_eventi_incorso.php');
}else{
require('template/int_laboratorio.php');
}
?>