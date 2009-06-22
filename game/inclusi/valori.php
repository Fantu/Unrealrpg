<?php
$game_name="Unreal Rpg - Browser game";
$game_state="DEV";
$game_version="0.8.0";
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
"facilesoft"=>"<a href=\"http://www.facilesoft.it/\" target=\"_blank\"><img src=\"http://lostage.it/game/file/facilesoft_120_600.jpg\" border=\"0\" alt=\"\" /></a>"
);
?>