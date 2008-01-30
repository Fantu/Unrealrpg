<?php
require('language/it/lang_utenti.php');
if (isset($_POST['cercau'])){
$errore="";
if(!$_POST['nome'])
	$errore=$lang['utenti_error1'];
else {
	$utentecercato=$db->QuerySelect("SELECT t1.userid AS id,t1.username AS nome,t1.ultimazione AS azione,t2.livello AS liv FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.username LIKE '%".$_POST['nome']."%' AND t1.conferma='1' AND t1.personaggio='1'");
	if(!$utentecercato['id'])
		$errore=sprintf($lang['utenti_error2'],$_POST['nome']);
}
if($errore){
$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
}else{//inizio mostra risultati
$ricerca=1;
$utentecercato=$db->QueryCiclo("SELECT t1.userid AS id,t1.username AS nome,t1.ultimazione AS azione,t2.livello AS liv FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.username LIKE '%".$_POST['nome']."%' AND t1.conferma='1' AND t1.personaggio='1'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($utentecercato)) {
	$i++;
	$utentit['nome'][$i]=$chi['nome'];
	$utentit['userid'][$i]=$chi['id'];
	$utentit['livello'][$i]=$chi['liv'];
	if ($chi['azione']>$seonline){
	$utentit['online'][$i]=1;}else
	{$utentit['online'][$i]=0;}
}
}//fine mostra risultati
}
$cheordine=htmlentities($_GET['ordine']);
switch($cheordine){
case "stato":
$ordine="ORDER BY t1.ultimazione DESC";
break;
case "personaggio":
$ordine="ORDER BY t1.username ASC";
break;
case "livello":
$ordine="ORDER BY t2.livello DESC";
break;
default:
$ordine="ORDER BY t1.userid ASC";
break;
}
$a=$db->QueryCiclo("SELECT t1.userid AS id,t1.username AS nome,t1.ultimazione AS azione,t2.livello AS liv FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.conferma='1' AND t1.personaggio='1' ".$ordine."");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['nome'];
	$utenti['userid'][$i]=$chi['id'];
	$utentit['livello'][$i]=$chi['liv'];
	if ($chi['azione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
require('template/int_utenti.php');
?>