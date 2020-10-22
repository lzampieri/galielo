<?php
if( !isset($_GET["sq"]) or !isset($_GET["tid"])) {
	header("location: 12h.php");
	exit();
}
else {
	$sq = $_GET["sq"];
	$tid = $_GET["tid"];
}

require_once("../script/utilities.php");
query("INSERT INTO p12h(torneo, sq) VALUES (".$tid.",".$sq.")");

header("location: 12h.php");

?>
