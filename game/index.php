<?php
$start_time=time()+microtime();
require('inclusi/valori.php');
require_once('inclusi/funzioni.php');
if($_COOKIE['userlogin'] AND preg_match("/[a-z0-9]{32}(-)[a-z0-9]{32}(-)[a-z0-9]{32}(-)[a-z0-9]{32}/",$_COOKIE['userlogin']) AND strlen($_COOKIE['userlogin'])==131)
	{$uc=explode("-",$_COOKIE['userlogin']);}else{header("Location: ../index.php?error=3"); exit();}
require_once('inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();
$esistenza=0;
foreach($game_server as $chiave=>$elemento){
if(md5($chiave)==$uc[2]){$esistenza=1; $db->database=$chiave;}
}//per ogni regno
if($esistenza==0){header("Location: ../index.php?error=3"); exit();}//se regno inesistente
$config=$db->QuerySelect("SELECT * FROM config");
if($config['chiuso']==1){header("Location: ../index.php?error=12"); exit();}//se regno chiuso
$s=$db->QuerySelect("SELECT count(id) AS n FROM sessione WHERE id='".$uc[0]."' LIMIT 1");
if($s['n']==0){header("Location: ../index.php?error=3"); exit();}//se sessione non esistente
$s=$db->QuerySelect("SELECT * FROM sessione WHERE id='".$uc[0]."' LIMIT 1");
if($s['password']!=$uc[1]){header("Location: ../index.php?error=3"); exit();}//se password non corrisponde
if($s['ip']!=$_SERVER['REMOTE_ADDR']){header("Location: ../index.php?error=3"); exit();}//se ip non corrisponde
if(md5($s['time'])!=$uc[3]){header("Location: ../index.php?error=3"); exit();}//se il tempo non corrisponde
$language=$config['language'];
require_once('language/'.$language.'/lang_interno.php');
$int_security=$game_se_code;
require_once('inclusi/int_header.php');
?>
<table width="910" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="155" rowspan="2" valign="top"><?php include('inclusi/menu.php'); ?>
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
		if(!in_array($location,$game_location))
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
					<?php Showbanner($banner1); ?>
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