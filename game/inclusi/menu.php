<?php
$snm=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");

class Menu{

	public $sezioni;
	private $dati=array(
	'situazione'=>'Situazione',
	'citta'=>array('banca'=>'Banca','tempio'=>'Tempio','mercato'=>'Mercato','locanda'=>'Locanda','municipio'=>'Municipio'),
	'lavori'=>array('miniera'=>'Miniera','laboratorio'=>'Laboratorio','fucina'=>'Fucina'),
	'magia'=>array('rocca'=>'Rocca_arcano','libro'=>'Libro_incantesimi'),
	'regno'=>array('confini'=>'Confini'),
	'combact'=>'Combattimenti',
	'oggetti'=>array('inventario'=>'Inventario','equipaggiamento'=>'Equipaggiamento'),
	'messaggi'=>'Messaggi',
	'utenti'=>'Lista_utenti',
	'info'=>array('guida'=>'Guida','changelog'=>'Changelog'),
	'opzioni'=>'Opzioni',
	'logout'=>'Logout'
	);
	private $menu;
	
	public function Sm($sm){//genera e restituisce i dati del sottomenu di testo
		foreach($this->dati[$sm] as $chiave=>$elemento){
		$this->menu='';//azzera eventuale precedente
		$this->Sv($chiave,$elemento);
		$link[]=$this->menu;
		}//per dato
		return $link;
	}
	
	function __construct() {
		foreach($this->dati as $chiave=>$elemento){
		if(is_array($elemento)){
		foreach($elemento as $chiave2=>$elemento2){
		$this->sezioni[]=$chiave2;
		}//per ogni elemento dell'array
		}else{//se è un array
		$this->sezioni[]=$chiave;
		}//se non è array
		}//per dato
	}
	
	public function View($tipo,$dato){//genera e restituisce la visualizzazione del menu
		$this->menu='';//azzera eventuale precedente
		if($tipo=='v'){
		$this->Sv($dato,$this->dati[$dato]);
		}elseif($tipo=='m'){
		$this->Mv($dato);
		}
		echo $this->menu;
	}
	
	private function Sv($n,$l){//genera un valore singolo
		global $lang;
		$this->menu.='<a href="index.php?loc='.$n.'">'.$lang[$l].'</a>';
	}
	
	private function Mv($s){//genera un sottomenu
		global $lang;
		$this->menu.='<ul><li><a href="index.php?loc=submenu&amp;menu='.$s.'">'.$lang[$s].'</a><ul>';
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