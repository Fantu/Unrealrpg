<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
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
<br /><div id="tempogenpag">
<?php
$end_time=time()+microtime();
$gen_time=number_format($end_time-$start_time, 4, '.', '');
echo sprintf($lang['tempo_gen_pagina'],$gen_time,$db->nquery);
?>
</div>
</body>
</html>