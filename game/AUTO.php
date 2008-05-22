<?php
if($_GET['code']!='autourbg'){
	header("Location: index.php?error=16");
	exit();}
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
require('inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$adesso=strtotime("now");
$int_security=$game_se_code;
foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$language=$game_server_lang[$chiave];
require('language/'.$language.'/lang_interno.php');
require_once('inclusi/controllo_eventi.php');
Controllaeventi(3);
}//fine ogni server
?>