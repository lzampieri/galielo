<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>GaliElo</title>
<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />



<?php
require_once("../script/utilities.php");
?>


<meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body class="w3-light-grey">

<?php
require("header.php");

if(array_key_exists("errIns",$_GET)) {
?>
	<div align="center"><div class="w3-card w3-red w3-margin-top width40">Errore di inserimento</div></div> <br/><br/>
<?php
}

if(array_key_exists("signed",$_GET)) {
?>
	<div align="center"><div class="w3-card w3-green w3-margin-top width40">Iscrizione effettuata con successo</div></div> <br/><br/>
<?php
}

$torns = query("SELECT * FROM tornei WHERE visib = 1 ORDER BY ID DESC LIMIT 2");
if(mysqli_num_rows($torns) == 0) {
	echo "<div align=\"center\">Nessun torneo disponibile al momento.</div>";
} else {
$torn = mysqli_fetch_assoc($torns);

if($torn["stato"] == 0) {
	echo "<br/><h2 class=\"w3-center w3-text-blue\">Campioni in carica</h2>";
	require("workers/tornwin.php");
}
else {
	if($torn["stato"] == 1) {
		echo "<h2 class=\"w3-center w3-text-blue\">Tabellone</h2>";
		require("workers/tabellone.php");
		
		echo "<br/><h2 class=\"w3-center w3-text-blue\">Classifica parziale</h2>";
		require("workers/classif.php");
	}
	else {
		echo "<br/><h2 class=\"w3-center w3-text-blue\">Scontri diretti</h2>";
		require("workers/directs.php");
	}
	#$torn = mysqli_fetch_assoc($torns);
	#require("workers/tornwin.php");
}
}
?>
<br /><br />
</body>
</html>