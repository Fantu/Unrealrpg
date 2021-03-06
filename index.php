<?php
require('game/inclusi/valori.php');
if(!empty($_GET['refer'])){
    $refer=htmlspecialchars($_GET['refer'],ENT_QUOTES);
    $server=htmlspecialchars($_GET['server'],ENT_QUOTES);
    if(is_numeric($refer) AND is_numeric($server))
    setcookie ("urbgrefer", $refer."|".$server,time()+604800);
}
if($_COOKIE['urbglanguage']){
    $language=htmlspecialchars($_COOKIE['urbglanguage'],ENT_QUOTES);
    $link="index_".$language.".php";
    if($_GET['error']){
        $errore=(int)$_GET['error'];
        $errore="?error=".$errore;
    }
    if(file_exists($link)){
        header("Location: ".$link.$errore);
        exit();
    }
}else{// check if there are reign with only one language
    $langsfound=0;
    foreach($game_language as $chiave=>$elemento){// for each language
        if (in_array($chiave, $game_server_lang)){// if there are reigns with selected language
            $langsfound+=1;
            $langsel=$chiave;
        }
    }
    if($langsfound==1 AND isset($langsel)){// if there reigns with same and only language redirect to it
        $link="index_".$langsel.".php";
        header("Location: ".$link);
        exit();
    }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $game_name." ".$game_state." ".$game_version; ?></title>
<meta name="author" content="Fantoni Fabio"></meta>
<meta name="language" content="it,en"></meta>
<meta name="revisit-after" content="7 days"></meta>
<meta name="copyright" content="Fantoni Fabio"></meta>
<meta name="content-language" content="it,en"></meta>
<script type="text/javascript">
<!--
function CambiaImg(id,bool) {
	var immagine = document.getElementById(id);
	if( bool == true )
		percorso = 'game/template/immagini/'+id+'_color.gif';
	else
		percorso = 'game/template/immagini/'+id+'_grigio.gif';
	immagine.src = percorso;
}
// -->
</script>
</head>
<body>
<div align="center">
<h1>
<?php echo $game_name." ".$game_state." ".$game_version; ?>
<br />
<?php
foreach($game_language as $chiave=>$elemento){// for each language
    if (in_array($chiave, $game_server_lang))// if there are reigns with selected language
        echo "<br /><br /><a href=\"index_".$chiave.".php\">".$elemento."</a>";
}
?>
</h1>
<br /><br />
&copy; 2007-2014 <?php echo $game_name; ?> developers
<br /><br />
<a href="http://validator.w3.org/check?uri=referer" target="_blank">
	<img id="xhtml" src="game/template/immagini/xhtml_grigio.gif" alt="" border="0" onmouseover="CambiaImg('xhtml', true);" onmouseout="CambiaImg('xhtml', false);" />
</a>
<a href="http://jigsaw.w3.org/css-validator/check/referer" target="_blank">
	<img id="css" src="game/template/immagini/css_grigio.gif" border="0" alt="" onmouseover="CambiaImg('css', true);" onmouseout="CambiaImg('css', false);" />
</a>
<a href="http://www.php.net" target="_blank">
	<img id="php" src="game/template/immagini/php_grigio.gif" alt="" border="0" onmouseover="CambiaImg('php', true);" onmouseout="CambiaImg('php', false);" />
</a>
<a href="http://www.mysql.com" target="_blank">
	<img id="mysql" src="game/template/immagini/mysql_grigio.gif" alt="" border="0" onmouseover="CambiaImg('mysql', true);" onmouseout="CambiaImg('mysql', false);" />
</a>
<a href="http://www.gnu.org/licenses/agpl-3.0.html" target="_blank">
	<img id="agplv3" src="game/template/immagini/agplv3_grigio.gif" alt="" border="0" onmouseover="CambiaImg('agplv3', true);" onmouseout="CambiaImg('agplv3', false);" />
</a>
<a href="http://ipv6-test.com/validate.php?url=referer" target="_blank">
	<img id="ipv6" src="game/template/immagini/ipv6_grigio.gif" alt="" border="0" onmouseover="CambiaImg('ipv6', true);" onmouseout="CambiaImg('ipv6', false);" />
</a>
<br /><br />
</div>
</body>
</html>
