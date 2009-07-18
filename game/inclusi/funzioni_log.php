<?php
class Logdb{

	private function InParInMsgUtente($msg,$parametri){
		global $lang;
		$parametri=explode("|",$parametri);
		foreach($parametri AS $el){
		$p=explode("#",$el);
		if(strstr($p[1], "$")){
		$p[1]=substr($p[1],1);
		$p[1]=$lang[$p[1]];
		}
		$msg=str_replace("{".$p[0]."}",$p[1],$msg);
		}
		return $msg;
	}
	private function ParametriInDb($parametri){
		$p=1;
		foreach($parametri AS $key=>$el){
		if($p==1){
			$p=0;
		}else{
			$par.="|";
		}
		$par.=$key."#".$el;
		}
		return $par;
	}
	public function Utenti($userid,$n,$parametri=0){ //$log->Utenti($userid,1,$parametri); dove 1 è il msg equivalente e parametri è facoltativo nel caso bisogna passargli parametri
		global $db,$adesso;
		if(is_array($parametri)){$pardb=$this->ParametriInDb($parametri);}else{$pardb=0;}
		if(strlen($pardb)>199){$this->Sistema("Bisogna aumentare il campo parametri della tabella logutenti");}
		$db->QueryMod("INSERT INTO logutenti (userid,msg,parametri,data) VALUES ('".$userid."','".$n."','".$pardb."','".$adesso."')");
	}
	public function Sistema($msg){ //$log->Sistema("Messaggio di debug"); eventuali parametri devono essere preinclusi nel msg
		global $db,$adesso;
		$db->QueryMod("INSERT INTO logsistema (msg,data) VALUES ('".$msg."','".$adesso."')");
	}
	public function VisualizzaMsgUtente($id){ //$log->VisualizzaMsgUtente($id);
		global $db,$adesso,$lang;
		$record=$db->QuerySelect("SELECT * from logutenti where id='".$id."' LIMIT 1");
		$msg=$lang['msglog'.$record['msg']];
		if($record['parametri']!="0"){$msg=$this->InParInMsgUtente($msg,$record['parametri']);}
		return $msg;
	}

}
?>