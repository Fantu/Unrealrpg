<?php
class ConnessioniMySQL{

	public $database; //$db->database=1; da settare dopo l'inclusione di questa classe e la creazione di un nuovo oggetto
	private $suffix="unrealff_rpg";
	private $dbname;
	private $server="localhost";
	private $dbuser="rpg";
	private $dbpass="3sWBVeNJN4YbB5MQ";
	private $errorlog="/game/inclusi/log/mysq.log";//path completa file log errori query

	private function StampaErroreMysql($query,$err,$mess){
	$data=date("d/m/y - H:i")." - Db:".$this->database." - ".$query;
	/*$file="inclusi/log/mysql.log";
	if(!file_exists($file)){
    $file="game/inclusi/log/mysq.log";
    if(!file_exists($file)){
    $file="../game/inclusi/log/mysql.log";}}*/
	$fp=fopen(MAIN_PATH.$this->errorlog,"a+");
	fputs($fp,$data."\r\n--------\r\n".$err.": ".$mess."\r\n\r\n");
	fclose($fp);
	}
	private function Config(){
		$this->dbname=$this->suffix.$this->database;
	}
	public function QuerySelect($query){//$var=$db->QuerySelect("SELECT * FROM table");
		global $numquery;
		$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$result=mysql_query($query,$connect);
		$numquery++;
		if(!$result){
			$error=mysql_error();
			$errorn=mysql_errno();
			$this->StampaErroreMysql($query,$errorn,$error);
		}
		$var=mysql_fetch_array($result);
		if(!$var){
			$error=mysql_error();
			$errorn=mysql_errno();
			$this->StampaErroreMysql($query,$errorn,$error);
		}
		mysql_close($connect);
		return $var;
	}
	public function QueryMod($query){//$db->QueryMod("UPDATE table SET colonna='1'");
		global $numquery;
		$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$result=mysql_query($query,$connect);
		$numquery++;
		if(!$result){
			$error=mysql_error();
			$errorn=mysql_errno();
			$this->StampaErroreMysql($query,$errorn,$error);
		}
		mysql_close($connect);
	}
	public function QueryCiclo($query){//$guarda_bene=$db->QueryCiclo("SELECT * FROM table"); -- collegata a quella di sotto
		global $numquery;
		$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$result=mysql_query($query,$connect);
		$numquery++;
		if(!$result){
			$error=mysql_error();
			$errorn=mysql_errno();
			$this->StampaErroreMysql($query,$errorn,$error);
		}
		mysql_close($connect);
		return $result;
	}
	public function QueryCicloResult($result){//while($var=$db->QueryCicloResult($guarda_bene)) -- collegata a quella di sopra
		$var=mysql_fetch_array($result);
		return $var;
	}
	public function Dbdump($sqlfile){
		$this->Config();
		$backup="mysqldump -u ".$this->dbuser." --password=".$this->dbpass." ".$this->dbname." --skip-extended-insert > ".$sqlfile;
		exec($backup);
	}

}//fine ConnessioniMySQL
?>