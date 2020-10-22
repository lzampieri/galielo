<?php
session_start();
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		

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
require("../header.php");
if(isset($_POST["points"])) {
	file_put_contents("../conf/puntibase.txt",$_POST["points"]);
}
if(isset($_POST["pointbadge"])) {
	file_put_contents("../conf/puntibadge.txt",$_POST["pointbadge"]);
}
if(isset($_POST["pointshit"])) {
	file_put_contents("../conf/pointshit.txt",$_POST["pointshit"]);
}
if(isset($_GET["nomatch"])) {
	file_put_contents("../conf/matchenable.txt",0);
}
if(isset($_GET["canmatch"])) {
	file_put_contents("../conf/matchenable.txt",1);
}
$points = trim(file_get_contents("../conf/puntibase.txt"));
$pointbadge = trim(file_get_contents("../conf/puntibadge.txt"));
$canmatch = trim(file_get_contents("../conf/matchenable.txt"));
$pointshit = trim(file_get_contents("../conf/pointshit.txt"));
?>
<div align="center">
<div class="width60 w3-center">
<a href="login.php?logout">
<button class="w3-button w3-blue w3-right">Logout</button></a><br/><br/>
</div>
<div class="width60 w3-center w3-card-4 w3-margin-bottom">
<a href="admin.php?nomatch">
<button class="w3-button w3-blue" <?php if($canmatch == 0) echo "disabled"; ?>>Disabilita aggiunta nuove partite</button></a><br/>
<a href="admin.php?canmatch">
<button class="w3-button w3-blue" <?php if($canmatch != 0) echo "disabled"; ?>>Abilita aggiunta nuove partite</button></a><br/><br/>
<form method="post">
<label>Punti base:</label>
<input class="w3-input" name="points" value="<?php echo $points; ?>" />
<button class="w3-button w3-blue" type="submit">Salva</button>
</form>
</div>
<div class="width60 w3-center w3-card-4">
<form method="post">
<label>Punti per avere il badge:</label>
<input class="w3-input" name="pointbadge" value="<?php echo $pointbadge; ?>" />
<button class="w3-button w3-blue" type="submit">Salva</button>
</form>
</div>
<div class="width60 w3-center w3-card-4">
<form method="post">
<label>Punti per avere il sad badge:</label>
<input class="w3-input" name="pointshit" value="<?php echo $pointshit; ?>" />
<button class="w3-button w3-blue" type="submit">Salva</button>
</form>
</div>
<br/><br/>
<a href="modmess.php">
<button class="w3-button w3-blue">Modifica messaggio iniziale</button></a><br/><br/>
<a href="modccup.php">
<button class="w3-button w3-blue">Gestione Coppa dei Campioni</button></a><br/><br/>
<a href="modtorns.php">
<button class="w3-button w3-blue">Gestione Tornei</button></a><br/><br/>
<a href="mod12h.php">
<button class="w3-button w3-blue">Gestione 12h</button></a><br/><br/>
</div>
<br /><br />
<?php
require_once("../script/utilities.php");
$admincose = 232;
$completa = 1;
require("../classif.php");
?>

<br /><br />
</body>
</html>

<?php
	} else {
		header("location: login.php");
} } else {
	header("location: login.php");
} ?>