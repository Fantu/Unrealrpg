<?php

class ConnessioniMySQL {

	var $database; //da settare dopo il require -- $db->database=1;
	var $suffix="unrealff_rpg";
	var $dbname;
	var $server="localhost";
	var $dbuser="rpg";
	var $dbpass="3sWBVeNJN4YbB5MQ";

	function StampaErroreMysql($query,$err,$mess) {
	$data = date("d/m/y - H:i")." ".$query;
	$file="inclusi/log/mysql.log";
	if (!file_exists($file)){
    $file = "game/inclusi/log/mysq.log";
    if (!file_exists($file)){
    $file="../game/inclusi/log/mysql.log";}}
	$fp=fopen($file,"a+");
	fputs($fp,$data."\r\n--------\r\n".$err.": ".$mess."\r\n\r\n");
	fclose($fp);
	}
	
	function Config () {
		$this->dbname=$this->suffix.$this->database;
	}
	function QuerySelect ($query) { //$var=$db->QuerySelect("SELECT * FROM table");	
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
	function QueryMod ($query) { //$db->QueryMod("UPDATE table SET colonna='1'");	
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
	function QueryCiclo ($query) { //$guarda_bene=$db->QueryCiclo("SELECT * FROM table"); -- collegata a quella di sotto
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
	function QueryCicloResult ($result) { //while($var=$db->QueryCicloResult($guarda_bene)) -- collegata a quella di sopra
		$var=mysql_fetch_array($result);
		return $var;	
	}	
	function ToSQL($valore,$tipo) {	//formatto la $var nel modo giusto. ES: $db->ToSQL($variabile,"stringa");
		switch($tipo) {
			case 'stringa':
				return "'".addslashes($valore)."'";
				break;
			case 'numero':
				return doubleval(str_replace(",", ".", $valore));
				break;
			case 'booleano':
				if(is_bool($valore))
					return $valore;
				else if(is_numeric($valore))
					return intval($valore);
				else
					return addslashes($valore);
				break;															
		}
	} // stringa, numero, booleano
	function ToStringa($valore) {	//restituisce la stringa formattata ES: $db->ToStringa($variabile);
		return addslashes($valore);
	} // stringa, numero, booleano

}

?>