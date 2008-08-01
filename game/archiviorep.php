<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
$serep=$db->QuerySelect("SELECT COUNT(id) AS num FROM battlereport WHERE attid='".$user['userid']."' OR difid='".$user['userid']."'");
if ($serep['num']>0){//controllo se ci sono rep
$reps=$db->QueryCiclo("SELECT * FROM battlereport WHERE attid='".$user['userid']."' OR difid='".$user['userid']."' ORDER BY id DESC");
while($rep=$db->QueryCicloResult($reps)){
if($rep['finito']==1){
if($rep['attid']==$user['userid']){
if($rep['difid']==0){$sfidante=$lang['nomepcpu'.$rep['cpuid']];}else{$s=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$rep['difid']."' LIMIT 1"); $sfidante=$s['username'];}
}else{$s=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$rep['attid']."' LIMIT 1"); $sfidante=$s['username'];}
$link[]='<a href="index.php?loc=combact&do=repview&id='.$rep['id'].'">'.sprintf($lang['combact_avvenuto'],$sfidante).date($lang['dataora'],$rep['data']).'</a>';
}
}//per ogni report
}//se ci sono report
require('template/int_archiviorep.php');
?>