<?php

// STATUS
// 0: disabled
// 1: running
// 2: ended
// 3: hidden
session_start();
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		

require_once("../script/utilities.php");

$admincose = 1;

if(array_key_exists("sq0",$_POST)) {
	if(strlen($_POST["sq0"]) > 2 && strlen($_POST["sq1"]) > 2)
		query("INSERT INTO t12h(sq0, sq1, stato) VALUES ('".$_POST["sq0"]."', '".$_POST["sq1"]."', 0)");
}

if(array_key_exists("start",$_GET))
	query("UPDATE t12h SET stato = 1 WHERE ID = ".$_GET["id"]);
	
if(array_key_exists("end",$_GET))
	query("UPDATE t12h SET stato = 2, closeTime = CURRENT_TIMESTAMP WHERE ID = ".$_GET["id"]);
	
if(array_key_exists("disable",$_GET))
	query("UPDATE t12h SET stato = 3 WHERE ID = ".$_GET["id"]);

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
<a href="admin.php"><button class="w3-button w3-blue">&lt;&lt;Indietro</button></a><br />
<div align="center">
<form class="w3-card-4 width60" method="post">
    <h2 class="w3-text-blue">Crea nuova 12h</h2>
    <input class="w3-input w3-border" name="sq0" type="text" placeholder="Nome squadra blu"><br/>
    <input class="w3-input w3-border" name="sq1" type="text" placeholder="Nome squadra rossa"><br/>
    <button class="w3-button w3-block w3-section w3-blue w3-ripple w3-padding" >Crea</button>
</form>
</div>
<?php
require("../12h/workers/list.php");
?><br/><br />
</div>
</body>
</html>

<?php
	} else {
		header("location: login.php");
} } else {
	header("location: login.php");
} ?>