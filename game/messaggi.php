<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require('language/'.$language.'/lang_messaggi.php');
require('template/int_messaggi.php');
$id=(int)$_GET['id'];
$tipo=(int)$_POST['tipo'];

function Cancellamsg($id){
global $db,$user,$tipo;
if($tipo!=2)
$tab="messaggi";
else
$tab="msginviati";
$m=$db->QuerySelect("SELECT count(id) AS n FROM ".$tab." WHERE id='".$id."'");
if($m['n']>0){
$m=$db->QuerySelect("SELECT userid FROM ".$tab." WHERE id='".$id."'");
if($m['userid']==$user['userid']){
$db->QueryMod("DELETE FROM ".$tab." WHERE id='".$id."'");
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
$db->QueryMod("DELETE FROM msginviati WHERE data<'".($adesso-172800)."'");// cancellazione di tutti i msg inviati del regno più vecchi di 2 giorni
switch($_GET['do']){
case "elim"://cancella msg singolo
Cancellamsg($id);
/*echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
exit();*/
break;
case "canc"://cancella mess selezionati
$contatore=(int)$_POST['contatore'];
$catp=(int)$_POST['catp'];
while($contatore>($catp*100)){
	$msgid=(int)$_POST['messaggioid'.$contatore];
	Cancellamsg($msgid);
	$contatore--;
}
/*echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
exit();*/
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
		if($user['plus']>0){$db->QueryMod("INSERT INTO msginviati (userid,titolo,testo,riceventeid,data) VALUES ('".$user['userid']."','".$titolo."','".$messaggio."','".$a['mittenteid']."','".$adesso."')");}
		/*echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
		exit();*/
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
		if($user['plus']>0){$db->QueryMod("INSERT INTO msginviati (userid,titolo,testo,riceventeid,data) VALUES ('".$user['userid']."','".$titolo."','".$messaggio."','".$achi."','".$adesso."')");}
		/*echo "<script language=\"javascript\">window.location.href='index.php?loc=messaggi'</script>";
		exit();*/
	}
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
}
// visualizza messaggi

	function Nomeutente($userid){
	global $db,$cacheun;
	if($cacheun[$userid]){
	$username=$cacheun[$userid];
	}else{
	$mit=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$userid."'");
	$username=$mit['username'];
	$cacheun[$userid]=$username;}
	return $username;
	}//fine Nomeutente

	$semsg=$db->QuerySelect("SELECT count(id) AS numero FROM messaggi WHERE userid='".$user['userid']."'");
	if($semsg['numero']>0){
	$a=$db->QueryCiclo("SELECT * FROM messaggi WHERE userid='".$user['userid']."' ORDER BY id desc LIMIT 50");
	while($mess=$db->QueryCicloResult($a)){
	$cachemsg[]=$mess;
	}//per ogni messaggio
	
	function Visualizzacategoria($cachemsg,$letti,$nomecat,$num){
	global $lang;
	if($cachemsg!=0)
	$nummsg=count($cachemsg);
	else
	$nummsg=0;
	if($letti>0)
	$conti.=$letti." ".$lang['nuovi']." - ";
	$conti.=$nummsg." ".$lang['totali'];
	echo "<a href=\"javascript:;\" onclick=\"Cambiavista('cat".$num."')\">".$nomecat." (".$conti.")</a>";
	echo "<div id=\"cat".$num."\" class=\"nascosto\"><br />";
	if($cachemsg!=0){
	echo "<form action=\"index.php?loc=messaggi&amp;do=canc\" method=\"post\" name=\"canctutt".$num."\">";
	$i=100*$num;
	foreach($cachemsg as $chiave=>$mc){
		$i++;
		if($mc['mittenteid']!=0)
		$mit=Nomeutente($mc['mittenteid']);
	?>
	<table width="505"  border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="5%"><?php echo "<input name=\"messaggioid".$i."\" type=\"checkbox\" id=\"messaggioid".$i."\" value=\"".$mc['id']."\" />"; ?></td>
		<td width="95%"><div align="center"><?php echo $lang['messaggio_da']; if ($mc['mittenteid']==0){echo $lang['sistema'];}else{echo $mit;} echo " "; echo date($lang['dataora'],$mc['data']); ?> </div></td>
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
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input name=\"catp\" type=\"hidden\" value=\"".$num."\" /><input name=\"tipo\" type=\"hidden\" value=\"1\" /><input type=\"checkbox\" name=\"tuttimsg\" id=\"selezionatutti".$num."\" onclick=\"cambiaseltuttimsg(this.form, this.form.tuttimsg.checked);\" /> ".$lang['sel_desel_tutti']." <input name=\"cms\" type=\"submit\" value=\"".$lang['cancella_selezionati']."\" /></td>"
	."</tr></table></form>";
	}else{echo $lang['nessun_messaggio']."<br />";}
	echo "</div><br /><br /><br />";
	}//fine Visualizzacategoria
	$letti=0;
	foreach($cachemsg as $chiave=>$mc){
	if($mc['mittenteid']!=0){
	if($mc['letto']==0)
	$letti++;
	$msgutenti[]=$mc;
	}
	}//per ogni msg
	if(!$msgutenti){$msgutenti=0;}
	Visualizzacategoria($msgutenti,$letti,$lang['messaggi_dagli utenti'],1);
	$letti=0;
	foreach($cachemsg as $chiave=>$mc){
	if($mc['mittenteid']==0){
	if($mc['letto']==0)
	$letti++;
	$msgsistema[]=$mc;
	}
	}//per ogni msg
	if(!$msgsistema){$msgsistema=0;}
	Visualizzacategoria($msgsistema,$letti,$lang['messaggi_dal_sistema'],2);
	
	if($user['plus']==0){$scaduto=$adesso-172800;}else{$scaduto=$adesso-432000;}
	$db->QueryMod("DELETE FROM messaggi WHERE userid='".$user['userid']."' AND letto='1' AND data<'".$scaduto."'");//cancello messaggi vecchi
	$db->QueryMod("UPDATE messaggi SET letto=1 WHERE userid='".$user['userid']."'");
	}else{echo $lang['nessun_messaggio']."<br /><br /><br />";}
	
	if($user['plus']>0){
	$semsg=$db->QuerySelect("SELECT count(id) AS numero FROM msginviati WHERE userid='".$user['userid']."'");
	if($semsg['numero']>0){
	$a=$db->QueryCiclo("SELECT * FROM msginviati WHERE userid='".$user['userid']."' ORDER BY id desc LIMIT 50");
	while($mess=$db->QueryCicloResult($a)){
	$cachemsgi[]=$mess;
	}//per ogni messaggio
	
	$num=9;
	$conti.=count($cachemsgi)." ".$lang['totali'];
	echo "<a href=\"javascript:;\" onclick=\"Cambiavista('cat".$num."')\">".$lang['messaggi_inviati']." (".$conti.")</a>";
	echo "<div id=\"cat".$num."\" class=\"nascosto\"><br />";
	echo "<form action=\"index.php?loc=messaggi&amp;do=canc\" method=\"post\" name=\"canctutt".$num."\">";
	$i=100*$num;
	foreach($cachemsgi as $chiave=>$mc){
		$i++;
		$ric=Nomeutente($mc['riceventeid']);
	?>
	<table width="505"  border="0" cellspacing="2" cellpadding="2">
	  <tr>
		<td width="5%"><?php echo "<input name=\"messaggioid".$i."\" type=\"checkbox\" id=\"messaggioid".$i."\" value=\"".$mc['id']."\" />"; ?></td>
		<td width="95%"><div align="center"><?php echo $lang['messaggio_inviato_a'].$ric." ".date($lang['dataora'],$mc['data']); ?> </div></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><?php echo "<strong><span>".$mc['titolo']."</span></strong><br />".$mc['testo']; ?></td>
	  </tr>
	</table>
	<?php
	}
	echo "<br /><table width=\"505\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tr>"
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input name=\"catp\" type=\"hidden\" value=\"".$num."\" /><input name=\"tipo\" type=\"hidden\" value=\"2\" /><input type=\"checkbox\" name=\"tuttimsg\" id=\"selezionatutti".$num."\" onclick=\"cambiaseltuttimsg(this.form, this.form.tuttimsg.checked);\" /> ".$lang['sel_desel_tutti']." <input name=\"cms\" type=\"submit\" value=\"".$lang['cancella_selezionati']."\" /></td>"
	."</tr></table></form>";
	echo "</div><br />";
	
	}else{//fine se ha msg inviati
	echo $lang['nessun_messaggio_inviato']."<br />";
	}//se nn ha msg inviati
	echo "<br /><br />";
	}//se ha il plus

?>
</div>