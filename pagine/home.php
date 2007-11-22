		<form action="game/login.php" method="post" name="formlogin">
		<table width="750" border="0">
		  <tr>
			<td>Username</td>
			<td><input name="login_username" type="text" maxlength="25" /></td>
			<td>Server</td>
			<td><select name="login_server">
			  <option value="999">Dev</option>
			</select></td>
		  </tr>
		  <tr>
			<td>Password</td>
			<td><input name="login_password" type="password" maxlength="25" /></td>
			<td><input name="Submit" type="submit" value="Login" /></td>
		  </tr>
		</table>
      	</form>
<table width="750" border="0" align="center">
  <tr>
    <td>
		<?php
		if( $_POST['step']=="registrazione" ) {
			$errore="";
			$server=$_POST['server'];
			if( $server!=none )
				$db->database = $server;
			else 
				$errore .= "- Non hai selezionato il continente";
			
			if( empty($errore) ) {
				$a=$db->QuerySelect("SELECT maxutenti AS Max, utenti AS Ut FROM config WHERE id='".$_POST['server']."'");	
				$a2=$db->QuerySelect("SELECT userid AS Us1 FROM utenti WHERE username='".$_POST['username']."'");
				if(!$_POST['username'])
					$errore.="- Non hai scritto il tuo username.<br>";
				if( strlen($_POST['username'])<3 )
					$errore.="- L'username deve essere almeno di 3 caratteri.<br>";					
				if($a2['Us1'])
					$errore.="- L'username che hai scelto è già stato preso.<br>";			
				if(!$_POST['password'])
					$errore.="- Non hai scritto la password.<br>";
				if(strlen($_POST['password'])<6)
					$errore.="- La password deve essere lunga almeno 6 caratteri.<br>";
				if(!$_POST['email'])
					$errore.="- Non hai scritto l'email.<br>";
				if(!eregi("^.+@.+\..{2,3}$",$_POST['email']))	
					$errore.="- L'email inserita non sembra essere corretta.<br>";	
				if($a['Ut']==$a['Max'])
					$errore.="- Questo server è al momento troppo affollato, scegline un altro.";
			}
			
			if($errore)
				echo "<span>".$errore."</span><br /><br />";
			else {
				$ora=strtotime("now");
				$ip=$_SERVER['REMOTE_ADDR'];
				$pass=md5($_POST['password']);
				$cod=md5($_POST['username']);
				$_POST['username']=strip_tags(str_replace("'","\'",$_POST['username']));
				$db->QueryMod("INSERT INTO utenti (username,password,codice,email,dataiscrizione,ipreg) VALUES ('".$_POST['username']."','".$pass."','".$cod."','".$_POST['email']."','".$ora."','".$ip."')");		
				$intestazione = "From: ".$game_name."<server@lostage.it>\r\n";
				$messaggio="Ciao,\nPer confermare l'iscrizione a ".$game_name." devi visitare il link sottostante:\n ".$game_link."/conferma.php?t=".$_POST['server']."&cod=$cod \n\nFinchè l'account non verrà confermato non potrai accedere al gioco.\nSaluti,\nLostgames Staff";
				mail($_POST['email'],"Conferma account ".$game_name,$messaggio,$intestazione);
				echo "<strong>Account creato con successo!!</strong><br>Prima di poter iniziare a giocare dovrai confermare l'iscrizione visitando il link contenuto nella mail che ti è stata inviata all'indirizzo di posta inserito.<br>Alcuni hanno problemi nella ricezione della mail di conferma, (in particolare hotmail) se non arriva mandate una mail a server@lostage.it con username e continente per la conferma.<br /><br />";
			}
		}	  
	  	?>
	    <span>Registrazione</span><br />
		<form action="index.php" method="post" name="formregistrazione">
		<input name="step" type="hidden" value="registrazione" />
	    <table border="0">
          <tr>
            <td>Username:</td>
            <td><input name="username" type="text" id="username" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Password:</td>
            <td><input name="password" type="password" id="password" maxlength="20" /></td>
          </tr>
          <tr>
            <td>Email:</td>
            <td><input name="email" type="text" id="email" maxlength="50" /></td>
          </tr>
          <tr>
            <td><div align="right">Server: </div></td>
            <td colspan="2">
			<select name="server" id="continente">
              <option value="none" selected="selected">--------</option>
              <option value="999">DEV</option>
            </select>
          </tr>
          <tr>
            <td><input name="Submit2" type="submit" value="Registrati" /></td>
          </tr>
        </table>
		</form>
		</div>
    </td>
  </tr>
</table>