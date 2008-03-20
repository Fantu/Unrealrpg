<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	echo $lang['Accesso_negato'];
}
if (isset($_POST["invio"])) {
	$user=htmlspecialchars($_POST['user'],ENT_QUOTES);
	$pass=htmlspecialchars($_POST['passw'],ENT_QUOTES);
	$pass=md5($pass);
	$email=htmlspecialchars($_POST['email'],ENT_QUOTES);
$op=$db->QuerySelect("SELECT COUNT(id) AS num FROM utenti WHERE username='".$user."'");
if($op['num']>0){
	echo $lang['Username_esistente'];}
	else{
		$db->QueryMod("INSERT INTO utenti (username,password,email) VALUES ('".$user."','".$pass."','".$email."')");
		echo $lang['Utente_creato'];
	}
}else{
 ?>
    <?php echo $lang['crea_nuovo_utente']; ?>:<br/><br/>
 	<form method="post" action="" name="trova">
      USERNAME
      <input type="text" name="user" /><br/>
      PASSWORD
      <input type="text" name="passw" /><br/>
      EMAIL
      <input type="text" name="email" /><br/>
      <input type="submit" value="crea" name="invio" />
    </form>
    <br/><br/>
<?php
}//mostra form
?>