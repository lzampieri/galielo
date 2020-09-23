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

$pointbadge = trim(file_get_contents('conf/puntibadge.txt'));
$pointshit = trim(file_get_contents("conf/pointshit.txt"));
?>
<br /><br />
<div align="center">
<ul class="w3-ul w3-card-4 width80">
<li class="w3-blue">Classifica generale</li>
<li>Rientrano nella classifica generale tutti coloro che hanno giocato almeno 10 partite negli ultimi 30 giorni. Tutti gli altri sono visibili nella classifica completa, alla pagina <i>Dormienti</i><br />
Sono disponibili i seguenti badge:<br/>
<i class="fas fa-crown"></i> per chi supera i <?php echo $pointbadge; ?> punti;<br />
<i class="fas fa-blender"></i> per chi scende sotto i <?php echo $pointshit; ?> punti;<br />
<i class="fas fa-bed"></i> per i <i>dormienti</i>.<br />
</li>
<li class="w3-blue">Punti</li>
<li>Una spiegazione del metodo di assegnazione dei punti si trova <a href="texspiegazione/document.pdf">cliccando qui.</a> I punti totali sono calcolati dalla media dei punti in attacco e di quelli in difesa</li>
<li class="w3-blue">Coppia dei campioni</li>
<li>Vengono nominati vincitori della <b>Coppia dei campioni</b> coloro che riescono a battere al meglio delle tre partite la Coppia precedente (ovvero, devono aver sconfitto la precedente Coppia due volte subendo al massimo una sconfitta in mezzo).</li>
</ul></div>
</body>
</html>