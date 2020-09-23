<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="css/w3.css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />


<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<?php
require_once("script/utilities.php");
?>

</head>

<body class="w3-light-grey">

<?php
require("header.php");

require_once("script/utilities.php");
$select = "";
$result = query("SELECT * FROM giocatori ORDER BY Nome");
while( $row = mysqli_fetch_assoc($result) ) {
	$select .= ("<option value=\"".$row["ID"]."\">".$row["Nome"]."</option>\n");
}
?>

<form method="post" action="confirm.php">
<div align="center">

<?php
if(isset($_GET["err"])) { ?>
	<div class="w3-card w3-red w3-margin-top width40">Errore: riprova</div><br/>
<?php
} else if(isset($_GET["err_punt"])) { ?>
	<div class="w3-card w3-red w3-margin-top width40">Errore: impossibile stabilire la squadra vincente.</div><br/>
<?php
} else if(isset($_GET["err_gioc"])) { ?>
	<div class="w3-card w3-red w3-margin-top width40">Errore: ubiquità di giocatori.</div><br/>
<?php
}

$canmatch = trim(file_get_contents("conf/matchenable.txt"));
if($canmatch == 0) { ?>
	<div class="w3-card w3-red w3-margin-top width40">Al momento l'aggiunta di nuove partite è sospesa. Ci scusiamo per il disagio, riprova tra qualche minuto.</div><br/>
<?php
}
?>
<div class="width70" align="center">
	
    <div class="w3-card-4 w3-padding width40 float w3-margin-bottom">
    <p class="w3-blue w3-card-4 w3-large">Squadra sfidante</p>
    
    <label>Attaccante</label>
    <select class="w3-select w3-margin-bottom" name="att1">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <label>Difensore</label>
    <select class="w3-select w3-margin-bottom" name="dif1">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <label>Punti</label><br/>
    <input type="number" name="sq1" />
    </div>
    <div class="width20collapse float">Placeholder</div>
    <div class="w3-card-4 width40 w3-padding float w3-margin-bottom">
    <p class="w3-blue w3-card-4 w3-large">Squadra sfidata</p>
    
    <label>Attaccante</label>
    <select class="w3-select w3-margin-bottom" name="att2">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <label>Difensore</label>
    <select class="w3-select w3-margin-bottom" name="dif2">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <label>Punti</label><br/>
    <input type="number" name="sq2" />
    </div>
    Si ricorda che, in caso di vittoria ai vantaggi, è necessario inserire il punteggio 10-9.<br/><br/>
    <a href="index.php"><button class="w3-button w3-blue" type="button">« Indietro</button></a>
    <br /><br />
    <button class="w3-button w3-blue" type="submit">Salva »</button>
    
</div>
</div>
</form>
<br /><br />
</body>
</html>