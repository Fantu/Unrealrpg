<?php
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();

$path=realpath(".")."/cache/";

foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$sqlfile=$path.$chiave."_".date('Y_m_d').".sql";
$db->Dbdump($sqlfile);
$dbsalvati.=" ".$chiave;
}//per ogni regno


$prefix="Backupdb-".$game_version;
$allegato=$prefix."-".date('Y_m_d').".tgz";
$pallegato=$path.$allegato;
$tar="tar cvzf ".$pallegato." ".$path."*";
exec($tar);

foreach($game_server as $chiave=>$elemento){
$sqlfile=$path.$chiave."_".date('Y_m_d').".sql";
unlink($sqlfile);
}//per ogni regno

error_reporting(E_ALL);

$_FILES=$HTTP_POST_FILES;

$oggetto=$game_name." - ".$game_version." DB Backup ".date('d/m/Y');
$mail="server@lostage.it";
$contenuto="Backup db:".$dbsalvati;

$tipofile=filetype($pallegato);
$dimfile=filesize($pallegato);

// DELIMITATORE
$boundary=md5(uniqid(microtime()));

// APRIAMO L'ALLEGATO PER LEGGERLO E CODIFICARLO
$file=@fopen($pallegato, "r");
$contents=@fread($file, $dimfile);
$encoded_attach=chunk_split(base64_encode($contents));
@fclose($file);

// INTESTAZIONI DELLA MAIL
$mail_headers="MIME-version: 1.0\n";
$mail_headers.="Content-type: multipart/mixed; boundary=\"".$boundary."\"";
$mail_headers.="X-attachments: ".$allegato."\n";
$mail_headers.="From: ".$mail."\r\n";


// COSTRUIAMO IL CORPO DELLA MAIL
$mail_body="Content-disposition: attachment; filename =\"".$allegato."\"\n\n";
$mail_body.="--".$boundary."--\n";
$mail_body.="Content-Type: text/plain; charset=utf8\n";
$mail_body.="Content-Transfer-Encoding: 7bit\n\n";
$mail_body.="Contenuto: ".$contenuto."\n\n";
$mail_body.="Soggetto: ".$oggetto."\n\n";
$mail_body.="--".$boundary."\n";
$mail_body.="Content-type: ".$tipofile."; name=\"".$allegato."\"\n";
$mail_body.="Content-Transfer-Encoding: base64\n";
$mail_body.="".$encoded_attach."\n";
$mail_body.="--".$boundary."--\n";

// INVIO DELLA MAIL
if(@mail("fantonifabio@tiscali.it", $oggetto, $mail_body, $mail_headers)) {// SE L'INVIO E' ANDATO A BUON FINE...
echo "<p>La mail è stata inoltrata con successo.</p>";
}else{// ALTRIMENTI...
echo "<p>Si sono verificati dei problemi nell'invio della mail.</p>";
}

unlink($pallegato);

?>