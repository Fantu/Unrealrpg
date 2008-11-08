<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.13";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='5'");
$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='3'");
$db->QueryMod("UPDATE `oggetti` SET `costo` = '60' WHERE `oggetti`.`id` =61 LIMIT 1");
$db->QueryMod("UPDATE oggetti SET danno=danno-'2' WHERE tipo='5' AND categoria='4'");
$db->QueryMod("UPDATE `oggetti` SET `costo` = '78' WHERE `oggetti`.`id` =64 LIMIT 1");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>