<?php
$game_name="Unreal Rpg - Browser game";
$game_version="DEV";
$game_revision="0.6.14";
$game_link="http://unrealff.it/rpgdev";
$game_server=array(999=>"DEV",998=>"DEV");
$game_language=array("it"=>"Italiano","en"=>"English");
$game_server_lang=array(999=>"it",998=>"en");
$game_se_code="f87d5gf945fhut";
$game_proxlav_normal=10800;
$game_proxlav_plus=7200;
$game_location=array('banca','changelog','combact','fucina','guida','inventario','laboratorio','libro','logout','mercato','messaggi','miniera','mostraoggetto','opzioni','rocca','situazione','tempio','utenti','visualizzautente','equipaggiamento','levelup','submenu','locanda','archiviorep');

$game_intestazione_mail.="From: ".$game_name."<server@lostage.it>\r\n";
$game_intestazione_mail.="Reply-To: ".$game_name."<server@lostage.it>\r\n";
$game_intestazione_mail.="Message-ID: <".time()."-server@lostage.it>\r\n";
$game_intestazione_mail.="X-Mailer: PHP v".phpversion()."\r\n";
$game_intestazione_mail.="MIME-Version: 1.0\r\n";
$game_intestazione_mail.="Content-Type: text/html; charset=utf8\r\n";
?>