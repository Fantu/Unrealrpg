<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$newversion="0.7.15";
foreach($game_server as $chiave=>$elemento){
if($chiave!=999){
$db->database=$chiave;
$check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
if($check['version']!=$newversion AND $newversion==$game_revision){

$db->QueryMod("CREATE TABLE `sessione` (
`id` VARCHAR( 32 ) NOT NULL ,
`userid` SMALLINT UNSIGNED NOT NULL ,
`password` VARCHAR( 32 ) NOT NULL ,
`ip` VARCHAR( 15 ) NOT NULL ,
`time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM");
$db->QueryMod("ALTER TABLE `sessione` CHANGE `time` `time` INT UNSIGNED NOT NULL");

$db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
}/*se non aggiornato*/else{
echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
}
}//se non è quello di sviluppo principale
}//fine per ogni server
?>