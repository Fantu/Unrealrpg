<?php

function Dead($user,$usercar){
    global $db,$adesso,$log;
    // the basic time to resurrect is one day less a minute every faith point
    // or 3 hours with the intervention of the clergy
    if($user['resuscita']=='0'){
        $tempor=43200-$usercar['fede'];
    }else{
        $tempor=10800;
    }
    // with the account plus an hour in less
    if($user['plus']!=0)
        $tempor-=3600;
    // the time of the resurrection must be minimum 1 hour
    if($tempor<3600)
        $tempor=3600;
    $db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo) VALUES ('".$user['userid']."','".$adesso."','".$tempor."','4','3')");
    // create log record of beginning resurrection
    $log->Utenti($user['userid'],13);
}//end Dead

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
}elseif ($percsalute>=90 AND $percsalute<99){
$salute=$lang['ottima'];
}elseif ($percsalute>=99){
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
}elseif ($percenergia>=90 AND $percenergia<99){
$energia=$lang['ottima'];
}elseif ($percenergia>=99){
$energia=$lang['perfetta'];
}
return $energia;
}//fine testoenergia

function recenergiasalute($userid,$usercar){
global $db,$adesso;
if($usercar==0)
$usercar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$userid."' LIMIT 1");
if ($adesso>($usercar['recuperosalute']+3600)){
	if ($usercar['saluteattuale']<=$usercar['salute']){
		$differenzaora=$adesso-$usercar['recuperosalute'];
		$ore=floor($differenzaora/3600);
		$salute=$usercar['saluteattuale']+round($usercar['salute']/100*$ore);
		if ($salute>$usercar['salute'])
		$salute=$usercar['salute'];
		$db->QueryMod("UPDATE caratteristiche SET recuperosalute=recuperosalute+'".($ore*3600)."',saluteattuale='".($salute)."' WHERE userid='".$userid."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET recuperosalute='".$adesso."' WHERE userid='".$userid."'");}
}//fine recupero salute con tempo
if ($adesso>($usercar['recuperoenergia']+60)){
	if ($usercar['energia']<=$usercar['energiamax']){
		$differenzaora=$adesso-$usercar['recuperoenergia'];
		$ore=floor($differenzaora/60);
		$energia=$usercar['energia']+round($usercar['energiamax']/1000*$ore);
		if ($energia>$usercar['energiamax'])
		$energia=$usercar['energiamax'];
		$db->QueryMod("UPDATE caratteristiche SET recuperoenergia=recuperoenergia+'".($ore*60)."',energia='".($energia)."' WHERE userid='".$userid."'");
	}
	else{$db->QueryMod("UPDATE caratteristiche SET recuperoenergia='".$adesso."' WHERE userid='".$userid."'");}
}//fine recupero energia con tempo
}//fine recenergiasalute

function inbacheca($testo){
global $db,$adesso;
$db->QueryMod("INSERT INTO bacheca (testo,data) VALUES ('".$testo."','".$adesso."')");
}//fine inbacheca

function Showbanner($banner){
$quale=array_rand($banner);
echo $banner[$quale];
}//fine Showbanner

class Email{

	private $header;

	private function Config(){
		global $game_name,$game_mail;
		$this->header.="From: ".$game_name."<".$game_mail.">\n";
		$this->header.="Reply-To: ".$game_name."<".$game_mail.">\n";
		$this->header.="Message-ID: <".time()."-".$game_mail.">\n";
		$this->header.="X-Mailer: PHP v".phpversion()."\n";
	}
	public function Email($tipo,$destinatario,$titolo,$messaggio){ //$email=new Email(1,$destinatario,$titolo,$messaggio); primo parametro è se mail html (1=sì e 0=no)
		$this->Config();
		if($tipo==1){
		$this->header.="MIME-Version: 1.0\n";
		$this->header.="Content-Type: text/html; charset=utf8\n";
		$messaggio="<html><body>".$messaggio."</body></html>";
		}
		mail($destinatario,$titolo,$messaggio,$this->header);
	}

}//fine Email
?>
