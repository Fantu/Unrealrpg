<center><h2><?php echo $lang['Mercato']; ?></h2></center><br />
<?php
if($mostraogg==1){
	if ($seoggetti['id']==0){
	echo $nessunogg."<br />";
	}else{
	foreach($oggetti as $chiave=>$elemento){
	echo $oggetti[$chiave]."<br />";}
	}
}else{
foreach($catoggetti as $chiave=>$elemento){
echo $catoggetti[$chiave]."<br />";}	
}?>