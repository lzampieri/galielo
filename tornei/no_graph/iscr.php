<?php
	
require_once("../../script/utilities.php");

$att = $_POST["att"];
$dif = $_POST["dif"];
$tid = $_POST["tid"];

if( $tid > 0 and strlen($att) > 3 and strlen($dif) > 3 ) {
	query("INSERT INTO torn_sq (tornID, att, dif) VALUES ( $tid , '$att' , '$dif' )");
	header("location: ../index.php?signed");
	}
else header("location: ../signup.php?err");

?>