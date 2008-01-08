<script type="text/javascript" language="javascript">
function cambiaclasse(id,newClass) {
	var identity=document.getElementById(id);
	identity.className=newClass;
}
</script>
<div id="menu">
<table width="122"  border="1" cellspacing="1" cellpadding="1" class="tabmenu">		  
	<tr>
    <td class="tabmenutd" id="menu1" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=situazione"><?php echo $lang['Situazione']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu2" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=banca"><?php echo $lang['Banca']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu3" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=miniera"><?php echo $lang['Miniera']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu4" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=messaggi"><?php echo $lang['Messaggi']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu5" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=utenti"><?php echo $lang['Lista_utenti']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu6" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=guida"><?php echo $lang['Guida']; ?></a></div></td>
	</tr>				
	<tr>
    <td class="tabmenutd" id="menu7" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=changelog"><?php echo $lang['Changelog']; ?></a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu8" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="http://www.lostgames.net/forum/forumdisplay.php?f=33" target="_blank">Forum</a></div></td>
	</tr>
	<tr>
    <td class="tabmenutd" id="menu9" onmouseover="cambiaclasse(this.id,'tabmenutd2')" onmouseout="cambiaclasse(this.id,'tabmenutd')"><div align="center"><a href="game.php?act=logout"><?php echo $lang['Logout']; ?></a></div></td>
	</tr>		
</table>
</div>