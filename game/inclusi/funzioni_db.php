<?php

class ConnessioniMySQL {

	var $database; //da settare dopo il require -- $db->database=1;
	var $suffix = "unrealff_rpg";
	var $dbname = "";
	var $server = "localhost";
	var $dbuser = "rpg";
	var $dbpass = "3sWBVeNJN4YbB5MQ";

	function Config () {		
		switch($this->database) {
			case 0:
				$this->dbname = $this->suffix."0";			
				break;
			case 999:
				$this->dbname = $this->suffix."999";	
				break;
		}
		return $dati;
	}
	function QuerySelect ($arg) { //$var=$db->QuerySelect("SELECT * FROM table");	
		$dati=$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$query="$arg";
		$result=mysql_query($query,$connect);
		$var=mysql_fetch_array($result);
		mysql_close($connect);
		return $var;
	}
	function QueryMod ($arg) { //$db->QueryMod("UPDATE table SET colonna='1'");	
		$dati=$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$query="$arg";
		$result=mysql_query($query,$connect);
		mysql_close($connect);	
	}	
	function QueryCiclo ($arg) { //$guarda_bene=$db->QueryCiclo("SELECT * FROM table"); -- collegata a quella di sotto
		$dati=$this->Config();
		$connect=mysql_connect($this->server,$this->dbuser,$this->dbpass);
		mysql_select_db($this->dbname,$connect);
		$query="$arg";
		$result=mysql_query($query,$connect);
		if(!$result)
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