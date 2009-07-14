<?php
require('inclusi/valori.php');
$db->Setdb(999);
$query=$db->QueryCiclo("SELECT * FROM utenti");
while($rec=$db->QueryCicloResult($query)){
echo $rec['username']."<br/>";
}
echo "N query:".$db->nquery."<br/>";
?>