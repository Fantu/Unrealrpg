<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/it/lang_messaggi.php');
require('template/int_messaggi.php');
$id=(int)$_GET['id'];
?>
<script type="text/javascript">
function conteggio() {
	window.document.getElementById("caratteri").innerHTML=(500-window.document.getElementById("mymess").value.length);
}
</script>
<div align="center">
<?php
//cancello messaggi vecchi
$scaduto=strtotime("now")-172800;
$db->QueryMod("DELETE FROM messaggi WHERE userid='".$user['userid']."' AND letto='1' AND data<'".$scaduto."'");

switch($_GET['do']){
case "elim"://cancella msg singolo
$db->QueryMod("DELETE FROM messaggi WHERE id='".$id."'");
echo "<script language=\"javascript\">window.location.href='game.php?act=messaggi'</script>";
exit();
break;
case "canc"://cancella mess selezionati
while($_POST['contatore']>0) {	
	$db->QueryMod("DELETE FROM messaggi WHERE id='".$_POST['messaggioid'.$_POST['contatore'].'']."'");
	$_POST['contatore']--;
}
redirect("Location: game.php?act=messaggi")
//header("Location: game.php?act=messaggi");
exit();
break;
case "dorisp":// invia risposta
	$errore="";	
	if(!$_POST['mymess'])
		$errore.=$lang['messaggi_error1']."<br />";
	if(!$_POST['messid'])
		$errore.=$lang['messaggi_error2']."<br />";
	if(strlen($_POST['mymess'])>500)
		$errore.=$lang['messaggi_error3']."<br />";				
	if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	echo $outputerrori;}
	else {
		$a=$db->QuerySelect("SELECT titolo,mittenteid FROM messaggi WHERE id='".$_POST['messid']."'");
		$titolo="RE: ".$a['titolo'];
		$_POST['mymess']=str_replace("'","&acute;",$_POST['mymess']);
		$_POST['mymess']=str_replace("\"","&quot;",$_POST['mymess']);		
		$_POST['mymess']=str_replace("<","&lt;",$_POST['mymess']);		
		$_POST['mymess']=str_replace(">","&gt;",$_POST['mymess']);
		$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$a['mittenteid']."','".$titolo."','".$_POST['mymess']."','".$user['userid']."','".$adesso."')");
		header("Location: game.php?act=messaggi");
		exit();		
	}
break;
case "doscrivi":// invia nuovo messaggio
	$errore="";
	if(!$_POST['mymess'])
		$errore.=$lang['messaggi_error1']."<br />";
	if(!$_POST['titolo'])
		$errore=$lang['messaggi_error4']."<br />";		
	if(!$_POST['achi'])
		$errore.=$lang['messaggi_error2']."<br />";
	if(strlen($_POST['mymess'])>500)
		$errore.=$lang['messaggi_error3']."<br />";	
	if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	echo $outputerrori;}
	else {	
		$_POST['titolo']=str_replace("'","&acute;",$_POST['titolo']);
		$_POST['titolo']=str_replace("\"","&quot;",$_POST['titolo']);		
		$_POST['titolo']=str_replace("<","&lt;",$_POST['titolo']);		
		$_POST['titolo']=str_replace(">","&gt;",$_POST['titolo']);	
		$_POST['mymess']=str_replace("'","&acute;",$_POST['mymess']);
		$_POST['mymess']=str_replace("\"","&quot;",$_POST['mymess']);		
		$_POST['mymess']=str_replace("<","&lt;",$_POST['mymess']);		
		$_POST['mymess']=str_replace(">","&gt;",$_POST['mymess']);
		$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$_POST['achi']."','".$_POST['titolo']."','".$_POST['mymess']."','".$user['userid']."','".$adesso."')");
		$db->QueryMod("DELETE FROM messaggi WHERE id='".$id."'");
		header("Location: game.php?act=messaggi");
	}
