<?php
$canmatch = trim(file_get_contents("conf/matchenable.txt"));
if($canmatch == 0) {
	header("location: /newmatch.php");
	exit();	
}

?>

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
if(!isset($_POST["att1"]) or !isset($_POST["att2"]) or !isset($_POST["dif1"]) or !isset($_POST["dif2"]) or !isset($_POST["sq1"]) or !isset($_POST["sq2"])) {
	header("location: /newmatch.php?err");	
	abort();
}

$att1 = $_POST["att1"];
$att2 = $_POST["att2"];
$dif1 = $_POST["dif1"];
$dif2 = $_POST["dif2"];
$pti1 = $_POST["sq1"];
$pti2 = $_POST["sq2"];

if($pti2 > $pti1) {
	swap($att1,$att2);
	swap($dif1,$dif2);
	swap($pti1,$pti2);
}
if($pti1 != 10 and $pti2!= 10) {
	header("location: /newmatch.php?err_punt");
	abort();
}

if($att1 == $att2 or $att1 == $dif1 or $att1 == $dif2 or $att2 == $dif1 or $att2 == $dif2 or $dif1 == $dif2) {
	header("location: /newmatch.php?err_gioc");
	abort();
}

$att1n = "";
$att2n = "";
$dif1n = "";
$dif2n = "";
$result = query("SELECT * FROM giocatori");
while( $row = mysqli_fetch_assoc($result) ) {
	if($row["ID"] == $att1) $att1n=$row["Nome"];
	if($row["ID"] == $att2) $att2n=$row["Nome"];
	if($row["ID"] == $dif1) $dif1n=$row["Nome"];
	if($row["ID"] == $dif2) $dif2n=$row["Nome"];
}
?>

<div align="center">
<div class="width70" align="center">
    <p class="w3-blue w3-card-4 w3-large">
        Conferma partita:
    </p>
<form method="post" action="savedata.php">
    <div class="w3-card-4 w3-padding width40 float">
    	<p class="w3-blue w3-card-4 w3-large">
    		Squadra vincente
    	</p>
    
    	<label>Attaccante</label><br />
    	<input type="hidden" name="att1" value="<?php echo $att1; ?>"  />
    	<h2><b><?php echo $att1n; ?></b></h2><br />
    
    
        <label>Difensore</label><br />
        <input type="hidden" name="dif1" value="<?php echo $dif1; ?>"  />
        <h2><b><?php echo $dif1n; ?></b></h2><br />
        
        <label>Punti</label><br />
        <input type="hidden" name="sq1" value="<?php echo $pti1; ?>"  />
        <h2><b><?php echo $pti1; ?></b></h2>
    </div>
    <div class="width20collapse float">Placeholder</div>
    <div class="w3-card-4 width40 w3-padding float">
    	<p class="w3-red w3-card-4 w3-large">
			Squadra perdente
        </p>
    
    
        <label>Attaccante</label><br />
        <input type="hidden" name="att2" value="<?php echo $att2; ?>"  />
        <h2><b><?php echo $att2n; ?></b></h2><br />
        
        
        <label>Difensore</label><br />
        <input type="hidden" name="dif2" value="<?php echo $dif2; ?>"  />
        <h2><b><?php echo $dif2n; ?></b></h2><br />
        
        <label>Punti</label><br />
        <input type="hidden" name="sq2" value="<?php echo $pti2; ?>"  />
        <h2><b><?php echo $pti2; ?></b></h2>
        
    </div>
    <a href="newmatch.php"><button class="w3-button w3-blue" type="button">« Indietro</button></a>
    <br /><br />
    <button class="w3-button w3-blue" type="submit">Salva »</button>
</form>    
</div>
</div>
<br /><br />
</body>
</html>