<?php
class ConnessioniMySQL{

	public $database;
	private $suffix="unrealff_rpg";
	private $dbname;
	private $server="localhost";
	private $dbuser="rpg";
	private $dbpass="3sWBVeNJN4YbB5MQ";
	private $errorlog="/game/inclusi/log/mysql.log";//path da quella base per il file log errori query
	public $nquery;
	private $connect;
	
	function __construct(){
       $this->nquery=0;
	   $this->database=-1;
	}
	
	function __destruct(){
		mysql_close($this->connect);
	}
	
	public function Setdb($d){//$db->Setdb(1); impostare il db da utilizzare
		if($this->database==-1){
		$this->database=$d;
		$this->dbname=$this->suffix.$this->database;
		$this->connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		}else{
		$this->database=$d;
		$this->dbname=$this->suffix.$this->database;
		}
		mysql_select_db($this->dbname,$this->connect);
	}

	private function StampaErroreMysql($query,$err,$mess){
	$data=date("d/m/y - H:i")." - Db:".$this->database." - ".$query;
	$fp=fopen(MAIN_PATH.$this->errorlog,"a+");
	fputs($fp,$data."\r\n--------\r\n".$err.": ".$mess."\r\n\r\n");
	fclose($fp);
	}
	public function QuerySelect($query){//$var=$db->QuerySelect("SELECT * FROM table");
		$result=mysql_query($query,$this->connect);
		$this->nquery++;
		if(!$result){$this->StampaErroreMysql($query,mysql_errno(),mysql_error());
		}else{
		$var=mysql_fetch_array($result);
		if(!$var){$this->StampaErroreMysql($query,mysql_errno(),mysql_error());}
		}//se query esatta
		return $var;
	}
	public function QueryMod($query){//$db->QueryMod("UPDATE table SET colonna='1'");
		$result=mysql_query($query,$this->connect);
		$this->nquery++;
		if(!$result){$this->StampaErroreMysql($query,mysql_errno(),mysql_error());}
	}
	public function QueryCiclo($query){//$guarda_bene=$db->QueryCiclo("SELECT * FROM table"); -- collegata a quella di sotto
		$result=mysql_query($query,$this->connect);
		$this->nquery++;
		if(!$result){$this->StampaErroreMysql($query,mysql_errno(),mysql_error());}
		return $result;
	}
	public function QueryCicloResult($result){//while($var=$db->QueryCicloResult($guarda_bene)) -- collegata a quella di sopra
		$var=mysql_fetch_array($result);
		return $var;
	}
	public function Dbdump($sqlfile){
		$backup="mysqldump -u ".$this->dbuser." --password=".$this->dbpass." ".$this->dbname." --skip-extended-insert > ".$sqlfile;
		exec($backup);
	}

}//fine ConnessioniMySQL
?>