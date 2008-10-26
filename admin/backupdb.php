<?php
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();

$path=realpath(".")."/cache/";

foreach($game_server as $chiave=>$elemento){
$db->database=$chiave;
$sqlfile=$path.$chiave."_".date('Y_m_d').".sql";
$db->Dbdump($sqlfile);
}//per ogni regno


$prefix=$game_name." - ".$game_version;
$allegato=$prefix.date('Y_m_d').".tgz";
$tar="tar cvzf ".$path.$allegato." ".$path."*";
exec($tar);

foreach($game_server as $chiave=>$elemento){
$sqlfile=realpath(".")."/cache/".$chiave."_".date('Y_m_d').".sql";
unlink($sqlfile);
}//per ogni regno

/*
error_reporting(E_ALL);

$_FILES=$HTTP_POST_FILES;

// RIPULIAMO I VARI CAMPI DEL MODULO
$Soggetto = "LostAge altri DB Backup ".date('d/m/Y');
$Mail = "server@lostage.it";
$Contenuto = "Backup altri db lostage";

$MailFromAddress = "Mail";

// ASSEGNIAMO A VARIABILI PIU' LEGGIBILI, LE PROPRIETA' DELL'ALLEGATO
$attach = $attachment;
$file_name = $prefix.date('Y_m_d').".tgz";
$file_type = filetype($attachment);
$file_size = filesize($attachment); 

// DELIMITATORE
$boundary = md5(uniqid(microtime()));

// APRIAMO L'ALLEGATO PER LEGGERLO E CODIFICARLO
$file = @fopen($attach, "r");
$contents = @fread($file, $file_size);
$encoded_attach = chunk_split(base64_encode($contents));
@fclose($file); 

// INTESTAZIONI DELLA MAIL
$mail_headers = '';
$mail_headers .= "MIME-version: 1.0\n";
$mail_headers .= "Content-type: multipart/mixed; boundary=\"$boundary\"";
$mail_headers .= "X-attachments: $file_name\n";
$mail_headers .= "From: $Mail\r\n"; 


// COSTRUIAMO IL CORPO DELLA MAIL
$mail_body = "Content-disposition: attachment; filename =\"$file_name\"\n\n";
$mail_body = "--$boundary\n";
$mail_body .= "Content-Type: text/plain; charset=us-ascii\n";
$mail_body .= "Content-Transfer-Encoding: 7bit\n\n";
$mail_body .= "Contenuto: $Contenuto\n\n";
$mail_body .= "Soggetto: $Soggetto\n\n";
$mail_body .= "--$boundary\n";
$mail_body .= "Content-type: $file_type; name=\"$file_name\"\n";
$mail_body .= "Content-Transfer-Encoding: base64\n";
$mail_body .= "$encoded_attach\n";
$mail_body .= "--$boundary--\n";

// INVIO DELLA MAIL
if(@mail("zigozago@gmail.com", $Soggetto, $mail_body, $mail_headers)) { // SE L'INVIO E' ANDATO A BUON FINE...

echo "<p>La mail è stata inoltrata con successo.</p>";

} else { // ALTRIMENTI...

echo "<p>Si sono verificati dei problemi nell'invio della mail.</p>"; 
}

unlink($attachment);
*/
?>