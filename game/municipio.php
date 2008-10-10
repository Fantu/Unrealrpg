<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_municipio.php');

if (isset($_POST['faironda'])){
$errore="";
$ore=(int)$_POST['ore'];
if($ore<1 OR $ore>5)
$errore.=$lang['global_errore2'];
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if($errore==""){
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$user['userid']."' LIMIT 1");
if ((100/$usercar['salute']*$usercar['saluteattuale'])<60 OR (100/$usercar['energiamax']*$usercar['energia'])<60)
$errore.=$lang['ronda_errore1'];
}//se non ci sono altri errori
if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,lavoro,ore) VALUES ('".$user['userid']."','".$adesso."','3600','17','1','9','".$ore."')");	
echo "<script language=\"javascript\">window.location.href='index.php?loc=situazione'</script>";
exit();
}
}//fine fai ronda

$config=$db->QuerySelect("SELECT banca,crimine FROM config LIMIT 1");
$lcrimine=$config['crimine'];
if($lcrimine>=10 AND $lcrimine<20){
$livcrimine=$lang['molto_bassa'];
}elseif ($lcrimine>=20 AND $lcrimine<40){
$livcrimine=$lang['bassa'];
}elseif ($lcrimine>=40 AND $lcrimine<60){
$livcrimine=$lang['media'];
}elseif ($lcrimine>=60 AND $lcrimine<80){
$livcrimine=$lang['alta'];
}elseif ($lcrimine>=80 AND $lcrimine<=100){
$livcrimine=$lang['molto_alta'];}
$livcrimine=sprintf($lang['liv_crimine'],$livcrimine);

$leconomia=$config['banca'];
if($leconomia<100){
$liveconomia=$lang['in_crisi'];
}else{
$liveconomia=$lang['prospera'];}
$liveconomia=sprintf($lang['liv_economia'],$liveconomia);

$guardie=$db->QuerySelect("SELECT COUNT(id) AS n FROM eventi WHERE lavoro='9'");
$nguardie=sprintf($lang['guardie_presenti'],$guardie['n']);

$bacheca="";
$bdata=$db->QuerySelect("SELECT COUNT(id) AS n FROM bacheca");
if($bdata['n']>0){
$bd=$db->QueryCiclo("SELECT * FROM bacheca ORDER BY data DESC");
while($br=$db->QueryCicloResult($bd)) {
$bacheca=date("d/m/y - H:i",$br['data'])." - ".$br['testo']."<br/>";
}
}//se ci sono eventi

require('template/int_municipio.php');
?>