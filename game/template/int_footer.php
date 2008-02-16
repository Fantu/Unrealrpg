<br /><div align="center" id="tempogenpag">
<?php
$end_time=microtime()-$start_time;
$end_time=number_format($end_time, 4, '.', '');
echo sprintf($lang['tempo_gen_pagina'],$end_time,$numquery);
?>
</div>
</body>
</html>