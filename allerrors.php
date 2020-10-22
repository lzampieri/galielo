<div align="center">
<?php
if(isset($_GET["err"])) {
?>
	<div class="w3-card w3-red w3-margin-top width40">Errore generico</div> <br/><br/>
<?php
} else if(isset($_GET["saved"])){
?>
	<div class="w3-card w3-green w3-margin-top width40">Classifica aggiornata con successo!</div> <br/><br/>
<?php
} else if(isset($_GET["newccup"])){
?>
	<div class="w3-card w3-green w3-margin-top width40">Classifica aggiornata con successo: abbiamo una nuova coppia di campioni</div> <br/><br/>
<?php
} else if(isset($_GET["signedup"])) { ?>
	<div class="w3-card w3-green w3-margin-top width40">Iscrizione riuscita.</div><br/>
<?php
} else if(isset($_GET["err_punt"])) { ?>
	<div class="w3-card w3-red w3-margin-top width40">Errore: impossibile eliminare la partita.</div><br/>
<?php
} else if(isset($_GET["deleted"])) { ?>
	<div class="w3-card w3-green w3-margin-top width40">Partita eliminata correttamente.</div><br/>
<?php
}
?>
</div>