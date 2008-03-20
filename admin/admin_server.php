<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	echo $lang['Accesso_negato'];
}
if (isset($_POST["chiuditutti"])) {
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$db->QueryMod("UPDATE config SET chiuso='1' WHERE id='".$chiave."' LIMIT 1");
echo sprintf($lang['server_chiuso'],$chiave);
}//ogni server
}
if(isset($_POST["apritutti"])) {
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$db->QueryMod("UPDATE config SET chiuso='0' WHERE id='".$chiave."' LIMIT 1");
echo sprintf($lang['server_aperto'],$chiave)."<br/>";
}//ogni server
?>
<br/><br/>
<form method="post" name="fchiuditutti">
<input type="submit" value="<?php echo $lang['chiudi_tutti_server']; ?>" name="chiuditutti" />
</form>
<br/><br/>
<form method="post" name="fapritutti">
<input type="submit" value="<?php echo $lang['apri_tutti_server']; ?>" name="apritutti" />
</form>
<br/><br/>