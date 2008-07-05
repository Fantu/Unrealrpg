<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_messaggi.php');
require('template/int_messaggi.php');
$id=(int)$_GET['id'];
?>
<script type="text/javascript">
function cambiaseltuttimsg(formogg, imposta)
{
	for (var i =0; i < formogg.elements.length; i++)
	{
	var elemento = formogg.elements[i];
	elemento.checked = imposta;
	}
}
function conteggio() {
	window.document.getElementById("caratteri").innerHTML=(<?php if($user['plus']==0) echo "500"; else echo "10000";?>-window.document.getElementById("mymess").value.length);
}
</script>
<div align="center">
<?php
//cancello messaggi vecchi
if($user['plus']==0)
	$scaduto=strtotime("now")-172800;
else
	$scaduto=strtotime("now")-432000;
$db->QueryMod("DELETE FROM messaggi WHERE userid='".$user['userid']."' AND letto='1' AND data<'".$scaduto."'");

switch($_GET['do']){
case "elim"://cancella msg singolo
$db->QueryMod("DELETE FROM messaggi WHERE id='".$id."'");
echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
exit();
break;
case "canc"://cancella mess selezionati
$contatore=(int)$_POST['contatore'];
while($contatore>0){
	$msgid=(int)$_POST['messaggioid'.$contatore];
	$db->QueryMod("DELETE FROM messaggi WHERE id='".$msgid."'");
	$contatore--;
}
echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
exit();
break;
case "dorisp":// invia risposta
	$errore="";	
	if(!$_POST['mymess'])
		$errore.=$lang['messaggi_error1']."<br />";
	if(!$_POST['messid'])
		$errore.=$lang['messaggi_error2']."<br />";
	if($user['plus']==0 && strlen($_POST['mymess'])>500)
		$errore.=$lang['messaggi_error3']."<br />";
	if($user['plus']>0 && strlen($_POST['mymess'])>10000)
		$errore.=$lang['messaggi_error5']."<br />";					
	if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	echo $outputerrori;}
	else {
		$msgid=(int)$_POST['messid'];
		$a=$db->QuerySelect("SELECT titolo,mittenteid FROM messaggi WHERE id='".$msgid."'");
		$titolo="RE: ".$a['titolo'];
		$messaggio=htmlspecialchars($_POST['mymess'],ENT_QUOTES);
		$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$a['mittenteid']."','".$titolo."','".$messaggio."','".$user['userid']."','".$adesso."')");
		echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
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
	if($user['plus']==0 && strlen($_POST['mymess'])>500)
		$errore.=$lang['messaggi_error3']."<br />";	
	if($user['plus']>0 && strlen($_POST['mymess'])>10000)
		$errore.=$lang['messaggi_error5']."<br />";
	$achi=(int)$_POST['achi'];
	if($errore==""){
	$u=$db->QuerySelect("SELECT count(userid) AS n FROM utenti WHERE userid='".$achi."'");
	if($u['n']==0)
		$errore.=$lang['messaggi_error6']."<br />";
	}
	if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	echo $outputerrori;}
	else {
		$titolo=htmlspecialchars($_POST['titolo'],ENT_QUOTES);
		$messaggio=htmlspecialchars($_POST['mymess'],ENT_QUOTES);
		$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$achi."','".$titolo."','".$messaggio."','".$user['userid']."','".$adesso."')");
		echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
	}
exit();
break;
case "risp":// scrivi risposta
?>
<form action="index.php?loc=messaggi&amp;do=dorisp" method="post" name="formrisp">
<table width="505"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><?php echo $lang['istruzioni_scrivi_msg']; ?></td>
  </tr>
  <tr>
    <td><textarea name="mymess" cols="45" rows="4" id="mymess" onkeyup="conteggio()" onmousemove="conteggio()"></textarea>      
	  <br /><?php echo $lang['caratteri_disponibili']; ?><div id="caratteri" name="caratteri"><?php if($user['plus']==0) echo "500"; else echo "10000";?></div>
  </td></tr>
  <tr>
    <td><div align="center">
      <?php echo "<input type=\"hidden\" name=\"messid\" value=\"".$id."\" />"; ?>
      <input type="submit" name="Submit" value="<?php echo $lang['invia_messaggio']; ?>" />
    </div></td>
  </tr>
  <tr>
    <td><?php $msgorig=$db->QuerySelect("SELECT * FROM messaggi WHERE id='".$id."'");
    echo $lang['msg_orig']."<br/>";
    echo $msgorig['testo'];
    ?>
  </td></tr>
