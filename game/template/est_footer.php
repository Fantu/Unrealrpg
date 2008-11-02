<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();}
echo $lang['Informazioni_sui_server']; ?>
<table width="750" border="0" align="center">
<tr>
<td><?php echo $lang['Nome']."</td><td>".$lang['Utenti_registrati']."</td><td>".$lang['Ultima_settimana']."</td><td>".$lang['Utenti_online']."</td><td>".$lang['Ultimo_giorno']; ?></td>
</tr>
<?php foreach($game_server as $chiave=>$elemento){ ?>
<tr>
<td><?php echo $infoserver['nome'][$chiave]."</td><td>".$infoserver['utenti'][$chiave]."</td><td>".$infoserver['utentilw'][$chiave]."</td><td>".$infoserver['online'][$chiave]."</td><td>".$infoserver['online24'][$chiave]; ?></td>
</tr>
<?php }/* fine per ogni server*/ ?>
</table>
<br /><br />
<?php echo sprintf($lang['altre_lingue'],$game_name); foreach($lingue as $chiave=>$elemento) echo $lingue[$chiave]; ?>
</td>
</tr>
</table>
<br /><br />
<div align="center">
<?php echo $game_name; ?> &copy; 2007 Powered by <a href="http://www.lostgames.net" target="_blank">Lostgames.net</a>
<br /><br />
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
	<img id="xhtml" src="game/template/immagini/xhtml_grigio.gif" alt="" border="0" onmouseover="CambiaImg('xhtml', true);" onmouseout="CambiaImg('xhtml', false);" />
</a>&nbsp;
<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
	<img id="css" src="game/template/immagini/css_grigio.gif" border="0" alt="" onmouseover="CambiaImg('css', true);" onmouseout="CambiaImg('css', false);" />
</a>
<a href="http://www.php.net" target="_blank">
	<img id="php" src="game/template/immagini/php_grigio.gif" alt="" border="0" onmouseover="CambiaImg('php', true);" onmouseout="CambiaImg('php', false);" />
</a>&nbsp;&nbsp;
<a href="http://www.mysql.com" target="_blank">
	<img id="mysql" src="game/template/immagini/mysql_grigio.gif" alt="" border="0" onmouseover="CambiaImg('mysql', true);" onmouseout="CambiaImg('mysql', false);" />
</a>&nbsp;&nbsp;<br /><br />
<p id="tempogenpag">
<?php echo $page_gen; ?>
</p><br />
<script type="text/javascript">
<!--
var uri = 'http://imp.tradedoubler.com/imp?type(js)pool(274958)a(1316148)' + new String (Math.random()).substring (2, 11);
document.write('<sc'+'ript type="text/javascript" src="'+uri+'" charset="ISO-8859-1"></sc'+'ript>');
//-->
</script>
</div>
</body>
</html>