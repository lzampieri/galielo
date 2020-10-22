<?php
session_start();
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		

require_once("../script/utilities.php");

$tid = $_GET["tid"];

if(array_key_exists("oniscr",$_GET))
	query("UPDATE tornei SET iscr = 1 WHERE ID = $tid");
	
if(array_key_exists("offiscr",$_GET))
	query("UPDATE tornei SET iscr = 0 WHERE ID = $tid");
	
if(array_key_exists("onvis",$_GET))
	query("UPDATE tornei SET visib = 1 WHERE ID = $tid");
	
if(array_key_exists("offvis",$_GET))
	query("UPDATE tornei SET visib = 0 WHERE ID = $tid");

$admincose = 1;

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Amministrazione - GaliElo</title>

<link rel="stylesheet" type="text/css" href="../css/w3.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
<script defer src="https://use.fontawesome.com/releases/v5.0.9/js/all.js" integrity="sha384-8iPTk2s/jMVj81dnzb/iFR2sdA7u06vHJyyLlAd4snFpCl/SnyUjRrbdJsw1pGIl" crossorigin="anonymous"></script>

<meta name="viewport" content="width=device-width, initial-scale=1.0" />

</head>
<body class="w3-light-grey">
<a href="modtorns.php"><button class="w3-button w3-blue">&lt;&lt;Indietro</button></a><br />

<?php
$torns = query("SELECT * FROM tornei WHERE ID = ".$_GET["tid"]);
$sq = mysqli_fetch_assoc(query("SELECT COUNT(ID) AS cc FROM torn_sq WHERE tornID = ".$_GET["tid"]))["cc"];
 
$torn = mysqli_fetch_assoc($torns);
?>

<div align="center">
<div class="w3-card-4 w3-padding width60">
    <h2 class="w3-blue w3-card-4 w3-large"><?php echo $torn["nome"]; ?></h2>
    Inizio: <?php echo $torn["startData"]; ?><br />
    <?php if($torn["stato"] == 0) { ?>Fine: <?php echo $torn["endData"]; ?><br /> <?php } ?>
    Squadre iscritte: <?php echo $sq; ?><br />
<a href="?offiscr&tid=<?php echo $tid; ?>"><button class="w3-button w3-blue" <?php if($torn["iscr"] == 0) echo "disabled"; ?>>Disabilita iscrizioni</button></a><br />
<a href="?oniscr&tid=<?php echo $tid; ?>"><button class="w3-button w3-blue" <?php if($torn["iscr"] == 1) echo "disabled"; ?>>Abilita iscrizioni</button></a><br />
<a href="?offvis&tid=<?php echo $tid; ?>"><button class="w3-button w3-blue" <?php if($torn["visib"] == 0) echo "disabled"; ?>>Nascondi torneo</button></a><br />
<a href="?onvis&tid=<?php echo $tid; ?>"><button class="w3-button w3-blue" <?php if($torn["visib"] == 1) echo "disabled"; ?>>Mostra torneo</button></a><br />
</div></div>

<br/><br />
</div>
</body>
</html>

<?php
	} else {
		header("location: login.php");
} } else {
	header("location: login.php");
} ?>