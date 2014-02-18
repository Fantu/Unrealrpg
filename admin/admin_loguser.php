<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if(isset($_POST["view"])){
    $srv=(int)$_POST['db'];
    $idu=(int)$_POST['id'];
    $username=htmlspecialchars($_POST['username'],ENT_QUOTES);
    if(!isset($game_server[$srv]))
        $errore.=$lang['log_errore2']."<br />";
    if($idu<1 AND $username=="")
			$errore.=$lang['log_errore3']."<br />";
    if($_POST['dagiorno'] OR $_POST['agiorno']){
        $dagiorno=$_POST['dagiorno'];
        $agiorno=$_POST['agiorno'];
        if(!preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/",$dagiorno))
            $errore.=$lang['log_errore4']."<br />";
        if(!preg_match("/^([0-9]{2})-([0-9]{2})-([0-9]{4})$/",$agiorno))
            $errore.=$lang['log_errore5']."<br />";
    }//fine se giorni per range
    if(empty($errore)){
        $rtemp=(int)$_POST['rtemp'];
        $db->Setdb($srv);
        if($username!="")
            $where="username='".$username."'";
        else
            $where="userid='".$idu."'";
        $n=$db->QuerySelect("SELECT COUNT(userid) AS n FROM utenti WHERE ".$where);
        if($n['n']==0){
            $errore.=$lang['log_errore6']."<br />";
        }else{
            $u=$db->QuerySelect("SELECT userid,username FROM utenti WHERE ".$where." LIMIT 1");
            $n=$db->QuerySelect("SELECT COUNT(id) AS n FROM logutenti WHERE userid='".$u['userid']."'");
            if($n['n']==0)
                $errore.=$lang['log_errore9']."<br />";
        }
		if($dagiorno){
		$dagiorno=explode('-',$dagiorno);
		$agiorno=explode('-',$agiorno);
		if(!checkdate($dagiorno[1],$dagiorno[0],$dagiorno[2]))
			$errore.=$lang['log_errore7']."<br />";
		if(!checkdate($agiorno[1],$agiorno[0],$agiorno[2]))
			$errore.=$lang['log_errore8']."<br />";
		}//fine se giorni per range
		}
		if($errore){
				$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
		}else{
		require_once(LANG_PATH.$op['language'].'/lang_gamelog.php');
		require_once(LANG_PATH.$op['language'].'/lang_oggetti_nomi.php');
		$output=$u['username']." (".$srv.":".$u['userid'].")<br /><br />";
		if($dagiorno){
			$dagiorno=$dagiorno[1].'/'.$dagiorno[0].'/'.$dagiorno[2];
			$timedag=strtotime($dagiorno);
			$agiorno=$agiorno[1].'/'.$agiorno[0].'/'.$agiorno[2];
			$timeag=strtotime($agiorno);
			$where=" AND data>'".$timedag."' AND data<'".$timeag."'";
		}else{
			$sempre=0;
			switch($rtemp){
			case 2:
				$data=$adesso-172800;
				break;
			case 3:
				$data=$adesso-604800;
				break;
			case 4:
				$data=$adesso-2592000;
				break;
			case 5:
				$sempre=1;
				break;
			default:
				$data=$adesso-86400;
				break;
			}
			if($sempre==0)
			$where=" AND data>'".$data."'";
		}
			$l=$db->QueryCiclo("SELECT * FROM logutenti WHERE userid='".$u['userid']."'".$where." order by id desc");
			while($el=$db->QueryCicloResult($l)){
			$output.=date("d/m/y - H:i",$el['data'])."<br />";
			$output.=$log->VisualizzaMsgUtente($el['id'])."<br /><br />";
			$output.="-------------------------------------<br /><br />";
			}
		}//fine se non ci sono errori
}//fine visualizza log
?>
	<?php echo $outputerrori; ?><br />
	<?php echo $lang['visualizza_log_utenti']; ?><br /><br />
	<form action="" method="POST">
	<table width="90%" border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="40%" align="right"><?php echo $lang['Regno']; ?></td>
		<td width="60%">
			<select name="db">
			<option value="-1" selected="selected">-----</option>
				<?php
				foreach($game_server as $chiave=>$elemento){
					echo "<option value=\"$chiave\">$elemento</option>";
				}//per ogni regno presente
				?>
		  </select>
		</td>
	  </tr>
	  <tr>
		<td align="right">Id</td>
		<td><input type="text" name="id" size="3" maxlength="4" class="textmedium" /></td>
	  </tr>
      <tr>
		<td align="right">Username</td>
		<td><input type="text" name="username" size="25" maxlength="25" class="textmedium" <?php if($username!="") echo "value=\"".$username."\""; ?> /></td>
	  </tr>
	  <tr>
		<td align="right"><?php echo $lang['Range_temporale']; ?></td>
		<td><select name="rtemp">
				<option value="1" selected="selected"><?php echo $lang['Ultime_24_ore']; ?></option>
				<option value="2"><?php echo $lang['Ultime_48_ore']; ?></option>
				<option value="3"><?php echo $lang['Ultima_settimana']; ?></option>
				<option value="4"><?php echo $lang['Ultimo_mese']; ?></option>
				<option value="5"><?php echo $lang['Sempre']; ?></option>
		  </select></td>
	  </tr>
	  <tr>
		<td><?php echo $lang['Da']; ?></td>
		<td><input type="text" name="dagiorno" size="10" maxlength="10" class="textmedium" /></td>
		<td><?php echo $lang['A']; ?></td>
		<td><input type="text" name="agiorno" size="10" maxlength="10" class="textmedium" /></td>
	  </tr>
	  <tr>
		<td colspan="4"><?php echo $lang['desc_range_tempo']; ?></td>
	  </tr>
	  <tr>
	  	<td colspan="2" align="center"><input type="submit" name="view" value="<?php echo $lang['visualizza']; ?>" /></td>
	  </tr>
	</table>
	</form>
	<br><hr width="300" align="center" noshade="noshade" /><br>
	<?php echo $output; ?>
