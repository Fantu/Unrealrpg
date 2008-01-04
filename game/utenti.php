<?php
if($_GET['ordine']=="stato"){
$ordine="ORDER BY ultimazione DESC";
}elseif($_GET['ordine']=="personaggio"){
$ordine="ORDER BY username ASC";
}else{
$ordine="ORDER BY userid ASC";
}//fine ordinamenti
$a=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE conferma='1' AND personaggio='1''".$ordine."'");
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