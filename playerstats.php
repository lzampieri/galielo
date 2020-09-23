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
if(!isset($_GET["id"])) {
	header("location: index.php");
	exit();
	}
$id = $_GET["id"];
$pointbadge = trim(file_get_contents('conf/puntibadge.txt'));
?>

</head>

<body class="w3-light-grey">

<?php
require("header.php");

$select = "";
$result = query("SELECT * FROM giocatori WHERE ID = $id");
if(mysqli_num_rows($result) != 1) {
	header("location: index.php");
	exit();
}
$gioc = mysqli_fetch_assoc($result);
?>

<div align="center">

<div class="w3-card w3-blue w3-margin-top width40 w3-xxlarge"><?php
echo $gioc["Nome"]."<br/>".round(($gioc["PuntiA"]+$gioc["PuntiD"])/2); 
if(round(($gioc["PuntiA"]+$gioc["PuntiD"])/2) >= $pointbadge) echo "<i class=\"fas fa-crown\"></i> ";
?></div><br/>


<div class="width70" align="center">
	
    <div class="w3-card-4 w3-padding width40 float w3-margin-bottom">
    <?php
	$infoatt1 = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM partite WHERE Att1 = $id"))["cc"];
	$infoatt2 = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM partite WHERE Att2 = $id"))["cc"];
	?>
    <p class="w3-blue w3-card-4 w3-large">
    Attaccante<br/><?php echo $gioc["PuntiA"];
    if($gioc["PuntiA"] >= $pointbadge) echo " <i class=\"fas fa-crown\"></i> ";
    if($infoatt1 + $infoatt2 == 0) echo " <i class=\"fas fa-bed\"></i> "; ?>
    </p>
    
    <label>Numero di partite</label>
    <p class="w3-blue"><?php echo $infoatt1+$infoatt2; ?></p>
    <label>Di cui vinte</label>
    <p class="w3-blue"><?php echo $infoatt1; ?></p>
    <label>Percentuale di vittorie</label>
    <p class="w3-blue"><?php echo ceil($infoatt1/($infoatt1+$infoatt2)*100); ?>%</p> 
    </div>
    
    <div class="width20collapse float">Placeholder</div>
    
    <div class="w3-card-4 width40 w3-padding float w3-margin-bottom">
    <?php
	$infodif1 = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM partite WHERE Dif1 = $id"))["cc"];
	$infodif2 = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM partite WHERE Dif2 = $id"))["cc"];
	?>
    
    <p class="w3-blue w3-card-4 w3-large">
    Difensore<br/><?php echo $gioc["PuntiD"]; 
    if($gioc["PuntiD"] >= $pointbadge) echo " <i class=\"fas fa-crown\"></i> "; 
    if($infodif1 + $infodif2 == 0) echo " <i class=\"fas fa-bed\"></i> "; ?></p>
    
    <label>Numero di partite</label>
    <p class="w3-blue"><?php echo $infodif1+$infodif2; ?></p>
    <label>Di cui vinte</label>
    <p class="w3-blue"><?php echo $infodif1; ?></p>
    <label>Percentuale di vittorie</label>
    <p class="w3-blue"><?php echo ceil($infodif1/($infodif1+$infodif2)*100); ?>%</p>
    </div>
    
</div>
	
	<div class="w3-margin-top width40 w3-large">Andamento del punteggio</div>
	<?php require("matchgraph.php"); ?>
    <br/>
	<?php require("matchlist.php"); ?>
    
    <a href="index.php"><button class="w3-button w3-blue w3-margin" type="button">« Indietro</button></a>
    
</div>

</body>
</html>