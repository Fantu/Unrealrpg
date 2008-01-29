<center><h2><?php echo $lang['Mercato']; ?></h2></center><br />
<br />
<?php echo $outputerrori; ?>
<br />
<br />
<div align="center">
<?php echo $linkindietro; ?>
<br />
<?php
if($mostraogg==1){
	if ($seoggetti['id']==0){
	echo $nessunogg."<br />";
	}else{ ?>
	<form action="" method="post" name="formcompra">
	<table align="center" border="1">
	<tr><td><?php echo $lang['Nome']; ?></td><td><?php echo $lang['Costo']; ?></td></tr>
	<?php foreach($oggetti['nome'] as $chiave=>$elemento){?>
	<tr><td><input type="radio" name="oggselect" value="<?php echo $oggetti['id'][$chiave]; ?>" /><?php echo $oggetti['nome'][$chiave]; ?></td><td><?php echo $oggetti['costo'][$chiave]; ?></td></tr>
	<?php }/*fine ogni oggetto*/ ?>
	</table>
	<br />
	<?php echo $lang['Quanti']; ?> <input name="quanti" type="text" maxlength="2" size="3" />
	<input type="submit" name="compra" value="<?php echo $lang['Compra']; ?>" />
	</form>
	<?php }//fine mostra oggetti
}else{
foreach($catoggetti as $chiave=>$elemento){
echo $catoggetti[$chiave]."<br />";}
}?>
</div>