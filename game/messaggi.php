<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_messaggi.php');
require('template/int_messaggi.php');
$id=(int)$_GET['id'];

function Cancellamsg($id){
global $db,$user;
$m=$db->QuerySelect("SELECT count(id) AS n FROM messaggi WHERE id='".$id."'");
if($m['n']>0){
$m=$db->QuerySelect("SELECT userid FROM messaggi WHERE id='".$id."'");
if($m['userid']==$user['userid']){
$db->QueryMod("DELETE FROM messaggi WHERE id='".$id."'");
}//se è un proprio messaggio
}//se esiste
}//fine Cancellamsg

?>
<script type="text/javascript">
function cambiaseltuttimsg(formogg, imposta)
{
	for (var i =0; i < formogg.elements.length; i++)
	{formogg.elements[i].checked = imposta;}
}
function conteggio() {
	window.document.getElementById("caratteri").innerHTML=(<?php if($user['plus']==0) echo "500"; else echo "10000";?>-window.document.getElementById("mymess").value.length);
}
function Cambiavista(id) {
	var identity=document.getElementById(id);
	if(identity.className=='nascosto'){
	identity.className='visibile';
	}else{
	identity.className='nascosto';}
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
Cancellamsg($id);
echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
exit();
break;
case "canc"://cancella mess selezionati
$contatore=(int)$_POST['contatore'];
while($contatore>0){
	$msgid=(int)$_POST['messaggioid'.$contatore];
	Cancellamsg($msgid);
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
	$msgid=(int)$_POST['messid'];
	if($errore==""){
	$m=$db->QuerySelect("SELECT count(id) AS n FROM messaggi WHERE id='".$msgid."'");
	if($m['n']==0)
	$errore.=$lang['messaggi_error7']."<br />";
	}
	if($errore){
	$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
	echo $outputerrori;}
	else {
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
$errore="";
$m=$db->QuerySelect("SELECT count(id) AS n FROM messaggi WHERE id='".$id."'");
if($m['n']==0)
$errore.=$lang['messaggi_error7']."<br />";
if($errore){
$outputerrori="<span>".$lang['outputerrori']."</span><br /><span>".$errore."</span><br /><br />";
echo $outputerrori;}
else {
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
    <td><?php $msgorig=$db->QuerySelect("SELECT * FROM messaggi WHERE id='".$id."' LIMIT 1");
    echo $lang['msg_orig']."<br/>";
    echo $msgorig['testo'];
    ?>
  </td></tr>
</table>
</form>
<?php
}//se messaggio a cui rispondere esiste
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
	$a=$db->QueryCiclo("SELECT * FROM messaggi WHERE userid='".$user['userid']."' ORDER BY id desc LIMIT 50");
	while($mess=$db->QueryCicloResult($a)){
	$cachemsg[]=$mess;
	}//per ogni messaggio
	
	function Visualizzacategoria($cachemsg,$letti,$nomecat,$num){
	global $db,$lang,$user;
	if($cachemsg!=0)
	$nummsg=count($cachemsg);
	else
	$nummsg=0;
	if($letti>0)
	$conti.=$letti." ".$lang['nuovi']." - ";
	$conti.=$nummsg." ".$lang['totali'];
	echo "<a href=\"javascript:;\" onclick=\"Cambiavista('cat".$num."')\">".$nomecat." (".$conti.")</a>";
	echo "<div id=\"cat".$num."\" class=\"nascosto\">";
	if($cachemsg!=0){
	echo "<form action=\"index.php?loc=messaggi&amp;do=canc\" method=\"post\" name=\"canctutt".$num."\">";
	$i=100*$num;
	foreach($cachemsg as $chiave=>$mc){
		$i++;
		if($mc['mittenteid']!=0)
		$mit=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$mc['mittenteid']."'");
	?>
	<table width="505"  border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="5%"><?php echo "<input name=\"messaggioid".$i."\" type=\"checkbox\" id=\"messaggioid".$i."\" value=\"".$mc['id']."\" />"; ?></td>
		<td width="95%"><div align="center"><?php echo $lang['messaggio_da']; if ($mc['mittenteid']==0){echo $lang['sistema'];}else{echo $mit['username'];} echo " "; echo date($lang['dataora'],$mc['data']); ?> </div></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><?php echo "<strong><span>".$mc['titolo']."</span></strong><br />".$mc['testo']; ?></td>
	  </tr>
	  <tr>
		<td colspan="2" align="right">
		<?php
		if($mc['mittenteid']==0)
			echo "[ <a href=\"index.php?loc=messaggi&amp;do=elim&amp;id=".$mc['id']."\">".$lang['elimina']."</a> ]";
		else
			echo "[ <a href=\"index.php?loc=messaggi&amp;do=risp&amp;id=".$mc['id']."\">".$lang['rispondi']."</a> ] - [ <a href=\"index.php?loc=messaggi&amp;do=elim&amp;id=".$mc['id']."\">".$lang['elimina']."</a> ]"; ?></td>
	  </tr>
	</table>
	<?php
	}
	echo "<br /><table width=\"505\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tr>"
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input type=\"checkbox\" name=\"tuttimsg\" id=\"selezionatutti".$num."\" onclick=\"cambiaseltuttimsg(this.form, this.form.tuttimsg.checked);\" /> ".$lang['sel_desel_tutti']." <input name=\"asd\" type=\"submit\" value=\"".$lang['cancella_selezionati']."\" /></td>"
	."</tr></table></form>";
	//echo "</div>";
	}else{echo $lang['nessun_messaggio']."<br />";}
	echo "</div><br /><br /><br />";
	}//fine Visualizzacategoria
	$letti=0;
	foreach($cachemsg as $chiave=>$mc){
	if($mc['letto']==0)
	$letti++;
	if($mc['mittenteid']!=0)
	$msgutenti[]=$mc;
	}//per ogni msg
	if(!$msgutenti){$msgutenti=0;}
	Visualizzacategoria($msgutenti,$letti,$lang['messaggi_dagli utenti'],1);
	$letti=0;
	foreach($cachemsg as $chiave=>$mc){
	if($mc['letto']==0)
	$letti++;
	if($mc['mittenteid']==0)
	$msgsistema[]=$mc;
	}//per ogni msg
	if(!$msgsistema){$msgsistema=0;}
	Visualizzacategoria($msgsistema,$letti,$lang['messaggi_dal_sistema'],2);
	
	$db->QueryMod("UPDATE messaggi SET letto=1 WHERE userid='".$user['userid']."'");
	}else{echo $lang['nessun_messaggio'];}
break;
}
?>
</div>