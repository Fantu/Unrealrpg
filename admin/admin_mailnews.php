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
	$db->database=0;
	$n=0;
	$op=$db->QueryCiclo("SELECT email FROM utenti WHERE conferma='1' AND mailnews='1'");
	while($var=$db->QueryCicloResult($op)){
		$to=$var['email'];
		$email=new Email(0,$to,$titolo,$msg);
		$n++;
	}
	echo $n++." Mail spedite";
	}}
}else{
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