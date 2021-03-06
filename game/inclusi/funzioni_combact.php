<?php
if((empty($int_security)) OR ($int_security!=$game_se_code)){
	header("Location: ../../index.php?error=16");
	exit();
}
require_once('language/'.$language.'/lang_combact.php');

class Combattente{
	var $id;
	var $nome;
	var $car;
	var $equip;
	var $esausto;
	var $tattica;
	var $subtattica;
	var $plus;
	var $salutei;
	var $energiai;
	var $cpu;
	function Combattente($id2,$nome2,$car2,$equip2,$tattica2,$subtattica2,$plus2,$cpu2){
	$this->id=$id2;
	$this->nome=$nome2;
	$this->car=$car2;
	$this->equip=$equip2;
	$this->oggusati=0;
	$this->esausto=0;
	$this->tattica=$tattica2;
	$this->subtattica=$subtattica2;
	$this->plus=$plus2;
	$this->salutei=$car2['saluteattuale'];
	$this->energiai=$car2['energia'];
	$this->cpu=$cpu2;
	}
} //fine classe Combattente

class Dati{
	public $che;

	public function Stabilisciordine($battle) {
	global $db,$lang;
	$attaccante=$battle['attid'];
	$difensore=$battle['difid'];
	$attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
	$attn=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
	$attname=$attn['username'];
	$attequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$attaccante."' LIMIT 1");
	$attpoint=($attcar['agilita']/5)+($attcar['velocita']/5)+($attcar['saluteattuale']/2)+($attcar['energia']/15);
	if($battle['difcpu']==0){
	$difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$difensore."' LIMIT 1");
	$difn=$db->QuerySelect("SELECT * FROM utenti WHERE userid='".$difensore."' LIMIT 1");
	$difname=$difn['username'];
	$difequip=$db->QuerySelect("SELECT * FROM equipaggiamento WHERE userid='".$difensore."' LIMIT 1");
	$difplus=$difn['plus'];
	$cpu=0;
	}else{
	$difcar=$db->QuerySelect("SELECT * FROM carcpu WHERE cpuid='".$difensore."' LIMIT 1");
	$difname=$lang['nomepcpu'.$difcar['pid']];
	$difequip=$db->QuerySelect("SELECT * FROM equipagcpu WHERE cpuid='".$difensore."' LIMIT 1");
	$difplus=1;
	$cpu=1;
	}
	$difpoint=($difcar['agilita']/5)+($difcar['velocita']/5)+($difcar['saluteattuale']/2)+($difcar['energia']/15);
	if($attpoint>$difpoint){
	$this->che[1]=new Combattente($attaccante,$attname,$attcar,$attequip,$battle['tatatt'],$battle['tatatt2'],$attn['plus'],0);
	$this->che[2]=new Combattente($difensore,$difname,$difcar,$difequip,$battle['tatdif'],$battle['tatdif2'],$difplus,$cpu);
	}else{
	$this->che[2]=new Combattente($attaccante,$attname,$attcar,$attequip,$battle['tatatt'],$battle['tatatt2'],$attn['plus'],0);
	$this->che[1]=new Combattente($difensore,$difname,$difcar,$difequip,$battle['tatdif'],$battle['tatdif2'],$difplus,$cpu);
	}
	if($this->plus(1)>0 AND $this->tattica(1,1)==0)
	$this->Autotattic(1);
	if($this->plus(2)>0 AND $this->tattica(2,1)==0)
	$this->Autotattic(2);
	} //fine Stabilisciordine

	//----------------------------
	//  VISUALIZZAZIONE DATI
	//----------------------------

	public function equip($chi,$campo) {
	$dato=$this->che[$chi]->equip[$campo];
	return $dato;
	} //fine equip

	public function car($chi,$campo) {
	$dato=$this->che[$chi]->car[$campo];
	return $dato;
	} //fine car

	public function tattica($chi,$campo) {
	if($campo==1)
	$dato=$this->che[$chi]->tattica;
	else
	$dato=$this->che[$chi]->subtattica;
	return $dato;
	} //fine tattica

	public function id($chi) {
	$dato=$this->che[$chi]->id;
	return $dato;
	} //fine id

	public function plus($chi) {
	$dato=$this->che[$chi]->plus;
	return $dato;
	} //fine plus

	public function cpu($chi) {
	$dato=$this->che[$chi]->cpu;
	return $dato;
	} //fine cpu

	public function esausto($chi) {
	$dato=$this->che[$chi]->esausto;
	return $dato;
	} //fine esausto

	public function nome($chi) {
	$dato=$this->che[$chi]->nome;
	return $dato;
	} //fine nome

	public function pvar($chi) {
	$dato=$this->che[$chi];
	return $dato;
	} //fine pvar

	public function Viewequip($chi) {
	global $lang;
	if($this->equip($chi,'cac')!=0 OR $this->equip($chi,'arm')!=0 OR $this->equip($chi,'scu')!=0 OR $this->equip($chi,'poz')!=0 OR $this->equip($chi,'adi')!=0){
	if($this->equip($chi,'cac')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'cac').'_nome'];
	if($this->equip($chi,'adi')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'adi').'_nome'];
	if($this->equip($chi,'arm')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'arm').'_nome'];
	if($this->equip($chi,'scu')!=0)
	$equip.=" ".$lang['oggetto'.$this->equip($chi,'scu').'_nome'];
	if($this->equip($chi,'poz')!=0)
	$equip.=" ".$lang['Pozione'];
	}else{$equip=$lang['nessuno'];}
	$input=sprintf($lang['equip_di'],$this->nome($chi),$this->car($chi,'livello'),$equip)."<br/>";
	return $input;
	} //fine Viewequip

	//----------------------------
	//  IMPOSTAZIONE DATI
	//----------------------------

	public function Ogginuso($chi,$cosa) {
	global $db;
	if($this->cpu($chi)==0){
	$db->QueryMod("UPDATE equip SET inuso='1' WHERE userid='".$this->id($chi)."' AND oggid='".$this->equip($chi,$cosa)."' LIMIT 1");
	}else{
	$db->QueryMod("UPDATE equipcpu SET inuso='1' WHERE cpuid='".$this->id($chi)."' AND oggid='".$this->equip($chi,$cosa)."' LIMIT 1");
	}
	$this->che[$chi]->oggusati=1;
	} //fine ogginuso

	public function Modsalute($chi,$quanto){
	$this->che[$chi]->car['saluteattuale']-=$quanto;
	} //fine ogginuso

	public function Modenergia($chi,$quanto){
	$this->che[$chi]->car['energia']-=$quanto;
	} //fine ogginuso

	public function Aggiornastat($chi){
	global $db,$adesso;
	if($this->car($chi,'saluteattuale')<0)
	$this->che[$chi]->car['saluteattuale']=0;
	if($this->car($chi,'energia')<0)
	$this->che[$chi]->car['energia']=0;
	if($this->cpu($chi)==0){
	$db->QueryMod("UPDATE caratteristiche SET saluteattuale='".$this->car($chi,'saluteattuale')."',energia='".$this->car($chi,'energia')."',recuperosalute='".$adesso."',recuperoenergia='".$adesso."' WHERE userid='".$this->id($chi)."' LIMIT 1");
	}else{
	$db->QueryMod("UPDATE carcpu SET saluteattuale='".$this->car($chi,'saluteattuale')."',energia='".$this->car($chi,'energia')."' WHERE cpuid='".$this->id($chi)."' LIMIT 1");
	}

	} //fine ogginuso

	public function Controlloogg($chi) {
	$oggpersi=Checkusurarottura($this->id($chi),$this->cpu($chi));
	if($oggpersi){
	$dato.=$this->nome($chi).": ".$oggpersi;
	}
	return $dato;
	} //fine Controlloogg

	public function Controllastato($chi) {
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	if ($percenergia<5)
	$this->che[$chi]->esausto=1;
	else
	$this->che[$chi]->esausto=0;
	} //fine Controllastato

	public function Autotattic($chi){
	global $db;
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$percsalute=100/$this->car($chi,'salute')*$this->car($chi,'saluteattuale');
	$percsalute2=100/$this->car($chi2,'salute')*$this->car($chi2,'saluteattuale');
	$percenergia=100/$this->car($chi,'energiamax')*$this->car($chi,'energia');
	$percenergia2=100/$this->car($chi2,'energiamax')*$this->car($chi2,'energia');
	$tattp=array(1=>0,2=>0,3=>0);
	$tattp[1]=99;//attacco di base
	if($percsalute<40){//difesa
	$tattp[3]+=40;}
	if($percenergia<30){//difesa
	$tattp[3]+=40;}
	if($percsalute2>40 AND $percsalute<40){//difesa
	$tattp[3]+=40;}
	if($percenergia2>10 AND $percsalute<30 AND $percsalute2>40){//difesa
	$tattp[3]+=40;}
	if($this->equip($chi,'cac')==0 AND $this->equip($chi2,'cac')!=0){//se nessuna arma mentre avversario sì difesa
	$tattp[3]+=18;}
	if($percenergia2<5){//se l'avversario è esausto attacco
	$tattp[1]+=90;}
	if($percsalute<15){//se la salute è pessima resa
	$tattp[2]+=181;}
	if($percenergia<5){//se esausto resa
	$tattp[2]+=200;}
	if($this->equip($chi,'poz')!=0){
	$pozione=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($chi,'poz')."' LIMIT 1");
	if( ($percsalute<22 AND $pozione['recsalute']>0) OR ($percenergia<20 AND $pozione['recenergia']>0) ){$tattp[4]+=199;}
	}//fine se ha pozione
	$max=0;
	if($this->cpu(1)==1 OR $this->cpu(2)==1){
	$tattp[2]=0;}//se contro cpu resa non possibile
	foreach($tattp as $chiave=>$elemento){
	if($elemento>$max){
	$max=$elemento;
	$this->che[$chi]->tattica=$chiave;
	}
	}//per ogni tattica
	if($this->tattica($chi,1)==3){
	$prob=rand(1,3);
	if($prob==1)
	$this->che[$chi]->tattica=1;
	}//se difesa prob di attacco
	if($this->tattica($chi,1)==1){
	if(($this->equip($chi,'cac')!=0) AND ($this->equip($chi,'adi')==0)){
	$this->che[$chi]->subtattica=1;
	}elseif(($this->equip($chi,'cac')==0) AND ($this->equip($chi,'adi')!=0)){
	$this->che[$chi]->subtattica=2;
	}elseif(($this->equip($chi,'cac')!=0) AND ($this->equip($chi,'adi')!=0)){
	$armavi=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($chi,'cac')."' LIMIT 1");
	$armadi=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($chi,'adi')."' LIMIT 1");
	if($armavi['danno']>$armadi['danno']){
	$this->che[$chi]->subtattica=1;
	}else{
	$this->che[$chi]->subtattica=2;}
	}else{//se ha entrambe le armi
	$this->che[$chi]->subtattica=2;
	}//se nessuna
	}//se si attacca
	}//fine Autotattic

    public function Guadagnaexp($chi,$turni,$expb,$vincitore){
        global $db,$lang;
        if($chi==1)
            $chi2=2;
        else
            $chi2=1;
        $exp=5+$expb;
        $exp=round(rand(($exp/100*95),$exp));
        if($vincitore==$chi2){
            $exp-=6;
        }elseif($vincitore==$chi){
            $exp+=6;
        }elseif($vincitore==0){
            $exp+=5;
        }
        $level=$this->car($chi,'livello')-$this->car($chi2,'livello');
        if($level<0){
            $liv=abs($level);
            if($liv>10)
                $liv=10;
            $exp+=round($exp/10*$liv);
        }elseif($level>0){
            if($liv>9)
                $liv=9;
            $exp-=round($exp/10*$liv);
        }
        if($exp<0)
            $exp=0;
        $db->QueryMod("UPDATE caratteristiche SET exp=exp+'".$exp."' WHERE userid='".$this->id($chi)."' LIMIT 1");
        $input=sprintf($lang['exp_guadagnata'],$this->nome($chi),$exp)."<br/>";
        return $input;
    }// end Guadagnaexp

	public function Checkrep($chi){
	if($chi==1)
	$chi2=2;
	else
	$chi2=1;
	$level=$this->car($chi,'livello')-$this->car($chi2,'livello');
	$liv=abs($level);
	$rep[1]=floor($liv/2);
	if($liv<=2){
	$rep[0]=0;//pari
	}elseif($level<0){
	$rep[0]=1;//più debole
	}elseif($level>0){
	$rep[0]=2;//più forte
	}
	return $rep;
	}//fine Checkrep

	public function Checkeqipexp($expb){
	//controllo armi corpo a corpo
	if($this->equip(1,'cac')!=0)
	$expb+=0.2;
	if($this->equip(2,'cac')!=0)
	$expb+=0.2;
	//controllo armi a distanza
	if($this->equip(1,'adi')!=0)
	$expb+=0.2;
	if($this->equip(2,'adi')!=0)
	$expb+=0.2;
	//controllo armature
	if($this->equip(1,'arm')!=0)
	$expb+=0.2;
	if($this->equip(2,'arm')!=0)
	$expb+=0.2;
	//controllo scudi
	if($this->equip(1,'scu')!=0)
	$expb+=0.2;
	if($this->equip(2,'scu')!=0)
	$expb+=0.2;
	//controllo pozioni
	if($this->equip(1,'poz')!=0)
	$expb+=0.2;
	if($this->equip(2,'poz')!=0)
	$expb+=0.2;
	return $expb;
	}//fine Checkeqipexp

	public function Checkturnexp($expb){
	if( (($this->che[1]->energiai-$this->car(1,'energia'))+($this->che[2]->energiai)-$this->car(2,'energia'))>100 )
	$expb+=0.5;//se energia persa tra i 2 maggiore di 100
	if( (($this->che[1]->salutei-$this->car(1,'saluteattuale'))+($this->che[2]->salutei-$this->car(2,'saluteattuale')))>30 )
	$expb+=0.5;//se salute persa tra i 2 maggiore di 30
	if( ($this->che[2]->salutei-$this->car(2,'saluteattuale'))>5 )
	$expb+=0.5;//se salute persa almeno 5
	if( ($this->che[2]->salutei-$this->car(2,'saluteattuale'))>5 )
	$expb+=0.5;//se salute persa almeno 5
	return $expb;
	}//fine Checkturnexp

    public function Attaccovicino($att,$dif){
    global $db,$lang;
    if($this->equip($att,'cac')!=0){// if he has a melee weapon
        $arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($att,'cac')."' LIMIT 1");
        $energia=$arma['energia'];
    }
    // if he has a melee weapon and energy enough to use it
    if($this->equip($att,'cac')!=0 AND $this->car($att,'energia')>$energia){
        $danno=$arma['danno'];
        if($danno>4)
            $danno=round(rand(($danno/100*80),$danno));
        $nomearma=$lang['oggetto'.$this->equip($att,'cac').'_nome'];
        $this->Ogginuso($att,'cac');
    }else{// if he do not have enough energy weapon uses a punches
        $danno=rand(1,3)+round($this->car($att,'attfisico')/80);
        $nomearma=$lang['pugno'];
        $energia=40;
    }
    if($this->equip($dif,'arm')!=0){// if the defender has an armor
        $armatura=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'arm')."' LIMIT 1");
        if($armatura['energia']<=$this->car($dif,'energia')){
            $this->Modenergia($dif,$armatura['energia']);
            $this->Ogginuso($dif,'arm');
        }
    }
	if($this->esausto($dif)==0 AND $this->equip($dif,'scu')!=0){// if the defender shield and is not exhausted
        $this->Ogginuso($dif,'scu');
        $scudo=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'scu')."' LIMIT 1");
        $this->Modenergia($dif,$scudo['energia']);
    }
	$casuale=rand(1,10);
    if($casuale<2){// 10% chance of hitting always
        $colpisci=100;
    }elseif($casuale>9){// 10% chance of hitting never
        $colpisci=0;
    }else{// 80% chance of hitting on the basis of values, objects, and tactics of the characters
        $colpisci=rand(1,100)+($this->car($att,'agilita')/8-$this->car($dif,'agilita')/8)+($this->car($att,'intelligenza')/25-$this->car($dif,'intelligenza')/25)+($this->car($att,'velocita')/20-$this->car($dif,'velocita')/20)+((20/$this->car($att,'energiamax')*$this->car($att,'energia'))-(20/$this->car($dif,'energiamax')*$this->car($dif,'energia')));
        if($this->equip($att,'cac')!=0 AND $arma['bonuseff']!=0)
            $colpisci+=$colpisci/100*$arma['bonuseff'];
        if($this->tattica($dif,1)==3 AND $this->esausto($dif)==0)
            $colpisci-=rand(10,20);
        if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
            $colpisci-=20;
        if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20)
            $colpisci+=20;
        if((100/$this->car($att,'salute')*$this->car($att,'saluteattuale'))<10)
            $colpisci-=20;
        if((100/$this->car($dif,'salute')*$this->car($dif,'saluteattuale'))<10)
            $colpisci+=20;
        if($dif==1 AND ($this->tattica($dif,1)==1 AND $this->tattica($dif,2)==2))
            $colpisci-=10;
    }
    if($colpisci>50 OR $this->esausto($dif)==1){
        $difesamax=round($this->car($dif,'diffisica')/100);
        $difesa=rand(0,$difesamax);
        if($this->equip($dif,'arm')!=0){
            if($armatura['energia']<=$this->car($dif,'energia'))
                $difesa+=round(rand(0,$armatura['difesafisica']));
        }
        $pscudo="";
        if($this->tattica($dif,1)==3)// if the opponent is in defensive tactics
            $probps=rand(0,35);
        else
            $probps=rand(0,100);
        if($this->equip($dif,'scu')!=0 AND $probps<20 AND $this->esausto($dif)==0){
            if($scudo['energia']<=$this->car($dif,'energia')){
                $pscudo=" ".$lang['parata_con_scudo'].", ";
                $prob=10;
                if($this->tattica($dif,1)==3)// if the opponent is in defensive tactics
                    $prob=50;
                $difesa+=round(rand($scudo['difesafisica']/100*$prob,$scudo['difesafisica']));
            }
        }
        $potente="";
        $probpot=rand(10,100);
        if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
            $probpot-=50;
        if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20 AND (100/$this->car($att,'energiamax')*$this->car($att,'energia'))>40)
            $probpot+=30;
        if($this->esausto($dif)==1)
            $probpot+=30;
        if($this->equip($att,'cac')!=0 AND $arma['bonuseff']!=0)
            $probpot+=$probpot/100*$arma['bonuseff'];
        if($probpot>=100){// if powerful blow
            $probmpot=rand(1,10);
            if($probmpot==10){
                $danno+=$danno;
                $potente=" ".$lang['colpo_molto_potente'].", ";
            }else{
                $danno+=round($danno/2);
                $potente=" ".$lang['colpo_potente'].", ";
            }
        }
        $danno-=$difesa;
        if($danno<1)
            $danno=1;
        $input=sprintf($lang['danno_att_vicino'],$this->nome($att),$nomearma).", ".sprintf($lang['danni_subiti'],($this->nome($dif).$potente.$pscudo),$danno)."<br/>";
        $this->Modsalute($dif,$danno);
    }else{// if he doesn't hit
        $input=sprintf($lang['niente_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma)."<br/>";
    }
    $this->Modenergia($att,$energia);
    return $input;
    }// end Attaccovicino

	public function Usapozione($chi){
	global $db,$lang;
	$oggetto=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($chi,'poz')."' LIMIT 1");
	$nomeogg=$lang['oggetto'.$oggetto['id'].'_nome'];
	$ok=1;
	switch($oggetto['tipo']){
		case 4://pozioni generiche
			switch($oggetto['categoria']){
			case 1://pozioni curative
			$salute=$this->car($chi,'saluteattuale')+$oggetto['recsalute'];
			if($salute>$this->car($chi,'salute'))
			$salute=$this->car($chi,'salute');
			$this->che[$chi]->car['saluteattuale']=$salute;
			$output=sprintf($lang['utilizzato_4_1'],$nomeogg,$oggetto['recsalute']);
			break;
			case 2://pozioni energetiche
			$energia=$this->car($chi,'energia')+$oggetto['recenergia'];
			if($energia>$this->car($chi,'energiamax'))
			$energia=$this->car($chi,'energiamax');
			$this->che[$chi]->car['energia']=$energia;
			$output=sprintf($lang['utilizzato_4_2'],$nomeogg,$oggetto['recenergia']);
			break;
			default:
			$ok=0;
			$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
			break;
			}
		break;
		default:
		$ok=0;
		$output=sprintf($lang['errore_sistema_utilizzo_ogg'],$nomeogg);
		break;
		}
	if($ok==1){
	$this->Ogginuso($chi,'poz');
	$output=$this->nome($chi).": ".$output."<br/>";
	}//se usato
	return $output;
	}//fine Usapozione

    public function Attaccolontano($att,$dif){
    global $db,$lang;
    if($this->equip($att,'adi')!=0){// if he has a weapon at a distance
        $arma=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($att,'adi')."' LIMIT 1");
        $energia=$arma['energia'];
	}
    // if he has a weapon at a distance and energy enough to use it
    if($this->equip($att,'adi')!=0 AND $this->car($att,'energia')>$energia){
        $danno=$arma['danno'];
        if($danno>4)
            $danno=round(rand(($danno/100*80),$danno));
        $nomearma=$lang['oggetto'.$this->equip($att,'adi').'_nome'];
        $this->Ogginuso($att,'adi');
	}else{// if you do not have enough energy weapon uses a stone
        $danno=rand(2,4)+round($this->car($att,'attfisico')/80);
        $nomearma=$lang['sasso'];
        $energia=30;
    }
    if($this->equip($dif,'arm')!=0){// if the defender has an armor
        $armatura=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'arm')."' LIMIT 1");
        if($armatura['energia']<=$this->car($dif,'energia')){// if the defender has enough energy
            $this->Modenergia($dif,$armatura['energia']);
            $this->Ogginuso($dif,'arm');
        }
    }
    if($this->esausto($dif)==0 AND $this->equip($dif,'scu')!=0){// if the defender shield and is not exhausted
        $this->Ogginuso($dif,'scu');
        $scudo=$db->QuerySelect("SELECT * FROM oggetti WHERE id='".$this->equip($dif,'scu')."' LIMIT 1");
        $this->Modenergia($dif,$scudo['energia']);
    }
    $casuale=rand(1,10);
    if($casuale<2){// 10% chance of hitting always
        $colpisci=100;
    }elseif($casuale>9){// 10% chance of hitting never
        $colpisci=0;
    }else{// 80% chance of hitting on the basis of values, objects, and tactics of the characters
	$colpisci=rand(1,100)+($this->car($att,'agilita')/10-$this->car($dif,'agilita')/9)+($this->car($att,'intelligenza')/25-$this->car($dif,'intelligenza')/25)+($this->car($att,'destrezza')/5-$this->car($dif,'destrezza')/6)+((20/$this->car($att,'energiamax')*$this->car($att,'energia'))-(20/$this->car($dif,'energiamax')*$this->car($dif,'energia')));
    if($this->equip($att,'adi')!=0 AND $arma['bonuseff']!=0)
        $colpisci+=$colpisci/100*$arma['bonuseff'];
    if($this->tattica($dif,1)==3 AND $this->esausto($dif)==0)
        $colpisci-=rand(10,20);
    if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
        $colpisci-=20;
    if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20)
        $colpisci+=20;
    if((100/$this->car($att,'salute')*$this->car($att,'saluteattuale'))<10)
        $colpisci-=20;
    if((100/$this->car($dif,'salute')*$this->car($dif,'saluteattuale'))<10)
        $colpisci+=20;
    }
    if($colpisci>50 OR $this->esausto($dif)==1){// if it hits
        $difesamax=round($this->car($dif,'diffisica')/100);
        $difesa=rand(0,$difesamax);
        if($this->equip($dif,'arm')!=0){
            if($armatura['energia']<=$this->car($dif,'energia'))
                $difesa+=round(rand(0,$armatura['difesafisica']));
        }
        $pscudo="";
        if($this->tattica($dif,1)==3)// if the opponent is in defensive tactics
            $probps=rand(0,35);
        else
            $probps=rand(0,100);
        if($this->equip($dif,'scu')!=0 AND $probps<20 AND $this->esausto($dif)==0){
            if($scudo['energia']<=$this->car($dif,'energia')){
                $pscudo=" ".$lang['parata_con_scudo'].", ";
                $prob=10;
                if($this->tattica($dif,1)==3)// if the opponent is in defensive tactics
                    $prob=50;
                $difesa+=round(rand($scudo['difesafisica']/100*$prob,$scudo['difesafisica']));
            }
        }
        $potente="";
        $probpot=rand(10,100);
        if((100/$this->car($att,'energiamax')*$this->car($att,'energia'))<20)
            $probpot-=50;
        if((100/$this->car($dif,'energiamax')*$this->car($dif,'energia'))<20 AND (100/$this->car($att,'energiamax')*$this->car($att,'energia'))>40)
            $probpot+=30;
        if($this->esausto($dif)==1)
            $probpot+=30;
        if($this->equip($att,'adi')!=0 AND $arma['bonuseff']!=0)
            $probpot+=$probpot/100*$arma['bonuseff'];
        if($probpot>=100){// if powerful blow
            $probmpot=rand(1,10);
            if($probmpot==10){
                $danno+=$danno;
                $potente=" ".$lang['colpo_molto_potente'].", ";
            }else{
                $danno+=round($danno/2);
                $potente=" ".$lang['colpo_potente'].", ";
            }
        }
        $danno-=$difesa;
        if($danno<1)
            $danno=1;
        $input=sprintf($lang['danno_att_vicino'],$this->nome($att),$nomearma).", ".sprintf($lang['danni_subiti'],($this->nome($dif).$potente.$pscudo),$danno)."<br/>";
        $this->Modsalute($dif,$danno);
    }else{// if he doesn't hit
        $input=sprintf($lang['niente_att_vicino'],$this->nome($att),$this->nome($dif),$nomearma)."<br/>";
    }
    $this->Modenergia($att,$energia);
    return $input;
    }// end Attaccolontano

	public function Allontanamento($chi){
	global $db,$lang;
	if($chi==1){$chi2=2;}else{$chi2=1;}
	if(($this->tattica($chi2,1)==3) OR (($this->tattica($chi2,1)==1) AND ($this->tattica($chi2,2)==2)) OR ($this->tattica($chi2,1)==4) OR ($this->esausto($chi2)==1)){
	$lontano=1;
	}else{//fine allontanarsi sicuro
	$prob=rand(1,100);
	if($chi==1){$prob-=30;}else{$prob+=30;}
	if($prob<30){$lontano=1;}else{$lontano=0;}
	}//fine allontanarsi non sicuro
	if($lontano==1){
	$output=" ";
	}else{//fine se riesce ad allontanarsi
	$output=sprintf($lang['non_riuscito_ad_allontanarsi'],$this->nome($chi))."<br/>";
	$this->che[$chi]->subtattica=1;
	}//fine se non riesce ad allontanarsi
	return $output;
	}//fine Allontanamento

} //fine classe Dati