exit();
break;
case "risp":// scrivi risposta
?>
<form action="game.php?act=messaggi&amp;do=dorisp" method="post" name="formrisp">
<table width="505"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><?php echo $lang['istruzioni_scrivi_msg']; ?></td>
  </tr>
  <tr>
    <td><textarea name="mymess" cols="45" rows="4" id="mymess" onkeydown="conteggio()"></textarea>      
	  <br /><?php echo $lang['caratteri_disponibili']; ?><div id="caratteri" name="caratteri">500</div>
  </td></tr>
  <tr>
    <td><div align="center">
      <?php echo "<input type=\"hidden\" name=\"messid\" value=\"".$id."\" />"; ?>
      <input type="submit" name="Submit" value="<?php echo $lang['invia_messaggio']; ?>" />
    </div></td>
  </tr>
</table>
</form>
<?php
break;
case "scrivi":// scrivi nuovo
?>
<form action="game.php?act=messaggi&amp;do=doscrivi" method="post" name="formrisp2">
<table width="505"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><?php echo $lang['istruzioni_scrivi_msg']; ?></td>
  </tr>
  <tr><td align="center"><strong><?php echo $lang['titolo']; ?></strong><br /><input name="titolo" type="text" /></td></tr>
  <tr>
    <td align="center"><strong><?php echo $lang['messaggio']; ?></strong><br /><textarea name="mymess" cols="45" rows="4" id="mymess" onkeydown="conteggio()"></textarea>
	<br /><?php echo $lang['caratteri_disponibili']; ?><div id="caratteri" name="caratteri">500</div></td></tr>
  <tr>
    <td><div align="center">
      <?php echo "<input type=\"hidden\" name=\"achi\" value=\"".$id."\" />"; ?>
      <input type="submit" name="Submit" value="<?php echo $lang['invia_messaggio']; ?>" />
    </div></td>
  </tr>
</table>
</form>
<?php
break;
default:// visualizza messaggi	
$a=$db->QueryCiclo("SELECT * FROM messaggi WHERE userid='".$user['userid']."' ORDER BY id desc");
	$esistenza=mysql_num_rows($a);
	if (!$esistenza){
		echo "Non c'&egrave; nessun messaggio";}
	else{
	echo "<form action=\"game.php?act=messaggi&amp;do=canc\" method=\"post\" name=\"canctutt\">";
	$i=0;
	while($mess=$db->QueryCicloResult($a)) {
		$i++;
		if ($mess['mittenteid']!=0)
		$mit=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$mess['mittenteid']."'");

	?>
	<table width="505"  border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="5%"><?php echo "<input name=\"messaggioid".$i."\" type=\"checkbox\" id=\"messaggioid".$i."\" value=\"".$mess['id']."\" />"; ?></td>
		<td width="95%"><div align="center"><?php echo $lang['messaggio_da']; if ($mess['mittenteid']==0){echo "Sistema";}else{echo $mit['username'];} echo $lang['in_data']; echo date("d/m/y - H:i",$mess['data']); ?> </div></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><?php echo "<strong><span>".$mess['titolo']."</span></strong><br />".$mess['testo']; ?></td>
	  </tr>
	  <tr>
		<td colspan="2" align="right"> 
		<?php 
		if($mess['mittenteid']==0)
			echo "[ <a href=\"game.php?act=messaggi&amp;do=elim&amp;id=".$mess['id']."\">".$lang['elimina']."</a> ]";
		else
			echo "[ <a href=\"game.php?act=messaggi&amp;do=risp&amp;id=".$mess['id']."\">".$lang['rispondi']."</a> ] - [ <a href=\"game.php?act=messaggi&amp;do=elim&amp;id=".$mess['id']."\">".$lang['elimina']."</a> ]"; ?></td>
	  </tr>
	</table>
	<?php
	}
	echo "<br /><table width=\"505\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tr>"
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input name=\"asd\" type=\"submit\" value=\"".$lang['cancella_selezionati']."\" /></td>"
	."</tr></table></form>";
	$db->QueryMod("UPDATE messaggi SET letto=1 WHERE userid='".$user['userid']."'");
	}
break;
}
?>
</div>