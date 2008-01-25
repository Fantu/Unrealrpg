<center><h2><?php echo $lang['Mercato']; ?></h2></center><br />
<?php
if($mostraogg==1){
	if ($seoggetti['id']==0){
	echo $nessunogg."<br />";
	}else{ ?>
	<table border="0">
	<tr><td><?php echo $lang['Nome']; ?></td></tr><tr><td><?php echo $lang['Costo']; ?></td></tr>
	<?php foreach($oggetti['nome'] as $chiave=>$elemento){?>
	<tr><td><?php echo $oggetti['nome'][$chiave]; ?></td></tr><tr><td><?php echo $oggetti['costo'][$chiave]; ?></td></tr>
	<?php }/*fine ogni oggetto*/ ?>
	</table>
	<?php }//fine mostra oggetti
}else{
foreach($catoggetti as $chiave=>$elemento){
echo $catoggetti[$chiave]."<br />";}
}?>