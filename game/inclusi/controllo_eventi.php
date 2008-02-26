<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('inclusi/funzioni_eventi.php');
function Controllaeventi($numeventi) {
global $db,$adesso;
$evfiniti=$db->QuerySelect("SELECT COUNT(*) AS id FROM eventi WHERE ((datainizio+secondi)<'".$adesso."')");
if ($evfiniti['id']>0){//controllo gli eventi finiti
$evfiniti=$db->QueryCiclo("SELECT * FROM eventi WHERE ((datainizio+secondi)<'".$adesso."') LIMIT ".$numeventi);
while($evento=$db->QueryCicloResult($evfiniti)) {
		switch($evento['tipo']){
		case 1://lavori
			switch($evento['lavoro']){
			case 1://miniera nuova
			Completalavminnuova($evento['userid'],$evento['ore']);
			break;
			case 2://apprendista in laboratorio
			Completalavlabapp($evento['userid'],$evento['ore']);
			break;
			case 3://miniera vecchia
			Completalavminvecchia($evento['userid']);
			break;
			case 4://apprendista fabbro
			Completalavfucapp($evento['userid'],$evento['ore']);
			break;
			case 5://alchimista in laboratorio
			Completalavlabalc($evento['userid'],$evento['oggid'],$evento['ore']);
			break;
			case 6://studia in rocca
			Completaroccastudia($evento['userid'],$evento['oggid'],$evento['ore']);
			break;
			}	
		break;
		case 2://preghiera
		Completatempioprega($evento['userid']);
		break;
		case 3://resurrezione
		Completaresurrezione($evento['userid']);
		break;
		}
$db->QueryMod("DELETE FROM eventi WHERE id='".$evento['id']."'");
}//fine controllo eventi
}//fine se ci sono eventi finiti
}//fine Controllaeventi
?>