<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');
require_once('inclusi/funzioni_combact.php');
?>
<script type="text/javascript">
function conteggio() {
	var caso=foltreconfine.selectedIndex.text;
	switch (caso){
	case 1:
	var tempo=1;
	break;
	default:
	var tempo=0;
	break;
		}
	window.document.getElementById("tempo").innerHTML=(tempo);
}
</script>
<?php
if (isset($_POST['parti'])){
$direzione=(int)$_POST['direzione'];
$errore="";
if ($eventi['id']>0)
$errore.=$lang['global_errore1'];
if ((100/$usercar['salute']*$usercar['saluteattuale'])<40 OR (100/$usercar['energiamax']*$usercar['energia'])<40)
$errore.=$lang['quest_error1'];
$expinc=1+floor($usercar['livello']/2);
if ($usercar['exp']>=$expinc*(120*$usercar['livello']))
$errore.=$lang['quest_error2'];
if ($direzione!=1)
$errore.=$lang['quest_error3'];
if($errore){
	$outputerrori="<span>".$lang['outputerroriquest']."</span><br /><span>".$errore."</span><br /><br />";}
else {
$pq=$db->QueryCiclo("SELECT id FROM pcpudata WHERE quest='1'");
while($ps=$db->QueryCicloResult($pq)) {	
$prs[]=$ps['id'];
}
shuffle($prs);
$pcpuid=$prs[0];
Startcombact($user['userid'],$pcpuid,$user['server'],1);
echo "<script language=\"javascript\">window.location.href='index.php?loc=combact'</script>";
exit();
}//se nessun errore
}//fine parti

require('template/int_confini.php');
?>