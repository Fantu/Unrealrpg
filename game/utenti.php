<?php
require('language/it/lang_utenti.php');
if (isset($_POST['cercau'])){
$errore="";
if(!$_POST['nome'])
	$errore=$lang['utenti_error1'];
else {
	$utentecercato=$db->QuerySelect("SELECT userid,username,ultimazione FROM utenti WHERE username LIKE '%".$_POST['nome']."%' AND conferma='1' AND personaggio='1'");
	if(!$utentecercato['userid'])
		$errore=sprintf($lang['utenti_error2'],$_POST['nome']);
}
if($errore){
$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
}else{//inizio mostra risultati
$ricerca=1;
$utentecercato=$db->QueryCiclo("SELECT t1.userid,t1.username,t1.ultimazione,t2.livello FROM utenti AS t1 JOIN utenti t2 ON t1.userid=t2.userid WHERE t1.username LIKE '%".$_POST['nome']."%' AND t1.conferma='1' AND t1.personaggio='1'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($utentecercato)) {
	$i++;
	$utentit['nome'][$i]=$chi['username'];
	$utentit['userid'][$i]=$chi['userid'];
	$utentit['livello'][$i]=$chi['livello'];
	if ($chi['ultimazione']>$seonline){
	$utentit['online'][$i]=1;}else
	{$utentit['online'][$i]=0;}
}
}//fine mostra risultati
}
switch($_GET['ordine']){
case "stato":
$ordine="ORDER BY ultimazione DESC";
break;
case "personaggio":
$ordine="ORDER BY username ASC";
break;
default:
$ordine="ORDER BY userid ASC";
break;
}
$a=$db->QueryCiclo("SELECT userid,username,ultimazione FROM utenti WHERE conferma='1' AND personaggio='1' '".$ordine."'");
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['username'];
	$utenti['userid'][$i]=$chi['userid'];
	if ($chi['ultimazione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
require('template/int_utenti.php');
?>