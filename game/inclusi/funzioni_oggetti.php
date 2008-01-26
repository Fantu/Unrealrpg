<?php
$catoggetti_nome=array(
1=>array(1),
2=>array(1),
3,
);

function Checkusurarottura($userid) {
global $db;
$oggusati=$db->QueryCiclo("SELECT * FROM inoggetti WHERE userid='".$userid."' AND inuso='1'");
while($ogg=$db->QueryCicloResult($oggusati)) {
$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$ogg['oggid']."' LIMIT 1");
$rotto=0;
$usura=$ogg['usura']+1;
if($usura==$oggetto['usura']){
$rotto=1;
}else{
$rottura=floor($oggetto['probrottura']/$oggetto['usura']*$usura);
$prob=rand(1,10000);
if($prob<$rottura){
$rotto=1;
}
}
if($rotto==1){
$db->QueryMod("DELETE FROM inoggetti WHERE id='".$ogg['id']."'");
}else{
$db->QueryMod("UPDATE inoggetti SET usura=usura+'1',inuso='0' WHERE id='".$ogg['id']."'");
}
}//fine per ogni oggetto usato
}//fine Checkusurarottura
?>