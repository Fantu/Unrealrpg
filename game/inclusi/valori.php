<?php
$game_name="Unreal Rpg - Browser game";
$game_version="DEV";
$game_revision="0.7.11";
$game_link="http://unrealff.it/rpgdev";
$game_server=array(999=>"DEV",998=>"DEV");
$game_language=array("it"=>"Italiano","en"=>"English");
$game_server_lang=array(999=>"it",998=>"en");
$game_se_code="f87d5gf945fhut";
$game_location=array('banca','changelog','combact','fucina','guida','inventario','laboratorio','libro','logout','mercato','messaggi','miniera','mostraoggetto','opzioni','rocca','situazione','tempio','utenti','visualizzautente','equipaggiamento','levelup','submenu','locanda','archiviorep','confini','municipio');

$game_intestazione_mail.="From: ".$game_name."<server@lostage.it>\r\n";
$game_intestazione_mail.="Reply-To: ".$game_name."<server@lostage.it>\r\n";
$game_intestazione_mail.="Message-ID: <".time()."-server@lostage.it>\r\n";
$game_intestazione_mail.="X-Mailer: PHP v".phpversion()."\r\n";
$game_intestazione_mail.="MIME-Version: 1.0\r\n";
$game_intestazione_mail.="Content-Type: text/html; charset=utf8\r\n";

//banner 120*600
$banner1=array(
"default"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(275035)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>",
"nike"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(275541)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>",
"apple"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(275579)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>",
"multiplayer"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(276343)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>",
"unieuro"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(276956)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>",
"ebay"=>"<script type=\"text/javascript\">
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(280642)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type=\"text/javascript\" src=\"'+uri+'\" charset=\"ISO-8859-1\"></sc'+'ript>');
</script>"
);
?>