<?php
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();

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
$mail="server@lostage.it";
$contenuto="Backup db:".$dbsalvati;

$tipofile=filetype($pallegato);
$dimfile=filesize($pallegato);

$mail_boundary = md5(uniqid(microtime()));

$mail_headers="From: ".$mail."\n";
$mail_headers.="MIME-Version: 1.0\r\n";
$mail_headers.="Content-type: multipart/mixed; boundary=\"".$mail_boundary."\"";
$mail_headers.="\r\n\r\n";
$mail_headers.="This is a multi-part message in MIME format. ";
$mail_headers.="\r\n\r\n";

$file=fread(fopen($pallegato, "r"), $dimfile);
$file=chunk_split(base64_encode($file));

$mail_body="--".$mail_boundary."\n";
$mail_body.="Content-type:text/plain; charset=iso-8859-1\r\n";
$mail_body.="Content-transfer-encoding:8 bit\r\n\r\n";
$mail_body.="".$contenuto."\n\n\n\n";
$mail_body.="--".$mail_boundary."\n";
$filename=basename($allegato);
$mail_body.="Content-type:application/octet-stream; name=".$filename."\r\n";
$mail_body.="Content-transfer-encoding:base64\r\n\r\n";
$mail_body.=$file."\r\n\r\n";
$mail_body.="--".$mail_boundary."--\r\n";
	
// INVIO DELLA MAIL
if(@mail("fantuf@gmail.com",$oggetto,$mail_body,$mail_headers)){// SE L'INVIO E' ANDATO A BUON FINE...
echo "<p>La mail è stata inoltrata con successo.</p>";
}else{// ALTRIMENTI...
echo "<p>Si sono verificati dei problemi nell'invio della mail.</p>";
}

unlink($pallegato);

?>