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

$result = query("SELECT p.*, a1.Nome as a1Name, a2.Nome as a2Name, d1.Nome as d1Name, d2.Nome as d2Name FROM partite AS p JOIN giocatori AS a1 ON a1.ID = Att1 JOIN giocatori AS a2 ON a2.ID = Att2 JOIN giocatori AS d1 ON d1.ID = Dif1 JOIN giocatori AS d2 ON d2.ID = Dif2 ORDER BY Timestamp DESC LIMIT 1");
$row = mysqli_fetch_assoc($result);
?>

<div align="center">
<div class="width70" align="center">
    <p class="w3-blue w3-card-4 w3-large">
        Conferma eliminazione:
    </p>
<form method="post" action="delev.php">
<input type="hidden" name="delId" value="<?php echo $row["ID"]; ?>" />
<input type="hidden" name="VarA1" value="<?php echo $row["VarA1"]; ?>" />
<input type="hidden" name="VarA2" value="<?php echo $row["VarA2"]; ?>" />
<input type="hidden" name="VarD1" value="<?php echo $row["VarD1"]; ?>" />
<input type="hidden" name="VarD2" value="<?php echo $row["VarD2"]; ?>" />
<input type="hidden" name="idA1" value="<?php echo $row["Att1"]; ?>" />
<input type="hidden" name="idA2" value="<?php echo $row["Att2"]; ?>" />
<input type="hidden" name="idD1" value="<?php echo $row["Dif1"]; ?>" />
<input type="hidden" name="idD2" value="<?php echo $row["Dif2"]; ?>" />
    <div class="w3-card-4 w3-padding width40 float">
    	<p class="w3-blue w3-card-4 w3-large">
    		Squadra vincente
    	</p>
    
    	<label>Attaccante</label><br />
    	<h2><b><?php echo $row["a1Name"]; ?></b></h2><br />
    
    
        <label>Difensore</label><br />
        <h2><b><?php echo $row["d1Name"]; ?></b></h2><br />
        
        <label>Punti</label><br />
        <h2><b><?php echo $row["Pt1"]; ?></b></h2>
    </div>
    <div class="width20collapse float">Placeholder</div>
    <div class="w3-card-4 width40 w3-padding float">
    	<p class="w3-red w3-card-4 w3-large">
			Squadra perdente
        </p>
    
    
        <label>Attaccante</label><br />
        <h2><b><?php echo $row["a2Name"]; ?></b></h2><br />
        
        
        <label>Difensore</label><br />
        <h2><b><?php echo $row["d2Name"]; ?></b></h2><br />
        
        <label>Punti</label><br />
        <h2><b><?php echo $row["Pt2"]; ?></b></h2>
        
    </div>
    <label>Ora</label><br />
    <h2><b><?php echo $row["Timestamp"]; ?></b></h2>
    <a href="allmatch.php"><button class="w3-button w3-blue" type="button">« Indietro</button></a>
    <br /><br />
    <button class="w3-button w3-blue" type="submit">Elimina »</button>
</form>    
</div>
</div>
<br /><br />
</body>
</html>