function Battledo($battleid,$turni){
global $db,$adesso,$lang;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$expb=$battle['exp'];
$dc=new Dati();
$dc->Stabilisciordine($battle);
$expb=$dc->Checkeqipexp($expb);
if($turni==0){
$input.=$dc->Viewequip(1);
$input.=$dc->Viewequip(2);}
//$input.="Debug tattiche: ".$dc->tattica(1,2)." - ".$dc->tattica(2,2)."<br/>";//visualizzazione tattiche per debug
if($dc->tattica(1,1)!=2 AND $dc->tattica(2,1)!=2){
$dc->Controllastato(1);
$dc->Controllastato(2);

if($dc->tattica(1,1)==4){
$input.=$dc->Usapozione(1);
$expb+=1;
}elseif($dc->esausto(1)==1){
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(1))."<br/>";
}elseif($dc->tattica(1,1)==3){
$input.=sprintf($lang['resta_in_difesa'],$dc->nome(1))."<br/>";
}else{//inizio se attacco
if($dc->tattica(1,2)==2)
$input.=$dc->Allontanamento(1);
if($dc->tattica(1,2)==2)
$input.=$dc->Attaccolontano(1,2);
else
$input.=$dc->Attaccovicino(1,2);
}//fine se attacco
if($dc->tattica(2,1)==4){
$input.=$dc->Usapozione(2);
$expb+=1;
}elseif($dc->esausto(2)==1){
$input.=sprintf($lang['troppo_stanco_per_attacco'],$dc->nome(2))."<br/>";
}elseif($dc->tattica(2,1)==3){
$input.=sprintf($lang['resta_in_difesa'],$dc->nome(2))."<br/>";
}else{//inizio se attacco
if($dc->tattica(2,2)==2)
$input.=$dc->Allontanamento(2);
if($dc->tattica(2,2)==2)
$input.=$dc->Attaccolontano(2,1);
else
$input.=$dc->Attaccovicino(2,1);
}//fine se attacco

if($dc->che[1]->oggusati==1){
$input.=$dc->Controlloogg(1);}
if($dc->che[2]->oggusati==1){
$input.=$dc->Controlloogg(2);}
$input.="<br/>";

$dc->Aggiornastat(1);
$dc->Aggiornastat(2);
$dc->Controllastato(1);
$dc->Controllastato(2);
$expb=$dc->Checkturnexp($expb);

$turni++;
$input.="----------------<( ".($turni+1)." )>----------------";
Inreport($battleid,$input);
$input="";
Docombactstats($battleid,$dc->nome(1),$dc->nome(2),$dc->che[1]->car,$dc->che[2]->car);
}//se nessuno si arrende
$finito=1;
$vincitore=0;
if($dc->car(1,'saluteattuale')<1){//se il secondo vince
$vincitore=2;
$input.=sprintf($lang['vincitore_combattimento'],$dc->nome(2))."<br/>";
$rep=$dc->Checkrep(2);
if($rep[0]==1){
if($dc->cpu(2)==0){$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione+'".$rep[1]."' WHERE userid='".$dc->id(2)."' LIMIT 1");}}
}elseif($dc->car(2,'saluteattuale')<1){//se il primo vince
$vincitore=1;
$input.=sprintf($lang['vincitore_combattimento'],$dc->nome(1))."<br/>";
$rep=$dc->Checkrep(1);
if($rep[0]==1){
if($dc->cpu(1)==0){$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione+'".$rep[1]."' WHERE userid='".$dc->id(1)."' LIMIT 1");}}
}elseif($dc->esausto(1)==1 AND $dc->esausto(2)==1){//se entrambi esausti
$input=$lang['finito_entrambi_esausti']."<br/>";
}elseif($dc->tattica(1,1)==2 AND $dc->tattica(2,1)==2){//se entrambi si arrendono
$input=$lang['finito_entrambi_arresi']."<br/>";
}elseif($dc->tattica(1,1)==2){//se il primo si arrende
$vincitore=2;
$input.=sprintf($lang['finito_resa'],$dc->nome(1),$dc->nome(2))."<br/>";
$rep=$dc->Checkrep(1);
if($rep[0]==2){
if($dc->cpu(1)==0){$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione-'".$rep[1]."' WHERE userid='".$dc->id(1)."' LIMIT 1");}}
}elseif($dc->tattica(2,1)==2){//se il secondo si arrende
$vincitore=1;
$input.=sprintf($lang['finito_resa'],$dc->nome(2),$dc->nome(1))."<br/>";
$rep=$dc->Checkrep(2);
if($rep[0]==2){
if($dc->cpu(2)==0){$db->QueryMod("UPDATE caratteristiche SET reputazione=reputazione-'".$rep[1]."' WHERE userid='".$dc->id(2)."' LIMIT 1");}}
}elseif($turni==30 AND $battle['difcpu']==0){//se dura troppo e non è contro cpu
$input=$lang['combattimento_troppo_lungo']."<br/>";
}else{$finito=0;}
$db->QueryMod("UPDATE battle SET tatatt='0',tatatt2='0',tatdif='0',tatdif2='0' WHERE id='".$battleid."' LIMIT 1");
if($finito==1){
if($turni>1){
if($dc->cpu(1)==0){$input.=$dc->Guadagnaexp(1,$turni,$expb,$vincitore);}
if($dc->cpu(2)==0){$input.=$dc->Guadagnaexp(2,$turni,$expb,$vincitore);}
}//se più di un turno

if($vincitore!=0){
    // check also if isn't AI for exclude the case of same id of player
    if($battle['attid']==$dc->id($vincitore) AND $dc->cpu($vincitore)==0)
        $vincitore=1;
    else
        $vincitore=2;
}

Inreport($battleid,$input);
Endcombact($battle['id'],$vincitore);
}else{//continua
if($expb!=$battle['exp'] AND ($dc->tattica(1,1)!=3 OR $dc->tattica(2,1)!=3)){
$db->QueryMod("UPDATE battle SET exp='".$expb."' WHERE id='".$battleid."' LIMIT 1");}
$db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid,turni) VALUES ('0','".$adesso."','50','0','6','".$battleid."','".$turni."')");
}//fine continua
} //fine Battledo

function Endcombact($battleid,$vincitore){
global $db,$adesso,$lang,$config;
$battle=$db->QuerySelect("SELECT * FROM battle WHERE id='".$battleid."' LIMIT 1");
$link="<a href=\"index.php?loc=combact&amp;do=repview&amp;id=".$battleid."\">qui</a>";
$titolo="Combattimento finito";
$testo="Nella versione attuale non si pu&ograve; definire ancora un combattimento, per&ograve; usabile comunque per rilevare eventuali errori o problemi di alcuni sistemi in sviluppo che saranno alla base del sistema di combattimento, per visualizzare il report clicca ".$link;
$att=$battle['attid'];
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$att."','".$titolo."','".$testo."','0','".$adesso."')");
$dif=$battle['difid'];
if($battle['difcpu']==0){
$db->QueryMod("INSERT INTO messaggi (userid,titolo,testo,mittenteid,data) VALUES ('".$dif."','".$titolo."','".$testo."','0','".$adesso."')");
}else{
$cq=$db->QuerySelect("SELECT count(id) AS n FROM cachequest WHERE userid='".$att."'");
if($cq['n']>0){
$cq=$db->QuerySelect("SELECT * FROM cachequest WHERE userid='".$att."'");
if($cq['secondi']>0){
$caruser=$db->QuerySelect("SELECT saluteattuale FROM caratteristiche WHERE userid='".$att."'");
if($caruser['saluteattuale']>0){
Ritornoacasa($att,$cq['secondi']);
}//se non è morto
}//se esplorazione oltre confine
if($cq['questid']==5){
if($vincitore==1){
if($config['crimine']>10)
$db->QueryMod("UPDATE config SET crimine=crimine-'1'");
}//se vince la guardia
}//se guardia in ronda cittadina
$db->QueryMod("DELETE FROM cachequest WHERE userid='".$att."'");
}//se esiste cache quest
if($vincitore>0){$attn=$db->QuerySelect("SELECT username,monete FROM utenti WHERE userid='".$battle['attid']."' LIMIT 1");}
if($vincitore==1){
$carcpu=$db->QuerySelect("SELECT * FROM carcpu WHERE cpuid='".$dif."' LIMIT 1");
$db->QueryMod("UPDATE `utenti` SET `monete`=`monete`+'".$carcpu['monete']."' WHERE `userid`='".$att."' LIMIT 1");
$input=sprintf($lang['c_vince_monete'],$attn['username'],$carcpu['monete'])."<br/>";
}elseif($vincitore==2){//se vince contro cpu
$db->QueryMod("UPDATE `utenti` SET `monete`='0' WHERE `userid`='".$att."' LIMIT 1");
$db->QueryMod("UPDATE `carcpu` SET `monete`=`monete`+'".$attn['monete']."' WHERE `cpuid`='".$dif."' LIMIT 1");
$input=sprintf($lang['c_perde_monete'],$attn['username'],$attn['monete'])."<br/>";
}//se perde contro cpu
if($vincitore>0){Inreport($battleid,$input);}
if($vincitore==1){
$db->QueryMod("DELETE FROM carcpu WHERE cpuid='".$dif."' LIMIT 1");
$db->QueryMod("DELETE FROM equipagcpu WHERE cpuid='".$dif."' LIMIT 1");
$db->QueryMod("DELETE FROM equipcpu WHERE cpuid='".$dif."'");
}else{//se non vince utente
$db->QueryMod("UPDATE `carcpu` SET `inuso`='0' WHERE `cpuid`='".$dif."' LIMIT 1");
}
}//se cpu
$db->QueryMod("DELETE FROM eventi WHERE battleid='".$battleid."'");
$db->QueryMod("DELETE FROM battle WHERE id='".$battleid."'");
$db->QueryMod("UPDATE battlereport SET finito='1' WHERE id='".$battleid."' LIMIT 1");
} //fine Endcombact

function Startcombact($attaccante,$dif,$cpu){
    global $db,$adesso,$lang,$log;
    if($cpu==1){
        $difcar=$db->QuerySelect("SELECT * FROM carcpu WHERE cpuid='".$dif."' LIMIT 1");
        $difensore=$difcar['pid'];
        $db->QueryMod("UPDATE `carcpu` SET `inuso`='1' WHERE `cpuid`='".$dif."' LIMIT 1");
    }
    // create battle record
    $db->QueryMod("INSERT INTO battle (attid,difid,difcpu) VALUES ('".$attaccante."','".$dif."','".$cpu."')");
    // select the id of record of battle created
    $battle=$db->QuerySelect("SELECT id FROM battle WHERE attid='".$attaccante."' LIMIT 1");
    // create event record of first battle round not assigned to any user
    $db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,battleid) VALUES ('0','".$adesso."','50','0','6','".$battle['id']."')");
    // create battle event record for the attacker user, that will be delete only on battle end
    $db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$attaccante."','".$adesso."','84600','13','5','".$difensore."','".$battle['id']."')");
    $attn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$attaccante."' LIMIT 1");
    $attcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$attaccante."' LIMIT 1");
    if($cpu==0){
        $db->QueryMod("INSERT INTO battlereport (id,data,attid,difid) VALUES ('".$battle['id']."','".$adesso."','".$attaccante."','".$dif."')");
        $difn=$db->QuerySelect("SELECT username FROM utenti WHERE userid='".$dif."' LIMIT 1");
        $difcar=$db->QuerySelect("SELECT * FROM caratteristiche WHERE userid='".$dif."' LIMIT 1");
        $difname=$difn['username'];
        // create battle event record for the defender user, that will be delete only on battle end
        $db->QueryMod("INSERT INTO eventi (userid,datainizio,secondi,dettagli,tipo,oggid,battleid) VALUES ('".$dif."','".$adesso."','84600','13','5','".$attaccante."','".$battle['id']."')");
        // create log record of start battle for defender
        $parlog=array(0=>$attn['username'],1=>$battle['id']);
        $log->Utenti($dif,12,$parlog);
    }else{
        $db->QueryMod("INSERT INTO battlereport (id,data,attid,cpuid) VALUES ('".$battle['id']."','".$adesso."','".$attaccante."','".$difensore."')");
        $difname=$lang['nomepcpu'.$difensore];
    }
    // create log record of start battle for attacker
    $parlog=array(0=>$difname,1=>$battle['id']);
    $log->Utenti($attaccante,12,$parlog);
    Docombactstats($battle['id'],$attn['username'],$difname,$attcar,$difcar);
} //fine Startcombact

