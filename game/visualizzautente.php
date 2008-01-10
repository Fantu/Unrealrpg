<?php
require('inclusi/personaggio.php');
$utente=$_GET['id'];
$datiutente=$db->QuerySelect("SELECT t1.userid AS userid,t1.username AS username,t1.ultimazione AS ultimazione,t2.livello AS livello,t2.razza AS razza,t2.classe AS classe,t2.sesso AS sesso FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.userid='".$utente."' LIMIT 0,1");
require('template/int_visualizzautente.php');
?>