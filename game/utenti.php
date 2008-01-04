<?php
$a=$db->QueryCiclo("SELECT userid,username FROM utenti WHERE conferma='1' AND personaggio='1'");
$i=0;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['username'];
}
require('template/int_utenti.php');
?>