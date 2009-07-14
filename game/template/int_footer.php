<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
	</div>
	<div id=fondop> <img src="template/immagini/fondo.png" />  </div>
	</div>
	<?php
				if($user['plus']==0) {
				?>
					<div id=banner>
					<?php Showbanner($banner1); ?>
					</div>
				<?php
				} //fine se plus attivo
				?>
<div id=testaperg> <img src="template/immagini/testa.png" />  </div>
	
</div>
<div id="tempogenpag"> 
	<?php
	$end_time=time()+microtime();
	$gen_time=number_format($end_time-$start_time, 4, '.', '');
	echo sprintf($lang['tempo_gen_pagina'],$gen_time,$db->nquery);
	?> 
</div>
</body>
</html>