function Docombactstats($battleid,$attaccante,$difensore,$attcar,$difcar){
global $db,$lang;
$server=$db->database;
umask(0000);
$fp=fopen("inclusi/log/report/".$server."/".$battleid.".log","a+");
$repinput.="<tr><td>";
$repinput.=$attaccante."<br/>";
$percsalute=100/$attcar['salute']*$attcar['saluteattuale'];
$salute=testosalute($percsalute);
$percenergia=100/$attcar['energiamax']*$attcar['energia'];
$energia=testoenergia($percenergia);
$repinput.=$lang['Salute'].": ".$salute."<br/>";
$repinput.=$lang['Energia'].": ".$energia."<br/>";
$repinput.="</td><td>";
$repinput.=$difensore."<br/>";
$percsalute=100/$difcar['salute']*$difcar['saluteattuale'];
$salute=testosalute($percsalute);
$percenergia=100/$difcar['energiamax']*$difcar['energia'];
$energia=testoenergia($percenergia);
$repinput.=$lang['Salute'].": ".$salute."<br/>";
$repinput.=$lang['Energia'].": ".$energia."<br/>";
$repinput.="</td></tr>";
fputs($fp,$repinput);
} //fine Docombactstats

function Inreport($battleid,$input){
global $db;
$server=$db->database;
umask(0000);
$fp=fopen("inclusi/log/report/".$server."/".$battleid.".log","a+");
$repinput.="<tr><td colspan=\"2\">";
$repinput.=$input;
$repinput.="</td></tr>";
fputs($fp,$repinput);
} //fine Inreport

