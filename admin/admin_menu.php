<table width="100%" border="0" cellpadding="1" cellspacing="1">
<tr>
	<td class="tabmenutd"><a href="admin.php">- Home</a></td>
</tr>
<?php if($op['admin']==1){ ?>
<tr>
	<td class="tabmenutd"><a href="admin.php?loc=utente">- <?php echo $lang['gestione_utenti']; ?></a></td>
</tr>
<tr>
	<td class="tabmenutd"><a href="admin.php?loc=server">- <?php echo $lang['gestione_server']; ?></a></td>
</tr>
<?php } ?>
</table>