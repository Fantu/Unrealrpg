<center><h2><?php echo $lang['Inventario']; ?></h2></center><br />
<?php if(!empty($nessunogg)){ echo $nessunogg."<br />";}else{
foreach($oggetti['nome'] as $chiave=>$elemento){
echo $oggetti['numero'][$chiave]." ".$oggetti['nome'][$chiave]."<br />";
}
}/*fine se ci sono oggetti*/ ?>