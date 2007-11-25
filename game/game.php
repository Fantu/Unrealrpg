<?php 
define("_CORRETTO",1);

if($_COOKIE['urbglogin'])
	$lg=explode("|||",$_COOKIE['urbglogin']);

require('inclusi/funzioni_db.php');
$db = new ConnessioniMySQL();

if( $lg[3]!=0 && $lg[3]!=999 ) {
	header("Location: ../index.php?error=3");
	exit();
} else
	$db->database = $lg[3];

/*//prova controllo REF
$ref = $_SERVER['HTTP_REFERER'];
$random = rand(1,13);
$ref_controllo = substr($ref,0,(22+$random));
$string_rand = "game/game.php";
$ref_spez = "http://www.lostage.it/".substr($string_rand,0,$random); //http://www.lostage.it/game/game.php
if( $user['userid'] && $ref_controllo!=$ref_spez ) {
	header("Location: ../index.php?error=17");
	exit();
}
//fine controllo REF
*/
$check = $db->QuerySelect("SELECT chiuso FROM config");
if( $check['chiuso']==1 ) {
	header("Location: ../index.php?error=12");
	exit();
}

include_once('inclusi/myheader.php');

if(!$user['userid'])
	echo "Accesso negato!<br>Hai tentato di entrare in una pagina riservata agli utenti loggati.";
else if($user['ipattuale']!=$_SERVER['REMOTE_ADDR'])
	echo "Accesso negato!<br>Il numero IP è cambiato dal momento del login.<br /><a href=\"logout.php\">Clicca qui</a> per tornare indietro e loggarti nuovamente.";	
else {
?>
Loggato
<?php
} //chiuso controllo login
?>