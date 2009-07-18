<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if(isset($_POST["view"])){
	$srv=(int)$_POST['db'];
	if(!isset($game_server[$srv]) AND $srv!=1000)//se non è un server ne amministrazione
		$errore.=$lang['log_errore1']."<br />";
	if($errore){
		$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	}else{
		$rtemp=(int)$_POST['rtemp'];
		$db->Setdb($srv);
		$sempre=0;
		switch($rtemp){
			case 2:
				$data=$ora-172800;
				break;
			case 3:
				$data=$ora-604800;
				break;
			case 4:
				$data=$ora-2592000;
				break;
			case 5:
				$sempre=1;
				break;
			default:
				$data=$ora-86400;
				break;
		}
		if($sempre==0)
			$where.=" WHERE data>'".$data."'";
			$c=$db->QuerySelect("SELECT COUNT(id) AS n FROM logsistema".$where);
			if($c['n']!=0){
			$l=$db->QueryCiclo("SELECT * FROM logsistema".$where);
			while($el=$db->QueryCicloResult($l)){
				$output.=date("d/m/y - H:i",$el['data'])."<br />";
				$output.=$el['msg']."<br /><br />";
				$output.="-------------------------------------<br /><br />";
			}//fine per ogni log trovato
			}else{
			$output.=$lang['nessun_risultato'];
			}
	}//fine se non ci sono errori
}//fine visualizza log
?>
	<?php echo $outputerrori; ?><br />
	<?php echo $lang['visualizza_log_di_sistema']; ?><br /><br />
	<form action="" method="POST">
	<table width="90%" border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="40%" align="right">Database</td>
		<td width="60%">
			<select name="db">
			<option value="1000" selected="selected"><?php echo $lang['Amministrazione']; ?></option>
				<?php
				foreach($game_server as $chiave=>$elemento){
					echo "<option value=\"$chiave\">$elemento</option>";
				}//per ogni server presente
				?>
		  </select>
		</td>
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
	  	<td colspan="2" align="center"><input type="submit" name="view" value="<?php echo $lang['visualizza']; ?>" /></td>
	  </tr>
	</table>
	</form>
	<br><hr width="300" align="center" noshade="noshade" /><br>
	<?php echo $output; ?>