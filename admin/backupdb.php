<?php

require('../game/inclusi/valori.php');

if($_GET['code']!=$scripts_se_code){header("Location: ../index.php?error=16"); exit();}

$path=MAIN_PATH."/admin/cache/";

foreach($game_server as $chiave=>$elemento){
    $db->Setdb($chiave);
    $sqlfile=$path.$chiave."_".date('Y_m_d').".sql";
    $db->Dbdump($sqlfile);
    $dbsalvati.=" ".$chiave;
}//per ogni regno


$prefix="Backupdb-".$game_state;
$allegato=$prefix."-".date('Y_m_d').".tgz";
$pallegato=$path.$allegato;
$tar="tar cvzf ".$pallegato." ".$path."*";
exec($tar);

foreach($game_server as $chiave=>$elemento){
    $sqlfile=$path.$chiave."_".date('Y_m_d').".sql";
    unlink($sqlfile);
}//per ogni regno

error_reporting(E_ALL);

$oggetto=$game_name." - ".$game_state." DB Backup ".date('d/m/Y');
$contenuto="Backup db:".$dbsalvati;

$tipofile=filetype($pallegato);
$dimfile=filesize($pallegato);
$eol="\n";

$mail_boundary = md5(uniqid(microtime()));

$mail_headers="From: ".$game_mail.$eol;
$mail_headers.="MIME-Version: 1.0".$eol;
$mail_headers.="Content-type: multipart/mixed; boundary=\"".$mail_boundary."\"".$eol.$eol;
$mail_headers.="Content-Transfer-Encoding: 7bit".$eol;
$mail_headers.="This is a multi-part message in MIME format. ".$eol.$eol;

$file=fread(fopen($pallegato, "r"), $dimfile);
$file=chunk_split(base64_encode($file));

$mail_body="--".$mail_boundary.$eol;
$mail_body.="Content-type:text/plain; charset=utf8".$eol;
$mail_body.="Content-transfer-encoding:8 bit".$eol.$eol;
$mail_body.=$contenuto.$eol.$eol;
$mail_body.="--".$mail_boundary.$eol;
$filename=basename($allegato);
$mail_body.="Content-type:application/octet-stream; name=".$filename.$eol;
$mail_body.="Content-transfer-encoding:base64".$eol.$eol;
$mail_body.="Content-Disposition: attachment".$eol.$eol;
$mail_body.=$file.$eol.$eol;
$mail_body.="--".$mail_boundary."--".$eol;

// INVIO DELLA MAIL
if(@mail($game_mail,$oggetto,$mail_body,$mail_headers)){// SE L'INVIO E' ANDATO A BUON FINE...
    echo "<p>La mail è stata inoltrata con successo.</p>";
}else{// ALTRIMENTI...
    echo "<p>Si sono verificati dei problemi nell'invio della mail.</p>";
}

unlink($pallegato);

?>
