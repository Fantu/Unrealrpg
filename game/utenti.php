<?php
$a=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE conferma='1' AND personaggio='1'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['username'];
	if ($chi['ultimazione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
require('template/int_utenti.php');
?>