<?php
	
require_once("../../script/utilities.php");

$sq1 = $_POST["sq1"];
$sq2 = $_POST["sq2"];
$pti1 = $_POST["pti1"];
$pti2 = $_POST["pti2"];
$tid = $_POST["tid"];
$match = $_POST["match"];

if($pti1==10)
	query("UPDATE torn_direct SET win".$match." = $sq1 , pti".$match." = $pti2 WHERE tornID = $tid");
else if($pti2==10)
	query("UPDATE torn_direct SET win".$match." = $sq2 , pti".$match." = $pti1 WHERE tornID = $tid");
else {
	header("location: ../index.php?errIns");
	return;
}
$situa = mysqli_fetch_assoc(query("SELECT * FROM torn_direct WHERE tornID = $tid"));
echo $situa["winfin"]."-".$situa["winina"];
if($situa["winfin"] != 0)
	if($situa["winina"] != 0)
		query("UPDATE tornei SET stato = 0, endData = CURRENT_TIMESTAMP WHERE ID = $tid");
header("location: ../index.php");
?>