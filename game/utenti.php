<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_utenti.php');
$totutenti=$db->QuerySelect("SELECT COUNT(userid) AS numero FROM utenti");
$utentireg=$totutenti['numero'];
$seonline=$adesso-600;
$online=$db->QuerySelect("SELECT COUNT(userid) AS numero FROM utenti WHERE ultimazione>'".$seonline."'");
$utentionline=$online['numero'];
$totpersonaggi=$db->QuerySelect("SELECT COUNT(userid) AS numero FROM utenti WHERE personaggio='1'");
$personaggi=$totpersonaggi['numero'];
$infoutenti=sprintf($lang['info_utenti_server'],$utentireg,$personaggi,$utentionline);
if (isset($_POST['cercau'])){
$errore="";
if(!$_POST['nome']){
	$errore=$lang['utenti_error1'];}elseif(strlen($_POST['nome'])<3){
	$errore=$lang['utenti_error3'];
	}else {
	$nomdacercare=htmlentities($_POST['nome']);
	$utentecercato=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE username LIKE '%".$nomdacercare."%' AND conferma='1' AND personaggio='1'");
	if($utentecercato['id']==0)
		$errore=sprintf($lang['utenti_error2'],$nomdacercare);
}
if($errore){
$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
}else{//inizio mostra risultati
$ricerca=1;
$utentecercato=$db->QueryCiclo("SELECT t1.userid AS id,t1.username AS nome,t1.ultimazione AS azione,t2.livello AS liv FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.username LIKE '%".$nomdacercare."%' AND t1.conferma='1' AND t1.personaggio='1'");
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
$cheordine="none";
$ordine="ORDER BY t1.userid ASC";
break;
}
$perpag=20;
$num=$db->QuerySelect("SELECT count(userid) AS id FROM utenti WHERE conferma='1' AND personaggio='1'");
if($num['id']<($perpag+1)){
$iniziale=0;
}else{
$inizio=(int)$_GET['inizio'];
if($inizio<1){
$iniziale=0;}else{
$iniziale=$inizio;
}
if($num['id']>($iniziale+$perpag)){
$prox=$iniziale+$perpag;
$prox="<a href=\"game.php?act=utenti&amp;ordine=".$cheordine."&amp;inizio=".$prox."\">".$perpag." ".$lang['seguenti']."</a>";}
if($iniziale!=0){
$prec=$iniziale-$perpag;
$prec="<a href=\"game.php?act=utenti&amp;ordine=".$cheordine."&amp;inizio=".$prec."\">".$perpag." ".$lang['precedenti']."</a>";}

}//fine se maggiore di per pagina
$a=$db->QueryCiclo("SELECT t1.userid AS id,t1.username AS nome,t1.ultimazione AS azione,t2.livello AS liv FROM utenti AS t1 JOIN caratteristiche t2 ON t1.userid=t2.userid WHERE t1.conferma='1' AND t1.personaggio='1' ".$ordine." LIMIT ".$iniziale.",".$perpag);
$i=0;
$seonline=$adesso-600;
while($chi=$db->QueryCicloResult($a)) {
	$i++;
	$utenti['nome'][$i]=$chi['nome'];
	$utenti['userid'][$i]=$chi['id'];
	$utenti['link'][$i]="game.php?act=visualizzautente&amp;id=".$chi['id']."&amp;ordine=".$cheordine."&amp;inizio=".$iniziale;
	$utentit['livello'][$i]=$chi['liv'];
	if ($chi['azione']>$seonline){
	$utenti['online'][$i]=1;}else
	{$utenti['online'][$i]=0;}
}
require('template/int_utenti.php');
?>