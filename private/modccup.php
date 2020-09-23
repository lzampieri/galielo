<?php
session_start();
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		

require_once("../script/utilities.php");

if(isset($_POST["att"])) {
	query("INSERT INTO ccup(Att, Dif, Match1, Match2) VALUES (".$_POST["att"].",".$_POST["dif"].",-1,-1)");
}
if(isset($_GET["tohide"])) {
	query("UPDATE ccup SET Hidden = 1 WHERE ID = ".$_GET["tohide"]);
}

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


<?php
$select = "";
$result = query("SELECT * FROM giocatori ORDER BY Nome");
while( $row = mysqli_fetch_assoc($result) ) {
	$select .= ("<option value=\"".$row["ID"]."\">".$row["Nome"]."</option>\n");
}
?>

<div align="center">


<div class="width60 w3-center">
<a href="admin.php">
<button class="w3-button w3-blue w3-right">Indietro</button></a><br/><br/>
</div>


<div class="width60 w3-center">
<form method="post">
	<div class="w3-card-4 w3-padding w3-margin-bottom">
    <p class="w3-blue w3-card-4 w3-large">Nomina d'ufficio</p>
    
    <label>Attaccante</label>
    <select class="w3-select w3-margin-bottom" name="att">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <label>Difensore</label>
    <select class="w3-select w3-margin-bottom" name="dif">
    <option selected disabled>Seleziona...</option>
    <?php echo $select; ?>
    </select>
    
    <button class="w3-button w3-blue" type="submit">Salva »</button>
    </div>
</form>
</div>
<?php
require("../ccuplist.php");
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