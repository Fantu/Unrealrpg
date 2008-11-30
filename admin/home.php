<div align="justify">
<h3><?php echo $lang['pannello_amministrazione']; ?></h3>
<br/>
<br/>
<strong>Situazione server</strong><br/>
<?php foreach($game_server as $chiave=>$elemento){ 
echo $elemento." - ".$game_language[$game_server_lang[$chiave]]."<br/>";
$db->database=$chiave;
$utenti=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti");
echo "Utenti registrati: ".$utenti['id'].", ";
$seonline=$adesso-600;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
echo "Utenti online: ".$online['id'].", ";
$seonline=$adesso-86400;
$online=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione>'".$seonline."'");
echo "Utenti online ultime 24 ore: ".$online['id'].", ";
$seonline=$adesso-604800;
$inattivi=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE ultimazione<'".$seonline."'");
echo "Utenti inattivi (7 giorni): ".$inattivi['id'].", ";
$plus=$db->QuerySelect("SELECT COUNT(*) AS id FROM utenti WHERE plus>'0'");
echo "Account plus: ".$plus['id']."<br/><br/>";
}/* fine per ogni server*/ ?>
<br/>
<br/>
<strong>Changelog</strong><br/>
<br/>
<p><strong>1.0.5</strong> - 30/11/08<br />
- Migliorato il sistema di spedizione mail news<br />
</p>
<p><strong>1.0.4</strong> - 24/05/08<br />
- Iniziata creazione situazione server in home<br />
</p>
<p><strong>1.0.3</strong> - 31/05/08<br />
- Iniziata creazione spedizione mail news<br />
</p>
<p><strong>1.0.2</strong> - 05/04/08<br />
- Aggiunto controllo file log di sistema<br />
</p>
<p><strong>1.0.1</strong> - 20/03/08<br />
- Aggiunta la chiusura e apertura di tutti i server contemporaneamente<br />
- Aggiunto l'aggiornamento del db di tutti i server in contemporanea<br />
</p>
<p><strong>1.0.0</strong> - 19/03/08<br />
- Completato e pronto all'uso<br />
</p>
</div>