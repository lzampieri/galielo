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
if(isset($_GET["disable"])) {
	file_put_contents("../message.php","");
?>
<div class="w3-card w3-red w3-margin-top width40">Messaggio disattivato</div> <br/><br/>
<?php
} else if(isset($_POST["title"])) {
	$string = "<div align=\"center\">\n<div class=\"w3-card w3-blue w3-margin-top w3-padding width40\">\n<h2>".$_POST["title"]."</h2>\n".$_POST["text"]."<p align=\"right\">~Krökel</p></div></div><br/>";
	file_put_contents("../message.php",$string);
?>
<div class="w3-card w3-red w3-margin-top width40">Messaggio salvato</div> <br/><br/>
<?php
}
?>

<div align="center">
<div class="width60 w3-center">
<a href="admin.php">
<button class="w3-button w3-blue w3-right">Indietro</button></a><br/><br/>
</div>

<div class="width60 w3-center w3-card-4 w3-margin-bottom">
<h2>Modifica messaggio iniziale</h2>
<form method="post">
<label>Titolo:</label>
<input class="w3-input" name="title" />
<label>Testo:</label>
<input class="w3-input" name="text" />
<button class="w3-button w3-blue" type="submit">Salva</button>
</form>
<a href="modmess.php?disable">
<button class="w3-button w3-blue w3-right">Disattiva</button></a><br/><br/>
</div>

</div>
</body>
</html>

<?php
	} else {
		header("location: login.php");
} } else {
	header("location: login.php");
} ?>