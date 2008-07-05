<?php
function testosalute($percsalute){
global $lang;
if ($percsalute<=0){
$salute=$lang['morto'];
}elseif ($percsalute>0 AND $percsalute<10){
$salute=$lang['pessima'];
}elseif ($percsalute>=10 AND $percsalute<20){
$salute=$lang['molto_bassa'];
}elseif ($percsalute>=20 AND $percsalute<40){
$salute=$lang['bassa'];
}elseif ($percsalute>=40 AND $percsalute<60){
$salute=$lang['media'];
}elseif ($percsalute>=60 AND $percsalute<80){
$salute=$lang['alta'];
}elseif ($percsalute>=80 AND $percsalute<90){
$salute=$lang['molto_alta'];
}elseif ($percsalute>=90){
$salute=$lang['perfetta'];
}
return $salute;
}//fine testosalute

function testoenergia($percenergia){
global $lang;
if ($percenergia<5){
$energia=$lang['esausto'];
}elseif ($percenergia>=5 AND $percenergia<10){
$energia=$lang['pessima'];
}elseif ($percenergia>=10 AND $percenergia<20){
$energia=$lang['molto_bassa'];
}elseif ($percenergia>=20 AND $percenergia<40){
$energia=$lang['bassa'];
}elseif ($percenergia>=40 AND $percenergia<60){
$energia=$lang['media'];
}elseif ($percenergia>=60 AND $percenergia<80){
$energia=$lang['alta'];
}elseif ($percenergia>=80 AND $percenergia<90){
$energia=$lang['molto_alta'];
}elseif ($percenergia>=90){
$energia=$lang['perfetta'];
}
return $energia;
}//fine testoenergia

function Showbanner($banner){
$quale=array_rand($banner);
echo $banner[$quale];
}//fine Showbanner
?>