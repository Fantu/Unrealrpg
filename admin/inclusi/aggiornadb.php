<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
    header("Location: ../../index.php?error=16");
    exit();
}
$oldversion="0.8.0";
$newversion="0.8.1";
foreach($game_server as $chiave=>$elemento){
    $db->Setdb($chiave);
    $check=$db->QuerySelect("SELECT version FROM config WHERE id=".$chiave);
    if($check['version']==$oldversion AND $newversion==$game_version){
        // change initial faith from 0 (heretic) to 1000 (believer)
        $db->QueryMod("ALTER TABLE `caratteristiche` CHANGE `fede` `fede` MEDIUMINT( 8 ) UNSIGNED NOT NULL DEFAULT '1000';");
        // add 1000 of faith to all existing characters
        $db->QueryMod("UPDATE `caratteristiche` SET `fede`=`fede`+1000;");
        // update the version on config table of selected reign database
        $db->QueryMod("UPDATE `config` SET version='".$newversion."' WHERE id=".$chiave);
        echo sprintf($lang['aggiornato_db_server'],$chiave,$newversion)."<br />";
    }else{
        echo sprintf($lang['non_aggiornato_db_server'],$chiave)."<br />";
    }
}//end for each server
?>
