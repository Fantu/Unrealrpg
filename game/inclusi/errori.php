<?php
if($_GET['error']==1)
	$msg="Login errato!\\nUsername e/o password non corretti.";
else if($_GET['error']==2)
	$msg="Login impossibile!\\nQuesto account non è ancora stato confermato.";	
else if($_GET['error']==3)
	$msg="Tempo limite scaduto!\\nNuovo login necessario.";
else if($_GET['error']==4)
	$msg="Accesso negato!\\nHai tentato di entrare in una pagina riservata agli utenti loggati.";
else if($_GET['error']==5)
	$msg="Impossibile confermare questo account!\\nLink errato, controlla e riprova.";
else if($_GET['error']==6)
	$msg="Impossibile continuare!\\nQuesto account è già stato confermato.";	
else if($_GET['error']==7)
	$msg="Account confermato!\\nAdesso puoi loggarti e cominciare a giocare.";
else if($_GET['error']==8)
	$msg="Multi-account individuato!\\nSe vuoi accedere a Lostage con un secondo account, specificalo nelle opzioni.";	
else if($_GET['error']==9)
	$msg="Spiacente, ma dalla tua ultima operazione non puoi effettuare più di un login ogni 40 minuti.";	
else if($_GET['error']==10)
	$msg="Il tuo account è ora inutilizzabile e verrà a breve cancellato dal sistema.";		
else if($_GET['error']==11) {
	if($_GET['t']>0) {
		$fino=" fino al ".date("d/m/y H:i",$_GET['t']);
	}
	$msg="Il tuo account è stato momentaneamente bannato".$fino."!\\nPer sapere il motivo del bann ed evitare futuri intoppi, consulta il forum o contatta un admin.";
}
else if($_GET['error']==12)
	$msg="Continente momentaneamente chiuso per manutenzione. Riprova più tardi. Grazie.";	
else if($_GET['error']==13)
	$msg="Trovata irregolarità!\\nSembra che da questo pc si sia loggato qualcuno oltre te, e non è specificato nelle opzioni di multi-account.";
else if($_GET['error']==14)
	$msg="Il tuo account verrà cancellato tra 24 ore.";
else if($_GET['error']==15)
	$msg="Outlaw è stato resettato.\\nVerrà riattivato a breve.";
else if($_GET['error']==16)
	$msg="Link error.\\nPer favore segui i link del gioco per accedere alle varie sezioni.";	
else if($_GET['error']==17)
	$msg="Controlli interni non superati.\\nHai forse qualche estensione di FireFox che modifica il regolare funzionamento del browser?";
else if($_GET['error']==18)
	$msg="Se hai salvato l'indirizzo durante la registrazione sostituiscilo con quello principale: www.lostage.it";		
?>