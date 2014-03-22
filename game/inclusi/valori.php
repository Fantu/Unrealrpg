<?php

/**
*
* Unrealrpg - browser game
* Copyright (c) 2014 Fabio Fantoni. This software is licensed under the
* GNU Affero General Public License version 3 (see the file LICENSE.txt).
*
*/

$game_name="Unrealrpg - Browser game";
$game_version="0.8.2";
$game_language=array("it"=>"Italiano","en"=>"English");
define('MAIN_PATH', realpath(dirname(__FILE__).'/../../'));
define('TPL_PATH', MAIN_PATH.'/game/template/');
define('INC_PATH', MAIN_PATH.'/game/inclusi/');
define('LANG_PATH', MAIN_PATH.'/game/language/');
$adesso=strtotime("now");

// include some functions and classes used in many files
require_once(INC_PATH.'funzioni_db.php');
require(INC_PATH.'funzioni.php');
require_once(INC_PATH.'funzioni_log.php');
$log=new Logdb();

// load config file
require_once(INC_PATH.'config.php');
?>
