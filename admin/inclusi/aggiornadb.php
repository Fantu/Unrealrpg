<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.17";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->Setdb($chiave);
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_version){

$db->QueryMod("UPDATE `pcpudata` SET `salute` = '105',`energia` = '1050',`eqpoz` = '0' WHERE `pcpudata`.`id` =8 LIMIT 1");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>