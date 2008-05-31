<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if (isset($_POST["spedisci"])) {
$titolo=htmlspecialchars($_POST['titolo'],ENT_QUOTES);
$msg=htmlspecialchars($_POST['msg'],ENT_QUOTES);
if ($titolo==""){ echo "Manca il titolo"; 
} else {
	if ($msg==""){ echo "Manca il messaggio";
	} else {
	/*$db->database=2;
	$op=$db->QueryCiclo("SELECT * FROM phpbb_users WHERE user_active='1'");
	while($var=$db->QueryCicloResult($op)){
		$to=$var['user_email'];
		mail($to,$titolo,$msg,$head);
	}*/
	$to="fantonifabio@tiscali.it";
	mail($to,$titolo,$msg,$game_intestazione_mail);
	echo "Mail spedita";
	}}
}else{
/*echo $lang['crea_nuovo_utente'];*/
 ?>
<form action="" method="post">
Spedizione mail news agli utenti<br />
Titolo: <input type="text" name="titolo" /><br />
Messaggio: <input type="text" name="msg" /><br />
<input type="submit" name="spedisci" value="Spedisci" />
</form>
    <br/><br/>
<?php
}//mostra form
?>