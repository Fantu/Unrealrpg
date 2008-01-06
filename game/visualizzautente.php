<?php
//$utente=$_POST['visualizzaid'];
//$datiutente=$db->QuerySelect("SELECT t1.userid,t1.username AS username,t1.ultimazione AS ultimazione,t2.livello AS livello,t2.razza AS razza,t2.classe AS classe FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE userid='5' LIMIT 0,1");
//require('inclusi/funzioni_db.php');
//$db = new ConnessioniMySQL();
$db->database = 0;
$datiutente=$db->QuerySelect("SELECT * FROM utenti WHERE userid='5'");
require('inclusi/personaggio.php');
require('template/int_visualizzautente.php');
?>