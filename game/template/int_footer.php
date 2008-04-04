<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<br /><div align="center" id="tempogenpag">
<?php
$end_time=microtime();
$gen_time=number_format($end_time-$start_time, 4, '.', '');
echo sprintf($lang['tempo_gen_pagina'],$gen_time,$numquery);
?>
</div>
</body>
</html>