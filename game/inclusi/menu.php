<?php
$snm=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");

class Menu{

	public $sezioni;
	private $dati=array(
	'situazione'=>'Situazione',
	'citta|Citta'=>array('banca'=>'Banca','tempio'=>'Tempio','mercato'=>'Mercato','locanda'=>'Locanda','municipio'=>'Municipio')
	);
	private $menu;
	
	public function View(){//genera e restituisce la visualizzazione del menu
		foreach($this->dati as $chiave=>$elemento){
		if(is_array($elemento)){
		$this->Mv($chiave);
		foreach($elemento as $chiave2=>$elemento2){
		$this->sezioni[]=$chiave2;
		}//per ogni elemento dell'array
		}else{//se è un array
		if($chiave!='S'){
		$this->sezioni[]=$chiave;
		$this->Sv($chiave,$elemento);
		}
		}//se non è array
		}//per dato
		return $this->menu;
	}
	
	private function Sv($n,$l){//genera un valore singolo
		$this->menu.='<a href="index.php?loc='.$n.'">'.$lang[$l].'</a>';
	}
	
	private function Mv($s){//genera un sottomenu
		$v=explode("|",$s);
		$this->menu.='<ul><li><a href="index.php?loc=submenu&amp;menu='.$v[0].'">'.$lang[$v[1]].'</a><ul>';
		foreach($this->dati[$s] as $chiave=>$elemento){
		$this->menu.='<li>';
		$this->Sv($chiave,$elemento);
		$this->menu.='</li>';
		}//per ogni elemento dell'array
		$this->menu.='</ul></li></ul>';
	}

}//fine Menu

$menu=new Menu();

require('template/int_menu.php');
?>