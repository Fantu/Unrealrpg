<?php
$start_time = microtime();
require('inclusi/valori.php');
require('language/it.php');
if($_COOKIE['urbglogin'])
	{$lg=explode("|||",$_COOKIE['urbglogin']);}else{header("Location: ../index.php?error=3");}
$adesso=strtotime("now");
require('inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();

$esistenza=0;		
	foreach($game_server as $chiave=>$elemento){
	if ($chiave==$lg[3]){$esistenza=1;}
	}
if($esistenza==0){
	header("Location: ../index.php?error=3");
	exit();
} else
	$db->database = $lg[3];

$check = $db->QuerySelect("SELECT chiuso FROM config");
if( $check['chiuso']==1 ) {
	header("Location: ../index.php?error=12");
	exit();
}
$int_security=$game_se_code;
require_once('inclusi/int_header.php');

if(!$user['userid'])
	echo "Accesso negato!<br>Hai tentato di entrare in una pagina riservata agli utenti loggati.";
else if($user['ipattuale']!=$_SERVER['REMOTE_ADDR'])
	echo "Accesso negato!<br>Il numero IP è cambiato dal momento del login.<br /><a href=\"../index.php\">Clicca qui</a> per tornare indietro e loggarti nuovamente.";	
else {
$interno="1";
if ($user['personaggio']==0){
	require('creapersonaggio.php');	}
	else{
?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="125" rowspan="2" valign="top"><?php include('inclusi/menu.php'); ?>
    </td>
    <td width="10">&nbsp;</td>
    <td width="655">&nbsp;</td>
    <td width="10">&nbsp;</td>
  </tr>
  <tr>
	<td>&nbsp;</td>
    <td valign="top" align="center">
		<table width="655" border="0" align="right" cellpadding="1" cellspacing="1">
		  <tr>
			<td width="505" valign="top">
			<div id="contenuto">		
<?php
if(!file_exists($_GET['act'].'.php'))
$_GET['act']="situazione";
require($_GET['act'].'.php');
?>
			</div> 
			</td>
			<td width="20">&nbsp;</td>
			<td width="120" valign="top">
				<?php
				if($user['plus']==0) {
				?>
					<div id="ads" align="right">
						qui banner 120x600
					</div>
				<?php
				} //fine if plus
				?>
			 </td>
		  </tr>
		</table>	
	</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
}
require_once('template/int_footer.php');
} //chiuso controllo login
?>