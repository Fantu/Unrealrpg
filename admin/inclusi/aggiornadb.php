<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.12";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("UPDATE `pcpudata` SET `eqarm` = '86' WHERE `pcpudata`.`id` =6 LIMIT 1");
$db->QueryMod("UPDATE `pcpudata` SET `eqarm` = '85',`eqscu` = '88' WHERE `pcpudata`.`id` =4 LIMIT 1");
$db->QueryMod("CREATE TABLE `userlog` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`userid` SMALLINT UNSIGNED NOT NULL ,
`testo` VARCHAR( 1000 ) NOT NULL ,
`data` INT( 13 ) UNSIGNED NOT NULL
) ENGINE = MYISAM");
$db->QueryMod("CREATE TABLE `systemlog` (
`id` INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`testo` TEXT NOT NULL ,
`data` INT( 13 ) UNSIGNED NOT NULL
) ENGINE = MYISAM");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>