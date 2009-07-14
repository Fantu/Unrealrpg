<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}?>
<?php echo $outputerrori; ?>
<br />
<br />
<?php echo $lang['Armi']; ?>
<br />
<br />
<?php echo $desc_impocac; ?>
<br />
<form action="" method="post" name="fimpocac">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_cac']; ?> <select name="acac" id="acac">
<option value="-1" selected="selected">--------</option>
<?php if($userequip['cac']!=0){
echo "<option value=\"0\">".$lang['Niente']."</option>";}
if($armicac){
foreach($armicac as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="impocac" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $desc_impoadi; ?>
<br />
<form action="" method="post" name="fimpoadi">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_adi']; ?> <select name="aadi" id="aadi">
<option value="-1" selected="selected">--------</option>
<?php if($userequip['adi']!=0){
echo "<option value=\"0\">".$lang['Niente']."</option>";}
if($armiadi){
foreach($armiadi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="impoadi" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['Equipdifensivo']; ?>
<br />
<br />
<?php echo $desc_impoarm; ?>
<br />
<form action="" method="post" name="fimpoarm">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_arm']; ?> <select name="arm" id="arm">
<option value="-1" selected="selected">--------</option>
<?php if($userequip['arm']!=0){
echo "<option value=\"0\">".$lang['Niente']."</option>";}
if($armature){
foreach($armature as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="impoarm" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $desc_imposcu; ?>
<br />
<form action="" method="post" name="fimposcu">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_scu']; ?> <select name="scu" id="scu">
<option value="-1" selected="selected">--------</option>
<?php if($userequip['scu']!=0){
echo "<option value=\"0\">".$lang['Niente']."</option>";}
if($scudi){
foreach($scudi as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="imposcu" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>
<br />
<br />
<?php echo $lang['Pozioni']; ?>
<br />
<br />
<?php echo $desc_impopoz; ?>
<br />
<form action="" method="post" name="fimpopoz">
<table border="0">
<tr>
<td>
<?php echo $lang['seleziona_poz']; ?> <select name="poz" id="poz">
<option value="-1" selected="selected">--------</option>
<?php if($userequip['poz']!=0){
echo "<option value=\"0\">".$lang['Niente']."</option>";}
if($pozioni){
foreach($pozioni as $chiave=>$elemento)
echo "<option value=\"$chiave\">$elemento</option>";} ?>
</select>
</td>
</tr>
<tr>
<td>
<input type="submit" name="impopoz" value="<?php echo $lang['Imposta']; ?>" />
</td>
</tr>
</table>
</form>