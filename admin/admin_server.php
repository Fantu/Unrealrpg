<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if (isset($_POST["chiuditutti"])) {
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$db->QueryMod("UPDATE config SET chiuso='1' WHERE id='".$chiave."' LIMIT 1");
echo sprintf($lang['server_chiuso'],$chiave)."<br/>";
}//ogni server
}//fine chiudi tutti
if(isset($_POST["apritutti"])) {
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$db->QueryMod("UPDATE config SET chiuso='0' WHERE id='".$chiave."' LIMIT 1");
echo sprintf($lang['server_aperto'],$chiave)."<br/>";
}//ogni server
}//fine apri tutti
if(isset($_POST["aggiornadb"])) {
require('inclusi/aggiornadb.php');
}//fine aggiorna db
if (isset($_POST["controllaflog"])) {
if (!file_exists('../game/inclusi/log/mysql.log')){
umask(0000);
$fp=fopen("../game/inclusi/log/mysql.log","a+");
fputs($fp,"--------\r\n\r\n");
echo $lang['creato_log_query']."<br/>";}
echo $lang['controllo_file_log_eseguito']."<br/>";
}//fine controlla file log
?>
<br/><br/>
<form method="post" action="" name="fchiuditutti">
<input type="submit" value="<?php echo $lang['chiudi_tutti_server']; ?>" name="chiuditutti" />
</form>
<br/>
<form method="post" action="" name="fapritutti">
<input type="submit" value="<?php echo $lang['apri_tutti_server']; ?>" name="apritutti" />
</form>
<br/><br/>
<form method="post" action="" name="faggiornadb">
<input type="submit" value="<?php echo $lang['aggiorna_db']; ?>" name="aggiornadb" />
</form>
<br/><br/>
<form method="post" action="" name="fcontrollaflog">
<input type="submit" value="<?php echo $lang['controlla_file_log']; ?>" name="controllaflog" />
</form>
<br/><br/>