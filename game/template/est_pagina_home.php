<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<span><?php echo $lang['Login']; ?></span><br />
		<form action="game/login.php" method="post" name="formlogin">
		<table width="750" border="0">
		  <tr>
			<td><?php echo $lang['Username']; ?></td>
			<td><input name="login_username" type="text" maxlength="25" /></td>
			<td><?php echo $lang['Server']; ?></td>
			<td><select name="login_server">
			<?php foreach($game_server as $chiave=>$elemento){
				if($language==$game_server_lang[$chiave])
			  	echo "<option value=\"$chiave\">$elemento</option>";} ?>
			</select></td>
		  </tr>
		  <tr>
			<td><?php echo $lang['Password']; ?></td>
			<td><input name="login_password" type="password" maxlength="25" /></td>
			<td><input name="Submit" type="submit" value="<?php echo $lang['Entra']; ?>" /></td>
		  </tr>
		</table>
      	</form>
<br /><br />
<table width="750" border="0" align="center">
  <tr>
    <td>
    	<?php echo $outputreg; ?>
	    <span><?php echo $lang['Registrazione']; ?></span><br />
		<form action="" method="post" name="formregistrazione">
		<input name="step" type="hidden" value="registrazione" />
	    <table border="0">
          <tr>
            <td><?php echo $lang['Username']; ?></td>
            <td><input name="username" type="text" id="username" maxlength="20" /></td>
          </tr>
          <tr>
            <td><?php echo $lang['Password']; ?></td>
            <td><input name="password" type="password" id="password" maxlength="20" /></td>
          </tr>
          <tr>
            <td><?php echo $lang['Email']; ?></td>
            <td><input name="email" type="text" id="email" maxlength="50" /></td>
          </tr>
          <tr>
            <td><?php echo $lang['Server']; ?></td>
            <td>
			<select name="server" id="server">
              <option value="-1" selected="selected">--------</option>
              <?php foreach($game_server as $chiave=>$elemento){
	          if($language==$game_server_lang[$chiave])
			  echo "<option value=\"$chiave\">$elemento</option>";} ?>
            </select></td>
          </tr>
          <tr>
            <td><input name="Submit2" type="submit" value="<?php echo $lang['Registrati']; ?>" /></td>
          </tr>
        </table>
		</form>
    </td>
  </tr>
</table>
<br /><br />
<?php echo $lang['Informazioni_sui_server']; ?>
<table width="750" border="0" align="center">
<tr>
<td><?php echo $lang['Nome']; ?></td><td><?php echo $lang['Utenti_registrati']; ?></td><td><?php echo $lang['Ultima_settimana']; ?></td><td><?php echo $lang['Utenti_online']; ?></td><td><?php echo $lang['Ultimo_giorno']; ?></td>
</tr>
<?php foreach($game_server as $chiave=>$elemento){ ?>
<tr>
<td><?php echo $infoserver['nome'][$chiave]; ?></td><td><?php echo $infoserver['utenti'][$chiave]; ?></td><td><?php echo $infoserver['utentilw'][$chiave]; ?></td><td><?php echo $infoserver['online'][$chiave]; ?></td><td><?php echo $infoserver['online24'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni server*/ ?>
</table>