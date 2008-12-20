<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if(isset($_POST["spedisci"])){
$titolo=htmlspecialchars($_POST['titolo'],ENT_QUOTES);
$msg=$_POST['msg'];
if($titolo==""){ echo "Manca il titolo"; 
}elseif($msg==""){ echo "Manca il messaggio";
	}elseif(!$game_server[$_POST['server']]){echo $lang['regno_errato'];}else{
	$db->database=$_POST['server'];
	$n=0;
	$op=$db->QueryCiclo("SELECT email FROM utenti WHERE conferma='1' AND mailnews='1'");
	while($var=$db->QueryCicloResult($op)){
		$to=$var['email'];
		$email=new Email(1,$to,$titolo,$msg);
		$n++;
	}
	echo $n++." Mail spedite";
	}
}else{
 ?>
<form action="" method="post">
Spedizione mail news agli utenti<br />
<?php echo $lang['Titolo']; ?>: <input type="text" name="titolo" /><br />
<?php echo $lang['Messaggio']; ?>: <textarea name="msg" cols="45" rows="4"></textarea><br />
<?php echo $lang['Regno']; ?>: <select name="server" id="server">
              <option value="-1" selected="selected">--------</option>
              <?php foreach($game_server as $chiave=>$elemento){
			  echo "<option value=\"$chiave\">$elemento ($game_server_lang[$chiave])</option>";} ?>
            </select><br />
<input type="submit" name="spedisci" value="Spedisci" />
</form>
<br/><br/>
<?php
}//mostra form
?>