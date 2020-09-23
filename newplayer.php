<?php
if(!isset($_POST["name"])) {
	header("location: /signup.php?iserr");
	abort();
}
if(strlen($_POST["name"]) < 2) {
	header("location: /signup.php?iserr");	
	abort();
}

$name = $_POST["name"];
$points = trim(file_get_contents('conf/puntibase.txt'));

require_once("script/utilities.php");

$result = query("SELECT ID FROM giocatori WHERE Nome='".$name."'");
echo "SELECT ID FROM giocatori WHERE Nome='".$name."'";
if(mysqli_num_rows($result)>0)  {
	header("location: /signup.php?giserr");
	abort();	
}

$result = query("INSERT INTO giocatori(Nome, PuntiA, PuntiD) VALUES (\"$name\", $points, $points)");
header("location: /index.php?signedup");
?>