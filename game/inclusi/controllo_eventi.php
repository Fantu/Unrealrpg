<?php
require_once('inclusi/funzioni_eventi.php');
//controllo ultimo evento
//$evfiniti=$db->QueryCiclo("SELECT * FROM eventi WHERE userid='".$user['userid']."' LIMIT 1");
$evfiniti=$db->QueryCiclo("SELECT * FROM eventi WHERE (('datainizio'+'secondi')<'".$adesso."') LIMIT 1");
while($evento=$db->QueryCicloResult($evfiniti)) {
//if( ($evento['datainizio']+$evento['secondi'])<$adesso ) {
		switch($evento['tipo']){
		case 1://lavori
			switch($evento['lavoro']){
			case 1://miniera nuova
			Completalavminnuova($evento['userid']);
			break;
			case 2://apprendista in laboratorio
			Completalavlabapp($evento['userid']);
			break;
			}	
		break;
		}
$db->QueryMod("DELETE FROM eventi WHERE id='".$evento['id']."'");
//} //fine se completato risolvo
}//fine controllo eventi
?>