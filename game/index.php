<?php
$start_time = microtime();
$numquery=0;
require('inclusi/valori.php');
if($_COOKIE['urbglogin'])
	{$lg=explode("|||",$_COOKIE['urbglogin']);}else{header("Location: ../index.php?error=3"); exit(); }
$adesso=strtotime("now");
require('inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();
$language=htmlentities($lg[4]);
require('language/'.$language.'/lang_interno.php');

$esistenza=0;		
	foreach($game_server as $chiave=>$elemento){
	if ($chiave==$lg[3]){$esistenza=1;}
	}
if($esistenza==0){
	header("Location: ../index.php?error=3");
	exit();
} else{
	$db->database=(int)$lg[3];}

$check=$db->QuerySelect("SELECT chiuso FROM config");
if( $check['chiuso']==1 ) {
	header("Location: ../index.php?error=12");
	exit();
}
$int_security=$game_se_code;
require_once('inclusi/int_header.php');
?>
<table width="900" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="145" rowspan="2" valign="top"><?php include('inclusi/menu.php'); ?>
    </td>
    <td width="20">&nbsp;</td>
    <td width="715">&nbsp;</td>
    <td width="20">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td valign="top" align="center">
		<table width="715" border="0" align="right" cellpadding="1" cellspacing="1">
		  <tr>
			<td width="565" valign="top">
			<div id="contenuto">		
<?php
if ($user['personaggio']==0){
	require('creapersonaggio.php');	}
	else{
		$location=htmlspecialchars($_GET['loc'],ENT_QUOTES);
		if(!in_array($location.'.php',$game_location))
		$location="situazione";
		require($location.'.php');
		}
?>
			</div> 
			</td>
			<td width="30">&nbsp;</td>
			<td width="120" valign="top">
				<?php
				if($user['plus']==0) {
				?>
					<div id="ads" align="right">
						qui banner 120x600
					</div>
				<?php
				} //fine se plus attivo
				?>
			 </td>
		  </tr>
		</table>	
	</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php
require_once('template/int_footer.php');
?>