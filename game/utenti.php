<?php
if (isset($_POST['crea'])){
$errore="";
if(!$_POST['nome'])
	$errore="Non hai scritto il nome da cercare";
else {
	$utentecercato=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE LIKE '%'".$_POST['nome']."'%' AND conferma='1' AND personaggio='1'");
	if(!$utentecercato['userid'])
		$errore="Non esiste nessun personaggio con il nome che contiene (".$_POST['nome'].").";
}
if($errore){
$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
}else{//inizio mostra risultati
$ricerca=1;
//$a=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE LIKE '%'".$_POST['nome']."'%' AND conferma='1' AND personaggio='1'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($utentecercato)) {
	$i++;
	$utenti['nome'][$i]=$chi['username'];
	if ($chi['ultimazione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
}//fine mostra risultati
}else{//inizio se non cerca
$ordine="ORDER BY userid ASC";
switch($_GET['ordine']){
case "stato":
$ordine="ORDER BY ultimazione DESC";
break;
case "personaggio":
$ordine="ORDER BY username ASC";
break;
}
/*if($_GET['ordine']=="stato"){
$ordine="ORDER BY ultimazione DESC";
}elseif($_GET['ordine']=="personaggio"){
$ordine="ORDER BY username ASC";
}else{
$ordine="ORDER BY userid ASC";
}//fine ordinamenti*/
$a=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE conferma='1' AND personaggio='1' '".$ordine."'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['username'];
	if ($chi['ultimazione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
}//fine se non cerca
require('template/int_utenti.php');
?>