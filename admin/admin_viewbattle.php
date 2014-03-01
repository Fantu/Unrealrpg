<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
if(isset($_POST["view"])){
    $srv=(int)$_POST['db'];
    $idr=(int)$_POST['id'];
    if(!isset($game_server[$srv]))
        $errore.=$lang['log_errore2']."<br />";
    if($idr<1)
        $errore.=$lang['log_errore3']."<br />";
    if(empty($errore)){
        $filerep=INC_PATH."log/report/".$srv."/".$idr.".log";
        if(!file_exists($filerep))
            $errore.=$lang['log_errore11']."<br />";
    }
    if($errore){
        $outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
    }else{
        $server=$srv;
        $output=$lang['Regno']." ".$srv." - Report ".$idr."<br /><br />";
        $output.="-------------------------------------<br /><br />";
        ob_start();
        include $filerep;
        $report=ob_get_contents();
        ob_end_clean();
        $output.="<table width=\"500\" align=\"center\">".$report."</table>";
    }
}// end view battle report
?>
	<?php echo $outputerrori; ?><br />
	<?php echo $lang['show_battle_report']; ?><br /><br />
	<form action="" method="POST">
	<table width="90%" border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="40%" align="right"><?php echo $lang['Regno']; ?></td>
		<td width="60%">
			<select name="db">
			<option value="-1" <?php if(!isset($server)) echo "selected=\"selected\""; ?> >-----</option>
				<?php
				foreach($game_server as $chiave=>$elemento){
					echo "<option value=\"$chiave\" ";
                    if($server==$chiave)
                        echo "selected=\"selected\"";
                    echo " >".$elemento."</option>";
				}//per ogni regno presente
				?>
		  </select>
		</td>
	  </tr>
	  <tr>
		<td align="right">Id</td>
		<td><input type="text" name="id" size="10" maxlength="10" class="textmedium" /></td>
	  </tr>
	  <tr>
	  	<td colspan="2" align="center"><input type="submit" name="view" value="<?php echo $lang['visualizza']; ?>" /></td>
	  </tr>
	</table>
	</form>
	<br><hr width="300" align="center" noshade="noshade" /><br>
	<?php echo $output; ?>
