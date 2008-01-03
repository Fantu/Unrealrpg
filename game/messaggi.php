<?php
require('template/int_messaggi.php');
?>
<script type="text/javascript">
function conteggio() {
	window.document.getElementById("caratteri").innerHTML="Caratteri disponibili "+(500-window.document.getElementById("mymess").value.length);
}
</script>
<div align="center">
<?php
if($_GET['do']=="elim") { //cancella mess singolo
	$db->QueryMod("DELETE FROM messaggi WHERE id='".$_GET['id']."'");
	echo "<script language=\"javascript\">window.location.href='game.php?act=messaggi'</script>";	
} else if($_GET['do']=="canc") { //cancella mess selezionati
	while($_POST['contatore']>0) {	
		$db->QueryMod("DELETE FROM messaggi WHERE id='".$_POST['messaggioid'.$_POST['contatore'].'']."'");
		$_POST['contatore']--;
	}
	echo "<script language=\"javascript\">window.location.href='game.php?act=messaggi'</script>";
}else { // inizia visualizza messaggi
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
		<td width="95%"><div align="center">Messaggio da: <?php if ($mess['mittenteid']==0){echo "Sistema";}else{echo $mit['username'];} ?> - in data: <?php echo date("d/m/y - H:i",$mess['data']); ?> </div></td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
		<td><?php echo "<strong><span>".$mess['titolo']."</span></strong><br />".$mess['testo']; ?></td>
	  </tr>
	  <tr>
		<td colspan="2" align="right"> 
		<?php 
		if($mess['mittenteid']==0)
			echo "[ <a href=\"game.php?act=messaggi&amp;do=elim&amp;id=".$mess['id']."\">Elimina</a> ]";
		else
			echo "[ <a href=\"game.php?act=messaggi&amp;do=risp&amp;id=".$mess['id']."\">Rispondi</a> ] - [ <a href=\"game.php?act=messaggi&amp;do=elim&amp;id=".$mess['id']."\">Elimina</a> ]"; ?></td>
	  </tr>
	</table>
	<?php
	}
	echo "<br /><table width=\"505\"  border=\"0\" cellspacing=\"2\" cellpadding=\"2\"><tr>"
    ."<td align=\"center\"><input name=\"contatore\" type=\"hidden\" value=\"".$i."\" /><input name=\"asd\" type=\"submit\" value=\"Cancella i selezionati\" /></td>"
	."</tr></table></form>";
	$db->QueryMod("UPDATE messaggi SET letto=1 WHERE userid='".$user['userid']."'");
	}
} // fine visualizza messaggi
?>
</div>