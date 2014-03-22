<div align="justify">
<h3><?php echo $lang['pannello_amministrazione']; ?></h3>
<br/>
<br/>
<strong><?php echo $lang['kingdoms_summary']; ?></strong><br/>
<br/>
<?php foreach($game_server as $chiave=>$elemento){
    echo $elemento." - ".$game_language[$game_server_lang[$chiave]];
    $db->Setdb($chiave);
    $config=$db->QuerySelect("SELECT * FROM config");
    if($config['chiuso']==1)
        echo " - ".$lang['closed'];
    echo "<br/>";
    $utenti=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti");
    echo "Utenti registrati: ".$utenti['id'].", ";
    $seonline=$adesso-600;
    $online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
    echo "Utenti online: ".$online['id'].", ";
    $seonline=$adesso-86400;
    $online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
    echo "Utenti online ultime 24 ore: ".$online['id'].", ";
    $seonline=$adesso-604800;
    $inattivi=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione<'".$seonline."'");
    echo "Utenti inattivi (7 giorni): ".$inattivi['id'].", ";
    $plus=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE plus>'0'");
    echo "Account plus: ".$plus['id']."<br/><br/>";
}/* end for each reign */ ?>
<br/>
<br/>
</div>
