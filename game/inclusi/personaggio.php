<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
$razze=array(
'nome'=>array(1=>$lang['Umani'],2=>$lang['Elfi'],3=>$lang['Non_morti'],4=>$lang['Orchi'],5=>$lang['Nani']),
'descrizione'=>array(1=>$lang['desc_umani'],2=>$lang['desc_elfi'],3=>$lang['desc_non_morti'],4=>$lang['desc_orchi'],5=>$lang['desc_nani'])
);
$classi=array(
'nome'=>array(1=>$lang['Guerriero'],2=>$lang['Mago'],3=>$lang['Ladro'],4=>$lang['Ranger'],5=>$lang['Ninja'],6=>$lang['Berserk']),
'descrizione'=>array(1=>$lang['desc_guerriero'],2=>$lang['desc_mago'],3=>$lang['desc_ladro'],4=>$lang['desc_ranger'],5=>$lang['desc_ninja'],6=>$lang['desc_berserk']),
'agilita'=>array(1=>150,2=>50,3=>225,4=>125,5=>250,6=>125),
'attfisico'=>array(1=>200,2=>25,3=>100,4=>100,5=>75,6=>300),
'attmagico'=>array(1=>25,2=>200,3=>50,4=>50,5=>50,6=>25),
'diffisica'=>array(1=>200,2=>25,3=>100,4=>100,5=>75,6=>100),
'difmagica'=>array(1=>25,2=>200,3=>50,4=>50,5=>50,6=>25),
'mana'=>array(1=>50,2=>400,3=>50,4=>50,5=>100,6=>50),
'velocita'=>array(1=>150,2=>50,3=>200,4=>150,5=>250,6=>150),
'intelligenza'=>array(1=>100,2=>200,3=>150,4=>100,5=>100,6=>100),
'destrezza'=>array(1=>125,2=>50,3=>100,4=>250,5=>100,6=>150)
);
$sessi=array(
'nome'=>array(0=>$lang['Non_definito'],1=>$lang['Maschio'],2=>$lang['Femmina'])
);
?>