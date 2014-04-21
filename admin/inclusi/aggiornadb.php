<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
    header("Location: ../../index.php?error=16");
    exit();
}
$oldversion="0.8.1";
$newversion="0.8.2";
foreach($game_server as $chiave=>$elemento){
    $db->Setdb($chiave);
    $check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
    if($check['version']==$oldversion AND $newversion==$game_version){
        /* CHANGES TO DATABASE */
        // Modified the damage of mithrill short sword from 18 to 19
        $db->QueryMod("UPDATE `oggetti` SET `danno` = '19' WHERE `oggetti`.`id` =78;");
        // Modified the wooden shields
        $db->QueryMod("UPDATE `oggetti` SET `probrottura` = '300',`costo` = '8',`energia` = '5',`forzafisica` = '25',`difesafisica` = '5' WHERE `oggetti`.`id` =57;");
        $db->QueryMod("UPDATE `oggetti` SET `probrottura` = '200',`costo` = '16',`energia` = '7',`forzafisica` = '30',`difesafisica` = '7' WHERE `oggetti`.`id` =58;");
        // Modified the leather armors
        $db->QueryMod("UPDATE `oggetti` SET `probrottura` = '300',`costo` = '8',`energia` = '3',`difesafisica` = '3' WHERE `oggetti`.`id` =55;");
        $db->QueryMod("UPDATE `oggetti` SET `probrottura` = '200',`costo` = '16',`energia` = '4',`forzafisica` = '15',`difesafisica` = '5' WHERE `oggetti`.`id` =56;");
        // Added simple bow
        $db->QueryMod("INSERT INTO `oggetti` (`id` ,`tipo` ,`categoria` ,`probrottura` ,`costo` ,`energia` ,`usura` ,`bonuseff` ,`forzafisica` ,`destrezza` ,`probtrovare` ,`recsalute` ,`recenergia` ,`abilitanec` ,`materiale` ,`danno` ,`difesafisica`) VALUES ('105', '7', '2', '100', '20', '20', '60', '0', '30', '50', '0', '0', '0', '0', '0', '8', '0');");
        // Add ipv6 support
        $db->QueryMod("ALTER TABLE `sessione` CHANGE `ip` `ip` VARCHAR( 39 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;");
        $db->QueryMod("ALTER TABLE `utenti` CHANGE `ipreg` `ipreg` VARCHAR( 39 ) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ;");

        // update the version on config table of selected reign database
        $db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
        echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
    }else{
        echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
    }
}//end for each server
?>
