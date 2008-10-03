<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('inclusi/funzioni_eventi.php');
require_once('inclusi/funzioni_combact.php');
function Controllaeventi($numeventi) {
global $db,$adesso;
$evfiniti=$db->QuerySelect("SELECT COUNT(id) AS id FROM eventi WHERE ((datainizio+secondi)<'".$adesso."') AND inuso='0'");
if ($evfiniti['id']>0){//controllo gli eventi finiti
$evfiniti=$db->QueryCiclo("SELECT * FROM eventi WHERE ((datainizio+secondi)<'".$adesso."') AND inuso='0' LIMIT ".$numeventi);
while($events=$db->QueryCicloResult($evfiniti)) {
$db->QueryMod("UPDATE `eventi` SET inuso='1' WHERE id='".$events['id']."'");
		switch($events['tipo']){
		case 1://lavori
			switch($events['lavoro']){
			case 1://miniera nuova
			Completalavminnuova($events['userid'],$events['ore']);
			break;
			case 2://apprendista in laboratorio
			Completalavlabapp($events['userid'],$events['ore']);
			break;
			case 3://miniera vecchia
			Completalavminvecchia($events['userid'],$events['oggid'],$events['ore']);
			break;
			case 4://apprendista fabbro
			Completalavfucapp($events['userid'],$events['ore']);
			break;
			case 5://alchimista in laboratorio
			Completalavlabalc($events['userid'],$events['oggid'],$events['ore']);
			break;
			case 6://studia in rocca
			Completaroccastudia($events['userid'],$events['oggid'],$events['ore']);
			break;
			case 7://fabbro in fucina
			Completalavfucfab($events['userid'],$events['oggid'],$events['ore'],$events['type']);
			break;
			case 8://fai pratica in rocca
			Completaroccapratica($events['userid'],$events['oggid'],$events['ore'],$events['type']);
			break;
			case 9://guardia
			Completaguardia($events['userid'],$events['ore']);
			break;
			}
		break;
		case 2://preghiera
		Completatempioprega($events['userid'],$events['ore']);
		break;
		case 3://resurrezione
		Completaresurrezione($events['userid']);
		break;
		case 4://sfida
		Completasfida($events['userid'],$events['id']);
		break;
		case 6://combattimento
		Battledo($events['battleid'],$events['turni']);
		break;
		case 7://dormire
		Completadormire($events['userid'],$events['ore']);
		break;
		case 8://quest
		Completaquest($events['userid'],$events['questid'],$events['secondi']);
		break;
		}
		//tipo 9 è a vuoto (ritorno da quest)
$db->QueryMod("DELETE FROM eventi WHERE id='".$events['id']."'");
}//fine controllo eventi
}//fine se ci sono eventi finiti
}//fine Controllaeventi
?>