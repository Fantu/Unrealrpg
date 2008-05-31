<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if (isset($_POST["spedisci"])) {
$titolo=htmlspecialchars($_POST['titolo'],ENT_QUOTES);
$msg=$_POST['msg'];
if ($titolo==""){ echo "Manca il titolo"; 
} else {
	if ($msg==""){ echo "Manca il messaggio";
	} else {
	$db->database=999;
	$op=$db->QueryCiclo("SELECT email FROM utenti WHERE conferma='1' AND mailnews='1'");
	while($var=$db->QueryCicloResult($op)){
		$to=$var['email'];
		mail($to,$titolo,$msg,$game_intestazione_mail);
	}*/
	/*$to="fantonifabio@tiscali.it";
	mail($to,$titolo,$msg,$game_intestazione_mail);*/
	echo "Mail spedita";
	}}
}else{
/*echo $lang['crea_nuovo_utente'];*/
 ?>
<form action="" method="post">
Spedizione mail news agli utenti<br />
Titolo: <input type="text" name="titolo" /><br />
Messaggio: <textarea name="msg" cols="45" rows="4"></textarea><br />
<input type="submit" name="spedisci" value="Spedisci" />
</form>
    <br/><br/>
<?php
}//mostra form
?>