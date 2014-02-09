<?php

/**
*
* Unrealrpg - browser game
* Copyright (c) 2014 Fabio Fantoni. This software is licensed under the
* GNU Affero General Public License version 3 (see the file LICENSE.txt).
*
*/

// put here a random string
$game_se_code="476etfydugto84";
// game state: DEV for developing, BETA for testing
$game_state="DEV";
// mail sent from server have this as sender
$game_mail="mail@site";
// public site where is installed and folder if is on site subfolder
$game_link="http://site/rpgdev";
// for each game reign id=>name where id is also same is also used as db id
$game_server=array(999=>"DEV-IT",998=>"DEV-EN");
// for each game reign id=>language
$game_server_lang=array(999=>"it",998=>"en");
// the two parameters below are the username and password of sql account
$db=new ConnessioniMySQL("user","password");

// array of banner 120*600, one showed randomly on each internal pages
$banner1=array(
"debian"=>"<a href=\"http://debian.org/\" target=\"_blank\"><img src=\"http://fantu.info/vari/debian.jpg\" border=\"0\" alt=\"\" /></a>",
"libreoffice"=>"<a href=\"http://libreoffice.org/\" target=\"_blank\"><img src=\"http://fantu.info/vari/libreoffice.jpg\" border=\"0\" alt=\"\" /></a>"
);
?>
