<?php
require('../game/inclusi/valori.php');
require('../game/inclusi/funzioni_db.php');
$db=new ConnessioniMySQL();
$db->database=1000;
if($_COOKIE['urbglanguage']){
$language=htmlspecialchars($_COOKIE['urbglanguage'],ENT_QUOTES);
}else{
$language="it";
}//fine lingua
require('../game/language/'.$language.'/lang_admin.php');
if( isset($_POST['user']) ) {
	$user=htmlspecialchars($_POST['user'],ENT_QUOTES);
	$pass=htmlspecialchars($_POST['passw'],ENT_QUOTES);
	$op=$db->QuerySelect("SELECT COUNT(id) AS num FROM utenti WHERE username='".$user."' AND password='".md5($pass)."'");
	if($op['num']>0){
		setcookie ("urbgadm",md5($user)."|||".md5($pass),time()+3600);
		header("Location: admin.php");
		exit();
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name; echo" - "; echo $lang['pannello_amministrazione']; ?></title>
<meta name="author" content="Fantoni Fabio"></meta>
<meta name="language" content="it,en"></meta>
<meta name="copyright" content="Fantoni Fabio"></meta>
<meta name="content-language" content="it,en"></meta>
<script type="text/javascript">
<!--
function CambiaImg(id,bool) {
	var immagine = document.getElementById(id);
	if( bool == true )
		percorso = '../game/template/immagini/'+id+'_color.gif';
	else
		percorso = '../game/template/immagini/'+id+'_grigio.gif';
	immagine.src = percorso;
}
// -->
</script>
<link href="stile.css" rel="stylesheet" type="text/css" title="all"></link>
</head>
<body>
<table width="700" cellspacing="2" border="0" cellpadding="2" align="center">
  <tbody>
    <tr>
      <td><h3><?php echo $lang['pannello_amministrazione']; ?> - Login</h3></td>
    </tr>
    <tr>
      <td valign="top" class="tabmenu">
        <form method="post">
          <div align="center"><br />
            USERNAME
            <input type="text" name="user" />
            PASSWORD
            <input type="password" name="passw" />
            <input type="submit" name="sad" value="Login" />
            <br />
            <br />
          </div>
        </form>
	</td>
    </tr>
  </tbody>
</table>
<br /><br />
<?php include('footer.php'); ?>
</body>	
</html>