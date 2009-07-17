<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.8.0";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->Setdb($chiave);
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_version){

$db->QueryMod("DROP TABLE 'systemlog'");
$db->QueryMod("DROP TABLE 'userlog'");
$db->QueryMod("CREATE TABLE `logsistema` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`msg` VARCHAR( 1000 ) NOT NULL ,
`data` INT( 10 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;");
$db->QueryMod("CREATE TABLE `logutenti` (
`id` INT( 10 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`userid` SMALLINT( 4 ) UNSIGNED NOT NULL ,
`msg` SMALLINT( 3 ) UNSIGNED NOT NULL ,
`parametri` VARCHAR( 200 ) NOT NULL ,
`data` INT( 10 ) UNSIGNED NOT NULL
) ENGINE = MYISAM ;");
/*solo per la stabile
$db->QueryMod("ALTER TABLE `config` ADD `cancellazioni` INT( 10 ) UNSIGNED NOT NULL");
*/

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>