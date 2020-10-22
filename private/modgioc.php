<?php
session_start();
if(isset($_SESSION["code"])) {
	$userkey = trim(file_get_contents("../conf/userkey.txt"));
	if($_SESSION["code"] == $userkey) {
		
if(!isset($_GET["id"]) and !isset($_POST["id"])) {
	header("location: admin.php");
}
if(isset($_POST["id"])) {
	require_once("../script/utilities.php");
	query("UPDATE giocatori SET Nome = \"".$_POST["nome"]."\", PuntiA = \"".$_POST["puntiA"]."\", PuntiD = ".$_POST["puntiD"]." WHERE ID = ".$_POST["id"]);
}
if(isset($_GET["del"])) {
	require_once("../script/utilities.php");
	query("DELETE FROM giocatori WHERE ID = ".$_GET["id"]);
	query("DELETE FROM partite WHERE Att1 = ".$_GET["id"]." OR Att2 = ".$_GET["id"]." OR Dif1 = ".$_GET["id"]." OR Dif2 = ".$_GET["id"]);
	header("location: admin.php");
}
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
require_once("../script/utilities.php");
if(isset($_GET["id"])) $id = $_GET["id"];
else $id = $_POST["id"];
$result = query("SELECT * FROM giocatori WHERE id = ".$id);
$row = mysqli_fetch_assoc($result);
?>

<div align="center">
    <div class="w3-card-4 w3-padding width40 w3-margin-bottom" al>
        <p class="w3-blue w3-card-4 w3-large">Giocatore</p>
        <form method="post">
        <input type="hidden" name="id" value="<?php echo $id; ?>" />
        	<label>Nome:</label>
        	<input type="text" name="nome" value="<?php echo $row["Nome"];?>"  />
            <br /><br />
            <label>Punti Attacco:</label>
        	<input type="number" name="puntiA" value="<?php echo $row["PuntiA"];?>"  />
            <br /><br />
            <label>Punti Difesa:</label>
        	<input type="number" name="puntiD" value="<?php echo $row["PuntiD"];?>"  />
            <br /><br />
            <button class="w3-button w3-blue" type="submit">Salva »</button><br /><br />
            <a href="modgioc.php?del&id=<?php echo $id;?>" onclick="return confirm('Sei sicuro di voler eliminare questo giocatore? Verranno eliminate tutte le partite da lui fatte, ma i punteggi degli altri giocatori rimarranno invariati. Pensaci bene prima di farlo, perché se risultano già partite fatte da questo giocatore potrebbe crearsi un bug nell\'assegnazione dei punteggi.')"><button class="w3-button w3-blue" type="button">Elimina giocatore</button></a>
        </form>
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