</table>
</form>
<?php
break;
case "scrivi":// scrivi nuovo
?>
<form action="index.php?loc=messaggi&amp;do=doscrivi" method="post" name="formrisp2">
<table width="505"  border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><?php echo $lang['istruzioni_scrivi_msg']; ?></td>
  </tr>
  <tr><td align="center"><strong><?php echo $lang['titolo']; ?></strong><br /><input name="titolo" type="text" /></td></tr>
  <tr>
    <td align="center"><strong><?php echo $lang['messaggio']; ?></strong><br /><textarea name="mymess" cols="45" rows="4" id="mymess" onkeyup="conteggio()" onmousemove="conteggio()"></textarea>
	<br /><?php echo $lang['caratteri_disponibili']; ?><div id="caratteri" name="caratteri"><?php if($user['plus']==0) echo "500"; else echo "10000";?></div></td></tr>
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
$semsg=$db->QuerySelect("SELECT count(id) AS numero FROM messaggi WHERE userid='".$user['userid']."'");
	if($semsg['numero']>0){
	echo "<form action=\"index.php?loc=messaggi&amp;do=canc\" method=\"post\" name=\"canctutt\">";
	$i=0;
	$a=$db->QueryCiclo("SELECT * FROM messaggi WHERE userid='".$user['userid']."' ORDER BY id desc");
	while($mess=$db->QueryCicloResult($a)) {
		$i++;
		if ($mess['mittenteid']!=0)
		$mit=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$mess['mittenteid']."'");

	?>
	<table width="505"  border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="5%"><?php echo "<input name=\"messaggioid".$i."\" type=\"checkbox\" id=\"messaggioid".$i."\" value=\"".$mess['id']."\" />"; ?></td>
		<td width="95%"><div align="center"><?php echo $lang['messaggio_da']; if ($mess['mittenteid']==0){echo "Sistema";}else{echo $mit['username'];} echo " "; echo date($lang['dataora'],$mess['data']); ?> </div></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><?php echo "<strong><span>".$mess['titolo']."</span></strong><br />".$mess['testo']; ?></td>
	  </tr>
	  <tr>
		<td colspan="2" align="right"> 
		<?php 
		if($mess['mittenteid']==0)
			echo "[ <a href=\"index.php?loc=messaggi&amp;do=elim&amp;id=".$mess['id']."\">".$lang['elimina']."</a> ]";
		else
			echo "[ <a href=\"index.php?loc=messaggi&amp;do=risp&amp;id=".$mess['id']."\">".$lang['rispondi']."</a> ] - [ <a href=\"index.php?loc=messaggi&amp;do=elim&amp;id=".$mess['id']."\">".$lang['elimina']."</a> ]"; ?></td>
	  </tr>
	</table>
	<?php
	}
	echo "<br /><table width=\"505\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tr>"
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input type=\"checkbox\" name=\"tuttimsg\" id=\"selezionatutti\" onclick=\"cambiaseltuttimsg(this.form, this.form.tuttimsg.checked);\" /> ".$lang['sel_desel_tutti']." <input name=\"asd\" type=\"submit\" value=\"".$lang['cancella_selezionati']."\" /></td>"
	."</tr></table></form>";
	$db->QueryMod("UPDATE messaggi SET letto=1 WHERE userid='".$user['userid']."'");
	}else{echo $lang['nessun_messaggio'];}
break;
}
?>
</div>