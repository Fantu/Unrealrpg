<?php
$snm=$db->QuerySelect("SELECT COUNT(*) AS id FROM messaggi WHERE userid='".$user['userid']."' AND letto=0");

class Menu{

	public $sezioni=array('mostraoggetto','visualizzautente','levelup','submenu','archiviorep');//sezioni "speciali"
	private $dati=array(
	'situazione',
	'citta'=>array('banca','tempio','mercato','locanda','municipio'),
	'lavori'=>array('miniera','laboratorio','fucina'),
	'magia'=>array('rocca','libro'),
	'regno'=>array('confini'),
	'combact',
	'oggetti'=>array('inventario','equipaggiamento'),
	'messaggi',
	'utenti',
	'info'=>array('guida','changelog'),
	'opzioni',
	'logout'
	);
	private $menu;
	public $inmenu;
	
	function __construct() {
		foreach($this->dati as $chiave=>$el){
		if(is_array($elemento)){
		foreach($elemento as $el2){
		$this->sezioni[]=$el2;
		$this->inmenu[]=$el2;
		}//per ogni elemento dell'array
		}else{//se è un array
		$this->sezioni[]=$el;
		$this->inmenu[]=$el;
		}//se non è array
		}//per dato
	}
	
	public function Sm($sm){//genera e restituisce i dati del sottomenu di testo
		foreach($this->dati[$sm] as $el){
		$this->menu='';//azzera eventuale precedente
		$this->Sv($el);
		$link[]=$this->menu;
		}//per dato
		return $link;
	}
	
	public function View($tipo,$dato){//genera e restituisce la visualizzazione del menu
		$this->menu='';//azzera eventuale precedente
		if($tipo=='v'){
		$this->Sv($dato);
		}elseif($tipo=='m'){
		$this->Mv($dato);
		}
		echo $this->menu;
	}
	
	private function Sv($n){//genera un valore singolo
		global $lang;
		$this->menu.='<a href="index.php?loc='.$n.'">'.$lang[$n].'</a>';
	}
	
	private function Mv($s){//genera un sottomenu
		global $lang;
		$this->menu.='<ul><li><a href="index.php?loc=submenu&amp;menu='.$s.'">'.$lang[$s].'</a><ul>';
		foreach($this->dati[$s] as $el){
		$this->menu.='<li>';
		$this->Sv($el);
		$this->menu.='</li>';
		}//per ogni elemento dell'array
		$this->menu.='</ul></li></ul>';
	}

}//fine Menu

$menu=new Menu();

require('template/int_menu.php');
?>