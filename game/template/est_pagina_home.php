<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
		
    	<?php echo $outputreg; ?>
	    <span><?php echo $lang['Registrazione']; ?></span><br />
		<form action="" method="post" name="fregistrazione">
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
            <td><?php echo $lang['Password']; ?></td>
            <td><input name="password2" type="password" id="password2" maxlength="20" /></td>
			<td><img src="game/template/immagini/help.png" title="<?php echo $lang['help1']; ?>" width="16" height="16" border="0" alt="" /></td>
          </tr>
          <tr>
            <td><?php echo $lang['Email']; ?></td>
            <td><input name="email" type="text" id="email" maxlength="50" /></td>
          </tr>
		  <tr>
            <td><?php echo $lang['Email']; ?></td>
            <td><input name="email2" type="text" id="email2" maxlength="50" /></td>
			<td><img src="game/template/immagini/help.png" title="<?php echo $lang['help2']; ?>" width="16" height="16" border="0" alt="" /></td>
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
            <td><?php echo $lang['Newsletter']; ?></td>
            <td>
			<select name="newsletter" id="newsletter">
              <option value="1" selected="selected"><?php echo $lang['attiva']; ?></option>
              <option value="2"><?php echo $lang['disattiva']; ?></option>
            </select></td>
          </tr>
          <tr>
            <td><input name="registra" type="submit" value="<?php echo $lang['Registrati']; ?>" /></td>
          </tr>
        </table>
		</form>
<br />
<?php echo $lang['Attivazione_manuale']; ?><br />
<?php echo $lang['Desc_attivazione_manuale']; ?><br />
<form action="" method="post" name="fattivazione">
<?php echo $lang['Username']; ?> <input name="usernameatt" type="text" id="usernameatt" maxlength="20" /><br />
<?php echo $lang['Codice']; ?> <input name="codice" type="text" id="codice" maxlength="32" /><br />
<?php echo $lang['Server']; ?> <select name="serveratt" id="serveratt">
<option value="-1" selected="selected">--------</option>
<?php foreach($game_server as $chiave=>$elemento){
if($language==$game_server_lang[$chiave])
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select><br />
<input name="attivazione" type="submit" value="<?php echo $lang['Attivazione_manuale']; ?>" />
</form>

<br /><br />