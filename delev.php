<?php
if(!isset($_POST["delId"]) or !isset($_POST["VarA1"]) or !isset($_POST["VarA2"]) or !isset($_POST["VarD1"]) or !isset($_POST["VarD2"]) or !isset($_POST["idA1"]) or !isset($_POST["idA2"]) or !isset($_POST["idD1"]) or !isset($_POST["idD2"]) ) {
	header("location: /allmatch.php?elerr");	
	abort();
}
$id = $_POST["delId"];
$VarA1 = $_POST["VarA1"];
$VarA2 = $_POST["VarA2"];
$VarD1 = $_POST["VarD1"];
$VarD2 = $_POST["VarD2"];
$att1 = $_POST["idA1"];
$att2 = $_POST["idA2"];
$dif1 = $_POST["idD1"];
$dif2 = $_POST["idD2"];

require_once("script/utilities.php");
$result = query("SELECT * FROM giocatori WHERE ID IN (".$att1.", ".$att2.", ".$dif1.", ".$dif2." )");
if(mysqli_num_rows($result) != 4) {
	header("location: /allmatch.php?elerr");
	abort();
}

$eloa1;
$eloa2;
$elod1;
$elod2;
while( $row = mysqli_fetch_assoc($result) ) {
	if($row["ID"] == $att1) $eloa1=$row["PuntiA"];
	if($row["ID"] == $att2) $eloa2=$row["PuntiA"];
	if($row["ID"] == $dif1) $elod1=$row["PuntiD"];
	if($row["ID"] == $dif2) $elod2=$row["PuntiD"];
}

$eloa1 -= $VarA1;
$elod1 -= $VarD1;
$eloa2 -= $VarA2;
$elod2 -= $VarD2;

query("UPDATE giocatori SET PuntiA = ".$eloa1." WHERE ID = ".$att1);
query("UPDATE giocatori SET PuntiA = ".$eloa2." WHERE ID = ".$att2);
query("UPDATE giocatori SET PuntiD = ".$elod1." WHERE ID = ".$dif1);
query("UPDATE giocatori SET PuntiD = ".$elod2." WHERE ID = ".$dif2);

query("DELETE FROM partite WHERE ID = ".$id);
query("DELETE FROM ccup WHERE Match1 = $id OR Match2 = $id");

header("location: /allmatch.php?deleted");
?>