function Inizializzanpc($difensore){
global $db;
$cpud=$db->QuerySelect("SELECT * FROM pcpudata WHERE id='".$difensore."' LIMIT 1");
$db->QueryMod("INSERT INTO carcpu (pid,livello,salute,saluteattuale,energia,energiamax,mana,manarimasto,attfisico,attmagico,diffisica,difmagica,agilita,velocita,intelligenza,destrezza,monete) VALUES ('".$difensore."','".$cpud['livello']."','".$cpud['salute']."','".$cpud['salute']."','".$cpud['energia']."','".$cpud['energia']."','".$cpud['mana']."','".$cpud['mana']."','".$cpud['attfisico']."','".$cpud['attmagico']."','".$cpud['diffisica']."','".$cpud['difmagica']."','".$cpud['agilita']."','".$cpud['velocita']."','".$cpud['intelligenza']."','".$cpud['destrezza']."','".$cpud['monete']."')");
$idcpu=$db->QuerySelect("SELECT cpuid FROM carcpu ORDER BY cpuid DESC");
$db->QueryMod("INSERT INTO equipagcpu (cpuid,cac,arm,scu,poz,adi) VALUES ('".$idcpu['cpuid']."','".$cpud['eqcac']."','".$cpud['eqarm']."','".$cpud['eqscu']."','".$cpud['eqpoz']."','".$cpud['eqadi']."')");
if($cpud['eqcac']!=0){$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$idcpu['cpuid']."','".$cpud['eqcac']."')");}
if($cpud['eqarm']!=0){$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$idcpu['cpuid']."','".$cpud['eqarm']."')");}
if($cpud['eqscu']!=0){$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$idcpu['cpuid']."','".$cpud['eqscu']."')");}
if($cpud['eqpoz']!=0){$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$idcpu['cpuid']."','".$cpud['eqpoz']."')");}
if($cpud['eqadi']!=0){$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$idcpu['cpuid']."','".$cpud['eqadi']."')");}
return $idcpu['cpuid'];
} //fine Inizializzanpc

