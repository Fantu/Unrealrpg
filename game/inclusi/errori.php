<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$errore=(int)$_GET['error'];
switch($errore){
case 1:
$msg=$lang['ext_error1'];
break;
case 2:
$msg=$lang['ext_error2'];
break;
case 3:
$msg=$lang['ext_error3'];
break;
/*case 4:
$msg="Accesso negato!\\nHai tentato di entrare in una pagina riservata agli utenti loggati.";
break;*/
case 5:
$msg=$lang['ext_error5'];
break;
case 6:
$msg=$lang['ext_error6'];
break;
case 7:
$msg=$lang['ext_error7'];
break;
case 8:
$msg=$lang['ext_error8'];
break;
/*case 11:
$tempo=(int)$_GET['t'];
if($tempo>0) {
	$fino=" fino al ".date("d/m/y H:i",$tempo);
}
$msg="Il tuo account è stato momentaneamente bannato".$fino."!\\nPer sapere il motivo del bann ed evitare futuri intoppi, consulta il forum o contatta un admin.";
break;*/
case 12:
$msg=$lang['ext_error12'];
break;
case 13:
$msg=$lang['ext_error13'];
break;
case 14:
$msg=$lang['ext_error14'];
break;
case 16:
$msg=$lang['ext_error16'];
break;
}
if($msg)
	echo "<script language=\"javascript\"> alert('$msg'); </script>";