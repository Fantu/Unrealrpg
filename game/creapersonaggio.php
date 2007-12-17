<?php
require('inclusi/personaggio.php');
if (isset($_POST['crea'])){
$errore="";
$razza=$_POST['razza'];
$classe=$_POST['classe'];
if ($razza=="none")
$errore .= "- Non hai selezionato la razza<br />";
if ($classe=="none")
$errore .= "- Non hai selezionato la classe<br />";

if($errore){
	$outputerrori="<span>Si sono verificati i seguenti errori:</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE utenti SET personaggio='1' WHERE userid='".$user['userid']."'");
$db->QueryMod("INSERT INTO caratteristiche (userid,razza,classe,agilita,attfisico,attmagico,diffisica,difmagica,mana,recuperosalute,recuperoenergia) VALUES ('".$user['userid']."','".$razza."','".$classe."','".$classi['agilita'][$classe]."','".$classi['attfisico'][$classe]."','".$classi['attmagico'][$classe]."','".$classi['diffisica'][$classe]."','".$classi['difmagica'][$classe]."','".$classi['mana'][$classe]."','".$adesso."','".$adesso."')");
header("Location: game.php?act=situazione");
exit();
}

}
require('inclusi/personaggio.php');
require('template/int_creapersonaggio.php');
?>