function Npcesistente($difensore){
global $db;
$se=$db->QuerySelect("SELECT COUNT(cpuid) AS n FROM carcpu WHERE pid='".$difensore."' AND inuso='0'");
if($se['n']>0){
$cpud=$db->QuerySelect("SELECT * FROM carcpu WHERE pid='".$difensore."' AND inuso='0' LIMIT 1");
$id=$cpud['cpuid'];
$cpueq=$db->QuerySelect("SELECT * FROM equipagcpu WHERE cpuid='".$id."' LIMIT 1");
$cpuid=$db->QuerySelect("SELECT * FROM pcpudata WHERE id='".$difensore."' LIMIT 1");
$db->QueryMod("UPDATE carcpu SET saluteattuale='".$cpuid['salute']."',energia='".$cpuid['energia']."' WHERE cpuid='".$id."' LIMIT 1");
if( ($cpuid['eqcac']!=0 AND $cpueq['cac']==0) OR ($cpuid['eqarm']!=0 AND $cpueq['arm']==0) OR ($cpuid['eqscu']!=0 AND $cpueq['scu']==0) OR ($cpuid['eqpoz']!=0 AND $cpueq['poz']==0) OR ($cpuid['eqadi']!=0 AND $cpueq['adi']==0) ){
if($cpuid['eqcac']!=0 AND $cpueq['cac']==0){
$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$id."','".$cpuid['eqcac']."')");
}
if($cpuid['eqarm']!=0 AND $cpueq['arm']==0){
$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$id."','".$cpuid['eqarm']."')");
}
if($cpuid['eqscu']!=0 AND $cpueq['scu']==0){
$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$id."','".$cpuid['eqscu']."')");
}
if($cpuid['eqpoz']!=0 AND $cpueq['poz']==0){
$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$id."','".$cpuid['eqpoz']."')");
}
if($cpuid['eqadi']!=0 AND $cpueq['adi']==0){
$db->QueryMod("INSERT INTO equipcpu (cpuid,oggid) VALUES ('".$id."','".$cpuid['eqadi']."')");
}
$db->QueryMod("UPDATE equipagcpu SET cac='".$cpuid['eqcac']."',arm='".$cpuid['eqarm']."',scu='".$cpuid['eqscu']."',poz='".$cpuid['eqpoz']."',adi='".$cpuid['eqadi']."' WHERE cpuid='".$id."' LIMIT 1");
}//se ha perso qualche equipaggiamento
}else{$id=0;}
return $id;
} //fine Npcesistente
