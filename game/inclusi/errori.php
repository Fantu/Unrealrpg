<?php
$errore=(int)$_GET['error'];
switch($errore){
case 1:
$msg="Login errato!\\nUsername e/o password non corretti.";
break;
case 2:
$msg="Login impossibile!\\nQuesto account non &egrave; ancora stato confermato.";
break;
case 3:
$msg="Tempo limite scaduto!\\nNuovo login necessario.";
break;
case 4:
$msg="Accesso negato!\\nHai tentato di entrare in una pagina riservata agli utenti loggati.";
break;
case 5:
$msg="Impossibile confermare questo account!\\nLink errato, controlla e riprova.";
break;
case 6:
$msg="Impossibile continuare!\\nQuesto account &egrave; gi&agrave; stato confermato.";
break;
case 7:
$msg="Account confermato!\\nAdesso puoi loggarti e cominciare a giocare.";
break;
case 8:
$msg="Multi-account individuato!\\nSe vuoi accedere a Lostage con un secondo account, specificalo nelle opzioni.";
break;
case 10:
$msg="Il tuo account � ora inutilizzabile e verr� a breve cancellato dal sistema.";
break;
case 11:
$tempo=(int)$_GET['t'];
if($_GET['t']>0) {
	$fino=" fino al ".date("d/m/y H:i",$tempo);
}
$msg="Il tuo account � stato momentaneamente bannato".$fino."!\\nPer sapere il motivo del bann ed evitare futuri intoppi, consulta il forum o contatta un admin.";
break;
case 12:
$msg="Server momentaneamente chiuso per installazione aggiornamento o manutenzione. Riprova pi� tardi. Grazie.";
break;
case 13:
$msg="Trovata irregolarit�!\\nSembra che da questo pc si sia loggato qualcuno oltre te, e non � specificato nelle opzioni di multi-account.";
break;
case 14:
$msg="Il tuo account verr� cancellato tra 24 ore.";
break;
case 15:
$msg="Outlaw � stato resettato.\\nVerr� riattivato a breve.";
break;
case 16:
$msg="Link error.\\nPer favore segui i link del gioco per accedere alle varie sezioni.";
break;
case 17:
$msg="Controlli interni non superati.\\nHai forse qualche estensione di FireFox che modifica il regolare funzionamento del browser?";
break;
}