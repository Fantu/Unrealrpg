<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('inclusi/personaggio.php');
require('language/it/lang_creapersonaggio.php');
if (isset($_POST['crea'])){
$errore="";
$razza=(int)$_POST['razza'];
$classe=(int)$_POST['classe'];
$sesso=(int)$_POST['sesso'];
if ($razza=="none")
$errore .= $lang['creapg_error1']."<br />";
if ($classe=="none")
$errore .= $lang['creapg_error2']."<br />";

if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$db->QueryMod("UPDATE utenti SET personaggio='1' WHERE userid='".$user['userid']."'");
$db->QueryMod("INSERT INTO caratteristiche (userid,razza,classe,agilita,attfisico,attmagico,diffisica,difmagica,mana,manarimasto,recuperosalute,recuperoenergia,sesso) VALUES ('".$user['userid']."','".$razza."','".$classe."','".$classi['agilita'][$classe]."','".$classi['attfisico'][$classe]."','".$classi['attmagico'][$classe]."','".$classi['diffisica'][$classe]."','".$classi['difmagica'][$classe]."','".$classi['mana'][$classe]."','".$classi['mana'][$classe]."','".$adesso."','".$adesso."','".$sesso."')");
$db->QueryMod("INSERT INTO banca (userid,interessi) VALUES ('".$user['userid']."','".$adesso."')");
$db->QueryMod("INSERT INTO lavori (userid) VALUES ('".$user['userid']."')");
header("Location: game.php?act=situazione");
exit();
}

}
require('template/int_creapersonaggio.php');
?>