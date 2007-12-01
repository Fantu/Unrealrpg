<?php
function esistenza_array ($array,$valore) {
	$esistenza="0";		
	foreach($array as $elemento){
	if ($elemento==$valore){$esistenza="1";}
	}
return $esistenza;
}
?>