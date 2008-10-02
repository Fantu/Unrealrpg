<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_municipio.php');

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

require('template/int_municipio.php');
?>