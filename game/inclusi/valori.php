<?php
$game_name="Unreal Rpg - Browser game";
$game_version="DEV";
$game_revision="0.7.17";
$game_link="http://unrealff.it/rpgdev";
$game_server=array(999=>"DEV",998=>"DEV");
$game_language=array("it"=>"Italiano","en"=>"English");
$game_server_lang=array(999=>"it",998=>"en");
$game_se_code="f87d5gf945fhut";
define('MAIN_PATH', realpath(dirname(__FILE__).'/../../'));
define('TPL_PATH', MAIN_PATH.'/game/template/');
$game_mail="server@lostage.it";
$adesso=strtotime("now");

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
</script>",
"facilesoft"=>"<a href=\"http://www.facilesoft.it/\" target=\"_blank\"><img src=\"http://lostage.it/game/file/facilesoft_120_600.jpg\" border=\"0\" alt=\"\" /></a>"
);
?>