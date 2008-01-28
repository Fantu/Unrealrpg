<span>Login</span><br />
		<form action="game/login.php" method="post" name="formlogin">
		<table width="750" border="0">
		  <tr>
			<td>Username</td>
			<td><input name="login_username" type="text" maxlength="25" /></td>
			<td>Server</td>
			<td><select name="login_server">
			<?php foreach($game_server as $chiave=>$elemento)
			  echo "<option value=\"$chiave\">$elemento</option>"; ?>
			</select></td>
		  </tr>
		  <tr>
			<td>Password</td>
			<td><input name="login_password" type="password" maxlength="25" /></td>
			<td><input name="Submit" type="submit" value="Login" /></td>
		  </tr>
		</table>
      	</form>
<br /><br />
<table width="750" border="0" align="center">
  <tr>
    <td>
    	<?php echo $outputreg; ?>
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
			<select name="server" id="server">
              <option value="-1" selected="selected">--------</option>
              <?php foreach($game_server as $chiave=>$elemento)
			  echo "<option value=\"$chiave\">$elemento</option>"; ?>
            </select></td>
          </tr>
          <tr>
            <td><input name="Submit2" type="submit" value="Registrati" /></td>
          </tr>
        </table>
		</form>
    </td>
  </tr>
</table>
<br /><br />
Informazioni sui server:
<table width="750" border="0" align="center">
<tr>
<td>Nome</td><td>Utenti registrati</td><td>Utenti online</td><td>Ultimo giorno</td>
</tr>
<?php foreach($game_server as $chiave=>$elemento){ ?>
<tr>
<td><?php echo $infoserver['nome'][$chiave]; ?></td><td><?php echo $infoserver['utenti'][$chiave]; ?></td><td><?php echo $infoserver['online'][$chiave]; ?></td><td><?php echo $infoserver['online24'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni server*/ ?>
</table>